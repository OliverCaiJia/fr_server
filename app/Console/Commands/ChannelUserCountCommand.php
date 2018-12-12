<?php

namespace App\Console\Commands;

use App\Models\Orm\ChannelDataCount;
use App\Models\Orm\UserChannel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ChannelUserCountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:channelusercount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '渠道用户统计';

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
        $date = date('Y-m-d', strtotime('-1 day'));
        $start = $date.' 00:00:00';
        $end = $date.' 23:59:59';
        UserChannel::join('channel', 'user_channel.channel_id', '=', 'channel.id')
            ->select(DB::raw('count(sgd_user_channel.channel_id) as register_count'), 'user_channel.channel_id', 'channel.channel_title', 'channel.channel_nid')
            ->whereBetween('user_channel.create_at', [$start,$end])
            ->groupBy('user_channel.channel_id')
            ->chunk(100, function ($channel_res) {
                foreach ($channel_res as $channel_val) {
                    $data = [
                        'channel_title' => $channel_val['channel_title'],
                        'channel_nid' => $channel_val['channel_nid'],
                        'register_count' => $channel_val['register_count'],
                        'count_date' => date('Y-m-d'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    ChannelDataCount::insert($data);
                }
            });
    }
}
