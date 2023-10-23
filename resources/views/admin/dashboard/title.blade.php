<style>
    .dashboard-title .links {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .dashboard-title .links > a {
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
        color: #fff;
    }
    .dashboard-title h1 {
        font-weight: 200;
        font-size: 2.5rem;
    }
    .dashboard-title .avatar {
        background: #fff;
        border: 2px solid #fff;
        width: 70px;
        height: 70px;
    }
</style>

<div class="dashboard-title card bg-primary">
    <div class="card-body">
        <div class="text-center ">
            <img class="avatar img-circle shadow mt-1" src="/vendor/dujiaoka-admin/images/logo.jpg">
            <div class="text-center mb-1">
                <h1 class="mb-3 mt-2 text-white">独角数卡 V{{ config('dujiaoka.dujiaoka_version', '2.0.0') }}</h1>
                <div class="links">
                    <a href="https://github.com/assimon/dujiaoka" target="_blank">Github</a>
                    <a href="https://www.oo-uu.cc" id="qq-group-link" target="_blank">技术讨论网</a>
                    <a href="http://t.me/buzhiguiqi" id="telegram-group-link" target="_blank">联系TG客服</a>
                    <a href="javascript:send()" id="demo-link">{{ __('dujiaoka.qunfa') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function send(){
        swal("请输入您要发送的内容:", {
            content: "input",
        }).then((value) => {
            $.get("/send/"+value,function(data,status){
                swal(`计划任务已开始`);
            });

        });
    }
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
