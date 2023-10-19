<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Google_Client;

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
                // $accessToken = 'ya29.a0AbVbY6MPgkKR6HqHl-DpnRN_mzRyfEws3ugijPWkaJntyAQFEf1HTJ4GkWGDlsweCaIJVnLG2uev7V0CLs-XrnuZKAMizsNBJr3lCI8gvVeprlre_YwdaDkSYXd8C87IxVH9oGUknVxhmWIuFFtHFT_lRkIvaCgYKAdoSARISFQFWKvPlGN1ajhLhdpxcwK0bfBbaGQ0163';
                // $refreshToken = '1//0e8IElAEGHy5XCgYIARAAGA4SNwF-L9Irw_YanODLhugJigi1jWTmMEbRAsNu78bnkfjhqIWQdHdaZYd4Z6HGL0uBvzrA4likL88';

                $accessToken = session()->get('accessToken');
                $refreshToken = session()->get('refreshToken');

                $client = new Google_Client();
                $client->setClientId($config['clientId']);
                $client->setClientSecret($config['clientSecret']);
                $client->setAccessToken($accessToken);
                $client->refreshToken($refreshToken);

                $client->addScope(array(
                    'https://www.googleapis.com/auth/drive.file',
        //            'https://www.googleapis.com/auth/plus.login',
                    'https://www.googleapis.com/auth/userinfo.email',
                    'https://www.googleapis.com/auth/drive.metadata',
                    'https://www.googleapis.com/auth/drive',
                    'https://www.googleapis.com/drive/v3/files/fileId'
                ));

                $client->addScope('email');

                $client->setAccessType("offline");

                $client->setApprovalPrompt("force");

                $options = [];

                if (!empty($config['teamDriveId'] ?? null)) {
                    $options['teamDriveId'] = $config['teamDriveId'];
                }

                $service = new \Google\Service\Drive($client);
                $adapter = new \Masbug\Flysystem\GoogleDriveAdapter($service, $config['folderId'] ?? '/', $options);
                $driver = new \League\Flysystem\Filesystem($adapter);

                return new \Illuminate\Filesystem\FilesystemAdapter($driver, $adapter);
            });
        } catch(\Exception $e) {
            dd($e->getMessage());
        }


    }
}
