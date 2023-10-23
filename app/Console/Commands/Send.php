<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use TelegramBot\Api\Client;

class Send extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        while(true) {
            //如果不存在该消息跳过循环
            if (!Cache::has("message")) {
                continue;
            }
            $message = Cache::get("message");
            $res = DB::select("SELECT * FROM users");
            $bot = new Client(dujiaoka_config_get("bottoken"));
            foreach ($res as $item){
                $bot->sendMessage($item["uid"],$message);
            }
            Cache::add("message",null);
        }
    }
}
