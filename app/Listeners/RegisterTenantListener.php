<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\RegisterTenantEvent;
class RegisterTenantListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RegisterTenantEvent $event)
    {
        // dd($event->tenant->ip_address);
        $tenant = $event->tenant;
    
        $domain = escapeshellarg($tenant->domains[0]->domain);
        // Remove any quotation marks from the domain
        $domain = str_replace('"', '', $domain);
        $this->createVirtualHost($domain);
        $this->ChangeHostsFile($domain);
    }

    private function createVirtualHost($domain)
    {
        
        $configFile = 'C:/laragon/etc/apache2/sites-enabled/auto.quiz.test.conf';
    
        // Read the existing virtual host configuration file
        $config = file_get_contents($configFile);
    
       
        // Append the new virtual host configuration
        $newConfig = "
        <VirtualHost *:8084>
            DocumentRoot \"C:/laragon/www/quiz/public\"
            ServerName {$domain}.quiz.test
            ServerAlias *.{$domain}.quiz.test
            <Directory \"C:/laragon/www/quiz/public\">
                AllowOverride All
                Require all granted
            </Directory>
        </VirtualHost>
        ";
    
        // Append the new virtual host configuration to the existing file
        file_put_contents($configFile, $config . $newConfig);

        
    }

    private function ChangeHostsFile($domain)
    {
        $hostsFile = 'C:/Windows/System32/drivers/etc/hosts';
        $lineToAdd = "127.0.0.1 {$domain}.quiz.test" . PHP_EOL;

        // Open the hosts file for writing with administrative privileges
        $filePointer = fopen($hostsFile, 'a');
        if ($filePointer) {
            // Write to the hosts file
            fwrite($filePointer, $lineToAdd);
            fclose($filePointer);
        } else {
            // Handle the error when unable to open the file
            // You can log the error or display an appropriate message
        }
    }
}
