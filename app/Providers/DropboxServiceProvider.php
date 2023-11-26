<?php

namespace App\Providers;

use App\Models\DriveService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;

class DropboxServiceProvider extends ServiceProvider
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
            Storage::extend('dropbox', function (Application $app, array $config) {

                $email = 'linhhn13@fpt.edu.vn';
                $drive = DriveService::where('email', $email)->where('title', 'Dropbox')->first();

                $client = new DropboxClient($drive->token);
                $adapter = new DropboxAdapter($client);
                $filesystem = new Filesystem($adapter);


                return new FilesystemAdapter($filesystem, $adapter);
            });
        } catch (\Throwable $th) {
            Log::error("DropboxServiceProvider: " . $th->getLine() . ' ' . $th->getMessage());
            throw new \Exception($th->getMessage());
        }

    }
}
