<?php

namespace LuigiBittencourtMarzinotto\RDStation\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RDStationCommand extends Command
{
    public $signature = 'rdstation';

    protected $description = 'Configures and (optionally) populates initial data for the RD Station integration';


    public function handle(): int
    {

        $email = $this->ask('What is the RD Station account email?');
        $accountId = $this->ask('What is the RD Station account ID? (optional)', default: null);
        $tokenInicial = $this->secret('What is the initial access token? (optional, can be left blank)');

        if (! $this->confirm("Confirm creation/update for {$email}?")) {
            $this->warn('Operation canceled.');
            return self::SUCCESS;
        }
        $model = config('rdstation.models.connected_account');
        $model::updateOrCreate(
            ['email' => $email],
            [
                'account_id'    => $accountId,
                'access_token'  => $tokenInicial ?: 'placeholder',
                'refresh_token' => null,
                'expires_at'    => now()->addHour(),
                'scopes'        => ['contacts', 'deals'],
            ],
        );

        $this->info('Account linked/updated successfully.');

        return self::SUCCESS;
    }
}
