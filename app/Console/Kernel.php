<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\OrderStatusCommand::class, //订单过期状态跑批
        Commands\YjdPullCommand::class, //一键结果
        Commands\YjdPushCommand::class, //一键贷数据推送跑批
        Commands\ChannelUserCountCommand::class,//渠道用户统计
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:orderstatus')->everyTenMinutes(); //订单过期状态跑批,10分钟
        $schedule->command('command:yjdpull')->everyFiveMinutes(); //一键贷结果获取，5分钟
        //$schedule->command('command:yjdpush')->everyFiveMinutes(); //一键贷数据推送跑批，5分钟
        $schedule->command('command:yjdpush')->everyMinute(); //一键贷数据推送跑批，1分钟
        $schedule->command('command:tasknotactivehandle')->everyTenMinutes(); //task表未激活状态跑批处理,10分钟
        $schedule->command('command:channelusercount')->dailyAt('01:00'); //每天01:00统计前一天的数据
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
