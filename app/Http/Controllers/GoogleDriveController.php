<?php

namespace App\Http\Controllers;


use App\Models\FileUploads;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
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
            // return redirect()->route('index')->with(['error' => $e]);
            return response(['error' => $e->getMessage()], 500);
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
        $currentFolderPath = request('folder', '/');
        $dir = $currentFolderPath;
        $recursive = false;
        $contents = collect(Storage::disk('google')->listContents($dir, $recursive));

        return [
            "status" => 200,
            "data" => $contents,
            "current_folder" => $currentFolderPath,
        ];
    }

    public function getFolderContents($folderPath)
    {
        $dir = $folderPath;
        $recursive = false;
        $contents = collect(Storage::disk('google')->listContents($dir, $recursive));

        return [
            "status" => 200,
            "data" => $contents,
            "current_folder" => $folderPath,
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


    public function fileDownLoadCloud($key)
    {
        try {
            $currentFolderPath = request('folder', '/');
            $dir = $currentFolderPath;
            $recursive = false;
            $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
            // Lấy tệp từ Google Drive bằng key (hoặc ID)
            $file = Storage::disk('google')->get($key);

            // Lấy thông tin về tệp từ cơ sở dữ liệu (nếu bạn lưu trữ kiểu MIME)
            $fileInfo = FileUploads::where('key', $key)->first();
            $mimeType = $fileInfo ? $fileInfo->type : 'application/octet-stream';

            return response($file)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'attachment; filename="' . $key . '"');
        } catch (\Throwable $e) {
            return response(['error' => $e->getMessage()], 500);
        }
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
    public function searchFiles()
    {
        $currentFolderPath = request('folder', '/');
        $searchQuery = request('query', '');

        $dir = $currentFolderPath;
        $recursive = false;
        $contents = collect(Storage::disk('google')->listContents($dir, $recursive));

        // Lọc kết quả dựa trên truy vấn tìm kiếm
        $filteredContents = $contents->filter(function ($item) use ($searchQuery) {
            return str_contains($item['basename'], $searchQuery);
        });

        // Chuyển đổi dữ liệu thành chuỗi JSON hợp lệ
        $jsonData = json_encode([
            "status" => 200,
            "data" => $filteredContents->values(), // Chuyển đổi dữ liệu thành mảng và loại bỏ các khoảng trắng
            "current_folder" => $currentFolderPath,
        ]);

        // Trả về dữ liệu JSON hợp lệ với tiêu đề 'Content-Type' là 'application/json'
        return response($jsonData, 200)->header('Content-Type', 'application/json');
    }

}
