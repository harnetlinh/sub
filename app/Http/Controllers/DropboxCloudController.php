<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\FileUploads;
use App\Models\DriveService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\OAuth2\Client\Provider\GenericProvider;
use Spatie\Dropbox\Client;


class DropboxCloudController extends Controller
{
    public function loginWithDropbox()
    {

        $provider = new GenericProvider([
            'clientId'                => config('services.dropbox.app_key'),
            'clientSecret'            => config('services.dropbox.app_secret'),
            'redirectUri'             => config('services.dropbox.redirect'),
            'urlAuthorize'            => 'https://www.dropbox.com/oauth2/authorize',
            'urlAccessToken'          => 'https://api.dropbox.com/oauth2/token',
            'urlResourceOwnerDetails' => 'https://api.dropbox.com/2/users/get_current_account',
            'scopes'                  => 'account_info.read files.content.read files.content.write files.metadata.read files.metadata.write',
        ]);

        // Chuyển hướng người dùng đến trang ủy quyền truy cập Dropbox
        return redirect()->away($provider->getAuthorizationUrl());
    }

    public function callbackFromDropbox(Request $request)
    {
        try {

            $provider = new GenericProvider([
                'clientId'                => config('services.dropbox.app_key'),
                'clientSecret'            => config('services.dropbox.app_secret'),
                'redirectUri'             => config('services.dropbox.redirect'),
                'urlAuthorize'            => 'https://www.dropbox.com/oauth2/authorize',
                'urlAccessToken'          => 'https://api.dropbox.com/oauth2/token',
                'urlResourceOwnerDetails' => 'https://api.dropbox.com/2/users/get_current_account',
                'scopes'                  => 'account_info.read files.content.read files.content.write files.metadata.read files.metadata.write',
            ]);
            error_log('callbackFromDropbox');
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $request->code,
            ]);
            $token = $accessToken->getToken();
            $refreshToken = $accessToken->getRefreshToken();

            error_log('refreshToken: ' .json_encode($refreshToken, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // Kiểm tra xem yêu cầu có thành công hay không
            if ($token) {
                $client = new Client($token);
                $info = $client->getAccountInfo();
                error_log('info');
                error_log(json_encode($info, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                $is_user = DriveService::where('email', $info['email'])->where('title', 'Dropbox')->first();
                if (!$is_user) {
                    $saveCloud = DriveService::updateOrCreate([
                        'token' => $token,
                    ], [
                        'title' => 'Dropbox',
                        'email' =>  $info['email'],
                        'token' => $token,
                        'refresh_token' => $refreshToken,
                        'type' =>  'Dropbox',
                    ]);
                    return redirect()->route('home');
                } else {
                    $is_user->update([
                        'token' => $token,
                        'refresh_token' => $refreshToken,
                    ]);
                    return redirect()->route('home');
                }
            } else {
                // Xử lý lỗi nếu yêu cầu không thành công
                return redirect()->route('home')->with('error', 'Lỗi khi yêu cầu access token từ Dropbox.');
            }
        } catch (\Throwable $e) {
            dd($e->getLine() . ' - ' .$e->getMessage());
        }
    }

    public function getSingleDrive($id)
    {
        $result = DriveService::find($id);

        return [
            "status" => 200,
            "data" => $result,
        ];
    }

    public function getAllDrive()
    {

        $client = new Client(config('services.dropbox.access_token'));

        $files = $client->listFolder('/');
        return [
            "status" => 200,
            "data" => $files,
        ];
    }

    public function newFolder()
    {
        $folder = request('key');
        Storage::disk('dropbox')->makeDirectory($folder);
        return [
            "status" => 200,
            "data" => 'Success'
        ];
    }

    public function upLoadDrive(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $filenamewithextension = $request->file('file')->getClientOriginalName();

                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $extension = $request->file('file')->getClientOriginalExtension();

                //filename to store
                $filenametostore = $filename . '_' . time() . '.' . $extension;

                $file = $request->file('file');

                $size = $file->getSize();

                $type = $file->extension();

                $path = '/' . $filenametostore;

                $storage = Storage::disk('dropbox');

                $storage->putFileAs("", $file, $filenametostore);

                $url = $storage->url($path);

                FileUploads::create([
                    'key' => $filenametostore,
                    'url' => $url,
                    'size' => $size,
                    'type' => $type
                ]);

                return [
                    "status" => 200,
                    "data" => 'File uploaded to Google Drive'
                ];
            }
            return response()->json('No file selected');
        } catch (\Throwable $th) {
            Log::error("DropboxCloudController: " . $th->getLine() . ' ' . $th->getMessage());
            dd("ERROR: " . $th->getMessage());
            return [
                "status" => 500,
                "message" => $th->getMessage()
            ];
        }

    }

    public function getfileUpLoadCloud($key)
    {
        $file = FileUploads::where('key', $key)->first();
        $urlFile = Storage::disk('dropbox')->url($key);

        return [
            "status" => 200,
            "url" => $urlFile,
            "type" => $file->type
        ];
    }

    public function fileDownLoadCloud($key)
    {
        $pathFile = Storage::disk('dropbox')->get($key);

        return response($pathFile)->withHeaders(
            [
                'Content-Description' => 'File Transfer',
                'Content-Type' => 'image/png',
            ]
        );
    }

    public function deleteDrive($files)
    {
        $dataFile = explode(',', $files);
        Storage::disk('dropbox')->delete($dataFile);

        return [
            "status" => 200,
            "message" => 'Success',
        ];
    }

    public function getToken($key, $secret, $refreshToken)
    {
        error_log('getToken');
        try {
            $client = new \GuzzleHttp\Client();
            $res = $client->request("POST", "https://{$key}:{$secret}@api.dropbox.com/oauth2/token", [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                ]
            ]);
            error_log($res->getStatusCode());
            error_log('body ' . json_encode($res->getBody()));
            if ($res->getStatusCode() == 200) {
                return json_decode($res->getBody(), TRUE)['access_token'];
            } else {
                error_log(json_decode($res->getBody(), TRUE));
                return false;
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
