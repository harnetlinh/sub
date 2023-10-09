<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUploads;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\DriveService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Response;
// use Response;

class GoogleDriveController extends Controller
{
    public function loginWithGoogle()
    {
        return Socialite::driver('google')->scopes([
            'https://www.googleapis.com/auth/drive.readonly',
            'https://www.googleapis.com/auth/drive.metadata',
            'https://www.googleapis.com/auth/drive.appdata',
            'https://www.googleapis.com/auth/drive.metadata.readonly',
            'https://www.googleapis.com/auth/userinfo.profile',
            'https://www.googleapis.com/auth/userinfo.email',
            'https://www.googleapis.com/auth/drive',
            'https://www.googleapis.com/auth/drive.file',
        ])->with(['access_type' => 'offline'])->redirect();
    }

    public function callbackFromGoogle()
    {
        try {
            $user = Socialite::driver('google')->user();
            $is_user = DriveService::where('email', $user->getEmail())->first();
            if (!$is_user) {
                $saveCloud = DriveService::updateOrCreate([
                    'token' => $user->token,
                ], [
                    'title' => 'Google Drive',
                    'email' => $user->getEmail(),
                    'token' => $user->token,
                    'refresh_token' => $user->refreshToken,
                    'type' =>  'Google',
                ]);
                return redirect()->route('home');
            } else {
                $is_user->update([
                    'token' => $user->token,
                    'refresh_token' => $user->refreshToken,
                ]);
                return redirect()->route('home');
            }
        } catch (\Throwable $e) {
            return redirect()->route('index')->with(['error' => $e]);
        }
    }

    public function getDriveSerive()
    {
        $result = DriveService::all();
        return [
            "status" => 200,
            "data" => $result
        ];
    }

    public function getSingleDrive($id)
    {
        $result = DriveService::find($id);

        if (session()->has('accessToken')) {
            session()->forget('accessToken');
        }

        if (session()->has('refreshToken')) {
            session()->forget('refreshToken');
        }

        session()->put('accessToken', $result->token);
        session()->put('refreshToken', $result->refresh_token);

        return [
            "status" => 200,
            "data" => $result,
        ];
    }

    public function getAllDrive()
    {
        $dir = '/';
        $recursive = false;
        $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
        // $contents = Storage::disk('google')->listFiles(['pageSize' => 100, ]);

        return [
            "status" => 200,
            "data" => $contents
        ];
    }

    public function newFolder()
    {
        $folder = request('key');
        Storage::disk('google')->makeDirectory($folder);
        return [
            "status" => 200,
            "data" => 'Success'
        ]; 
    }

    public function upLoadDrive($request)
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

            $storage = Storage::disk('google');

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

    public function getfileUpLoadCloud($key){
        $file = FileUploads::where('key', $key)->first();
        $urlFile = Storage::disk('google')->url($key);
        
        return [
            "status" => 200,
            "url" => $urlFile,
            "type" => $file->type
        ];
    }

    public function fileDownLoadCloud($key){
        $pathFile = Storage::disk('google')->get($key);

        return response($pathFile)->withHeaders(
            [
                'Content-Description' => 'File Transfer',
                'Content-Type' => 'image/png',
            ]
        );

        // return response()->make(
        //     $result,
        //     200,
        //     // ['Content-Type' => 'application/pdf'],
        //     ['Content-Type' => $result->mime_type],
        // );
    }

    public function deleteDrive($files)
    {
        $dataFile = explode(',', $files);
        Storage::disk('google')->delete($dataFile);

        return [
            "status" => 200,
            "message" => 'Success',
        ];
    }
}
