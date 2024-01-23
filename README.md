## 独角数卡整合TG机器人

搭建方式
- 安装redis，fileinfo扩展,安装好根目录下的/public/swoole_loader.so扩展,删除禁用函数proc_open
- 上传源码
- 解压源码
- 设置运行目录/public
- 设置伪静态:laravel5
- php版本7.4
- 安装好ssl
- 授权购买地址:https://faka.oo-uu.cc
- 演示机器人: https://t.me/fksqBot
- 演示后台:https://dujiao.hyperindex.tk/admin  账号:admin    密码:admin

- 更新说明:2.0.5.02  2024/1/23

- 恢复网页支付时提交优惠码优惠支付，余额支付也适用

- 恢复telegram订单通知功能

- 更新说明:2.0.5.01

新增网页使用TGID@qq.com联系方式可使用余额支付，同时TG也会发送文件给用户，前提是该用户已经发送/start给机器人，没有拉黑停用机器人

修复机器人余额支付的问题

- 自助开通会员教程

获取hash和cookie教程:https://www.oo-uu.cc/ask/219.html 右下角点击显示全部即可全部展示

在项目根目录下/ton/.env配置好ton助记词

修复epusdt支付不出马的问题

在宝塔的软件商店进程守护管理器，执行./ton/main即可，在后台自助开通会员处的api填写http://127.0.0.1:8888

- 联系客服TG:https://t.me/buzhiguiqi
