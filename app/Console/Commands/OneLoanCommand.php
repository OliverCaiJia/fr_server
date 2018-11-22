<?php

namespace App\Console\Commands;

use App\Console\Commands\AppCommand;

/**
 * @author zhaoqiying
 */
class OneLoanCommand extends AppCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'OneLoanCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an MailCommand';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment(PHP_EOL . '==' . PHP_EOL);
    }
}
