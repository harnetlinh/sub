<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\GoogleDriveController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layouts/homepage');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/register', function () {
//     return view('auth/register');
// });

// Route::post('/upload',function (Request $request){
//     dd($request->file("thing"));
// });

Route::get('upload-file', function() {
    Storage::disk('google')->put('test1.txt', 'Google Drive As Filesystem In Laravel');
    dd('Đã upload file lên google drive thành công!');
});
//Lấy danh sách file
Route::get('list', function() {
    $dir = '/';
    $recursive = false; // Có lấy file trong các thư mục con không?
    $contents = collect( Storage::disk('google')->listContents($dir, $recursive));
    return $contents->where('type', '=', 'file');
});
//Lấy danh sách thư mục con
Route::get('list-dir', function() {
    $dir = '/';
    $recursive = false; // Có lấy file trong các thư mục con không?
    $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
    return $contents->where('type', '=', 'dir'); // thư mục
});
//Download file từ Google Drive
Route::get('get-dir', function() {
    $filename = 'test.txt';
    $dir = '/';
    $recursive = false; // Có lấy file trong các thư mục con không?
    $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
    dd($contents);
    $file = $contents
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
        ->first(); // có thể bị trùng tên file với nhau!
    //return $file; // array with file info
    dd($file);
     $rawData = Storage::disk('google')->get($file['path']);
    return response($rawData, 200)
        ->header('Content-Type', $file['mimetype'])
        ->header('Content-Disposition', "attachment; filename='$filename'");
});

//xoá file
Route::get('delete', function() {
    $filename = 'test.txt';
    $dir = '/';
    $recursive = false; //  Có lấy file trong các thư mục con không?
    $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
    dd($contents);

    $file = $contents
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
        ->first(); // có thể bị trùng tên file với nhau!
    // Check if the file was found
    if ($file) {
        // Get the path of the file
        $filePath = $file['https://drive.google.com/file/d/1S9VSYXCJ9flbFu7aqNdjDkYYknVOlyx5/view?usp=drive_link'];

        // Delete the file using the obtained path
        Storage::disk('google')->delete($filePath);

        return 'File was deleted from Google Drive';
    } else {
        return 'File not found in Google Drive';
    }
});



Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');

Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);




// Route::prefix('google')->name('google.')->group( function(){
//     Route::get('login', [GoogleDriveController::class, 'loginWithGoogle'])->name('login');
//     Route::any('callback', [GoogleDriveController::class, 'callbackFromGoogle'])->name('callback');
// });

// Route::prefix('dropbox')->name('dropbox.')->group( function(){
//     Route::get('login', [DropboxCloudController::class, 'loginWithDropbox'])->name('login');
//     Route::any('callback', [DropboxCloudController::class, 'callbackFromDropbox'])->name('callback');
// });

// Route::get('/get-drive-serive',[
//     GoogleDriveController::class,
//     'getDriveSerive'
// ]);

// Route::get('/get-single-drive/{option}/{id}',[
//     CloudController::class,
//     'getSingleDrive'
// ]);

// Route::post('/file-upload-cloud/{option}',[
//     CloudController::class,
//     'upLoadDrive'
// ]);

// Route::post('/new-folder/{option}',[
//     CloudController::class,
//     'newFolder'
// ]);

// Route::get('/get-all-file-cloud/{option}',[
//     CloudController::class,
//     'getAllDrive'
// ]);

// Route::delete('/file-delete-cloud/{option}/{files}',[
//     CloudController::class,
//     'deleteDrive'
// ]);

// Route::get('/get-file-upLoad-cloud/{option}/{key}',[
//     CloudController::class,
//     'getfileUpLoadCloud'
// ]);

// Route::get('/file-down-load-cloud/{option}/{key}',[
//     CloudController::class,
//     'fileDownLoadCloud'
// ]);

// //Old API
// Route::get('/getAllFileUploadCloud/{option}',[
//     FileUploadController::class,
//     'getAllFileUpload'
// ]);

// Route::get('/getFileUpload/{option}/{key}',[
//     FileUploadController::class,
//     'getFileUpload'
// ]);

// Route::post('/fileUploadToCloud/{option}',[
//     FileUploadController::class,
//     'fileUploadToCloud'
// ]);

// Route::get('/fileDownLoadCloud/{option}/{key}',[
//     FileUploadController::class,
//     'fileDownLoadCloud'
// ]);

// Route::delete('/fileDeleteCloud/{option}/{key}',[
//     FileUploadController::class,
//     'fileDeleteCloud'
// ]);
