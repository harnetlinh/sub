<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUploads;
use App\Models\DriveService;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class DropboxCloudController extends Controller
{
    public function loginWithDropbox()
    {
        return Socialite::driver('dropbox')->redirect();
    }

    public function callbackFromDropbox()
    {
        try {
            $user = Socialite::driver('dropbox')->user();
            $is_user = DriveService::where('email', $user->getEmail())->first();
            if (!$is_user) {
                $saveCloud = DriveService::updateOrCreate([
                    'token' => $user->token,
                ], [
                    'title' => 'Dropbox Cloud',
                    'email' => $user->getEmail(),
                    'token' => $user->token,
                    'refresh_token' => 'dsff',
                    'type' =>  'Dropbox',
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
            dd($e->getMessage());
            // return redirect()->route('index')->with(['error' => $e]);
        }
    }

    public function getDriveService()
    {

    }

    public function getSingleDrive($id)
    {
        $result = DriveService::find($id);

        return [
            "status" => 200,
            "data" => $result,
        ];
    }

    public function getAllDrive(){
        $dir = '/';
        $recursive = false;
        $contents = collect(Storage::disk('dropbox')->listContents($dir, $recursive));
        return [
            "status" => 200,
            "data" => $contents
        ];
    }

    public function newFolder(){
        $folder = request('key');
        Storage::disk('dropbox')->makeDirectory($folder);
        return [
            "status" => 200,
            "data" => 'Success'
        ];
    }

    public function upLoadDrive(Request $request){
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

    public function getfileUpLoadCloud($key){
        $file = FileUploads::where('key', $key)->first();
        $urlFile = Storage::disk('dropbox')->url($key);

        return [
            "status" => 200,
            "url" => $urlFile,
            "type" => $file->type
        ];
    }

    public function fileDownLoadCloud($key){
        $pathFile = Storage::disk('dropbox')->get($key);

        return response($pathFile)->withHeaders(
            [
                'Content-Description' => 'File Transfer',
                'Content-Type' => 'image/png',
            ]
        );
    }

    public function deleteDrive($files){
        $dataFile = explode(',', $files);
        Storage::disk('dropbox')->delete($dataFile);

        return [
            "status" => 200,
            "message" => 'Success',
        ];
    }
}
