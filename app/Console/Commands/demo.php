<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('demo')]
#[Description('Command description')]
class demo extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Crone called");
    }
}
