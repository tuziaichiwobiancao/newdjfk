package main

import (
	"context"
	"encoding/base64"
	"encoding/json"
	"github.com/joho/godotenv"
	"github.com/xssnick/tonutils-go/address"
	"github.com/xssnick/tonutils-go/liteclient"
	"github.com/xssnick/tonutils-go/tlb"
	"github.com/xssnick/tonutils-go/ton"
	"github.com/xssnick/tonutils-go/ton/wallet"
	"github.com/xssnick/tonutils-go/tvm/cell"
	"log"
	"net/http"
	"os"
	"strconv"
	"strings"
)

var (
	client *liteclient.ConnectionPool
	api    *ton.APIClient
	w      *wallet.Wallet
)

//作者TG：@gd801  电报交流群：@phpTRON

func main() {
	initializeApp()

	http.HandleFunc("/sendTransactions", sendTransactionsHandler)
	http.ListenAndServe(":8888", nil)
}

func initializeApp() {
	var err error
	client = liteclient.NewConnectionPool()

	//这是一个私人部署的节点 - 速度更快  担心安全我没有使用
	//err = client.AddConnection(context.Background(), "135.181.140.212:13206", "K0t3+IWLOXHYMvMcrGZDPs+pn58a17LFbnXoQkKc2xw=")
	configUrl := "https://ton-blockchain.github.io/global.config.json" // 官方转账节点 智能筛选最快节点转账
	err = client.AddConnectionsFromConfigUrl(context.Background(), configUrl)
	if err != nil {
		log.Fatalln("connection err: ", err.Error())
		return
	}
	api = ton.NewAPIClient(client)

	err = godotenv.Load()
	if err != nil {
		log.Fatalln("加载.env 文件出错", err.Error())
	}

	seedWords := os.Getenv("SEED_PHRASE")
	var words []string

	if seedWords == "" {
		log.Fatalln("配置文件内容为空")
		words = wallet.NewSeed()
		log.Println("自动生成助词器:", strings.Join(words, " "))
	} else {
		words = strings.Split(seedWords, " ")
	}

	w, err = wallet.FromSeed(api, words, wallet.V4R2)
	if err != nil {
		log.Fatalln("助词器错误:", err.Error())
		return
	}

	log.Println("钱包地址:", w.Address())
}

func sendTransactionsHandler(responseWriter http.ResponseWriter, req *http.Request) {
	sendMode, err := getSendMode(req)
	if err != nil {
		respondError(responseWriter, err)
		return
	}

	commentText := req.URL.Query().Get("comment") //从get参数中获取comment （payload）
	log.Println("交易备注:", commentText)
	txs, err := getTransactions(req)
	if err != nil {
		respondError(responseWriter, err)
		return
	}

	err = processTransactions(responseWriter, sendMode, commentText, txs)
	if err != nil {
		respondError(responseWriter, err)
	}
}

func getSendMode(req *http.Request) (uint64, error) {
	sendModeString := req.URL.Query().Get("send_mode")
	log.Println("交易模式:", sendModeString)
	return strconv.ParseUint(sendModeString, 10, 8)
}

func getTransactions(req *http.Request) (map[string]string, error) {
	var txs map[string]string
	err := json.NewDecoder(req.Body).Decode(&txs)

	if err != nil {
		log.Println("Json 接码错误 err:", err.Error())
		return nil, err
	}

	log.Println("交易:", txs)
	return txs, nil
}

func processTransactions(responseWriter http.ResponseWriter, sendMode uint64, commentText string, txs map[string]string) error {
	block, err := api.CurrentMasterchainInfo(context.Background())
	if err != nil {
		return err
	}

	balance, err := w.GetBalance(context.Background(), block)
	if err != nil {
		return err
	}

	totalAmount, err := calculateTotalAmount(txs)
	if err != nil {
		return err
	}

	if balance.NanoTON().Uint64() >= totalAmount {
		comment, err := wallet.CreateCommentCell(commentText)
		if err != nil {
			return err
		}

		messages := createMessages(sendMode, comment, txs)
		log.Println("正在发送交易并等待确认。。。")

		txHash, err := w.SendManyWaitTxHash(context.Background(), messages)
		if err != nil {
			return err
		}

		return sendSuccessResponse(responseWriter, txHash)
	}

	return notEnoughBalanceError()
}

func calculateTotalAmount(txs map[string]string) (uint64, error) {
	var totalAmount float64
	for _, amtStr := range txs {
		amtFloat, err := strconv.ParseFloat(amtStr, 64)
		if err != nil {
			return 0, err
		}
		totalAmount += amtFloat
	}

	return uint64(totalAmount * 1e9), nil
}

func createMessages(sendMode uint64, comment *cell.Cell, txs map[string]string) []*wallet.Message {
	var messages []*wallet.Message
	for addrStr, amtStr := range txs {
		messages = append(messages, &wallet.Message{
			Mode: uint8(sendMode),
			InternalMessage: &tlb.InternalMessage{
				Bounce:  false,
				DstAddr: address.MustParseAddr(addrStr),
				Amount:  tlb.MustFromTON(amtStr),
				Body:    comment,
			},
		})
	}
	//log.Println("编码数据:", comment)
	return messages
}

func sendSuccessResponse(responseWriter http.ResponseWriter, txHash []byte) error {
	log.Println("交易已上链, hash:", base64.StdEncoding.EncodeToString(txHash))
	log.Println("结果请查看: https://tonscan.org/tx/" + base64.URLEncoding.EncodeToString(txHash))

	responseWriter.Header().Set("Content-Type", "application/json")
	responseWriter.WriteHeader(http.StatusOK)
	//返回给请求端
	return json.NewEncoder(responseWriter).Encode(map[string]string{
		"txHash": base64.StdEncoding.EncodeToString(txHash),
		"link":   "https://tonscan.org/tx/" + base64.URLEncoding.EncodeToString(txHash),
	})
}

func notEnoughBalanceError() error {
	return &customError{"钱包余额不足"}
}

type customError struct {
	msg string
}

func (e *customError) Error() string {
	return e.msg
}

func respondError(responseWriter http.ResponseWriter, err error) {
	responseWriter.Header().Set("Content-Type", "application/json")
	responseWriter.WriteHeader(http.StatusBadRequest)
	json.NewEncoder(responseWriter).Encode(map[string]string{
		"error": err.Error(),
	})
}
