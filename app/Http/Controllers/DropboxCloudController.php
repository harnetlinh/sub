<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\FileUploads;
use App\Models\DriveService;
use Illuminate\Support\Facades\Storage;
use Spatie\Dropbox\Client;


class DropboxCloudController extends Controller
{
    public function loginWithDropbox()
    {

        $authUrl = 'https://www.dropbox.com/oauth2/authorize?' .
            'client_id=' . config('services.dropbox.app_key') .
            '&redirect_uri=' . config('services.dropbox.redirect') .
            '&response_type=code';

        // Chuyển hướng người dùng đến trang ủy quyền truy cập Dropbox
        return redirect($authUrl);
    }

    public function callbackFromDropbox(Request $request)
    {
        try {

            $authorizationCode = $request->input('code');

            // Gửi yêu cầu lấy access token từ Dropbox
            $response = Http::asForm()->post('https://api.dropbox.com/oauth2/token', [
                'code' => $authorizationCode,
                'grant_type' => 'authorization_code',
                'redirect_uri' => config('services.dropbox.redirect'),
                'client_id' => config('services.dropbox.app_key'),
                'client_secret' => config('services.dropbox.app_secret'),
            ]);
            // Kiểm tra xem yêu cầu có thành công hay không
            if ($response->successful()) {
                // Lấy access token từ phản hồi của Dropbox
                $accessToken = $response->json()['access_token'];
                $accountID = 'dbid:AACAqCywY1j9teQ4o_mj6Afwr7rP8_6W-Os';

                $response = Http::withHeaders([
                    'Authorization' => "Bearer $accessToken",
                    'Content-Type' => 'application/json',
                ])->post('https://api.dropboxapi.com/2/users/get_account', [
                    'account_id' => $accountID,
                ]);

                $userEmail =  $response->json(['email']);
                $is_user = DriveService::where('email', $userEmail)->first();
                if (!$is_user) {
                    $saveCloud = DriveService::updateOrCreate([
                        'token' => $accessToken,
                    ], [
                        'title' => 'Dropbox',
                        'email' =>  $userEmail,
                        'token' => $accessToken,
                        // 'refresh_token' => $user->refreshToken,
                        'type' =>  'Dropbox',
                    ]);
                    return redirect()->route('home');
                } else {
                    $is_user->update([
                        'token' => $accessToken,
                        // 'refresh_token' => $user->refreshToken,
                    ]);
                    return redirect()->route('home');
                }
            } else {
                // Xử lý lỗi nếu yêu cầu không thành công
                return redirect()->route('home')->with('error', 'Lỗi khi yêu cầu access token từ Dropbox.');
            }
        } catch (\Throwable $e) {
            dd($e->getMessage());
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

            $storage = Storage::disk('s3');

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
}
