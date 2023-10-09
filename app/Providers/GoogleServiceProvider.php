<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            Storage::extend('google', function($app, $config) {
                $options = [];
                if (!empty($config['teamDriveId'] ?? null)) {
                    $options['teamDriveId'] = $config['teamDriveId'];
                }
                $client = new \Google\Client();

                $client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
                $client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);

                // Set the actual access token and refresh token here
                $accessToken = 'ya29.a0AfB_byC5g7QJtitxkQR7Eb9P8aXBX6v5P0C4uyQVjDgoqtpcCqYPx7eY2fwT126EcFbk0csZiz09d8jFe9aspLYqTxf4Lpqn1LPd8Rjrp1ueMFL6AVavttfqKd82wP5pgQAsMCzuO3AxZd_LUfqRpLTakl-KrSrMfTf4aCgYKAcoSARISFQGOcNnC1vwumy0IetnFsI4eAjFoCQ0171';
                $refreshToken = '1//043dAmC9IHuskCgYIARAAGAQSNwF-L9IrdPg8Ywo8b2oyU2GiwI4ulDK3hK3A_rSCTEcpEDjtYkN9u9GJieUaXq1b5gvg-rTEibs';

                $client->setAccessToken([
                    'access_token' => $accessToken,
                    'refresh_token' => $refreshToken,
                ]);

                if ($client->isAccessTokenExpired()) {
                    // You may need to handle token refresh here
                    $client->fetchAccessTokenWithRefreshToken();
                    // Make sure to update the access token in your configuration
                    $accessToken = $client->getAccessToken();
                }

                $service = new \Google\Service\Drive($client);
                $adapter = new \Masbug\Flysystem\GoogleDriveAdapter($service, $config['folder'] ?? '/', $options);
                $driver  = new \League\Flysystem\Filesystem($adapter);

                return new \Illuminate\Filesystem\FilesystemAdapter($driver, $adapter);
            });
        } catch(\Exception $e) {
            dd($e->getMessage());
        }


    }
}
