<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CloudController extends Controller
{
    public $S3Cloud;
    public $GoogleCloud;
    public $DropboxCloud;

    public function __construct(S3CloudController $S3Cloud,GoogleDriveController $GoogleCloud,DropboxCloudController $DropboxCloud)
    {
        $this->S3Cloud = $S3Cloud;
        $this->GoogleCloud = $GoogleCloud;
        $this->DropboxCloud = $DropboxCloud;
    }

    public function addCloudService($option,$key){
        if ($option ==='S3'){
            return $this->S3Cloud->addCloudService($key);
        }elseif ($option =='Google'){
            return $this->GoogleCloud->addCloudService($key);
        }elseif ($option =='Dropbox'){
            return $this->DropboxCloud->addCloudService($key);
        }else{
            return response()->json("{$option}");
        }
    }

    public function getSingleDrive($option,$key){
        if ($option ==='S3'){
            return $this->S3Cloud->getSingleDrive($key);
        }elseif ($option =='Google'){
            return $this->GoogleCloud->getSingleDrive($key);
        }elseif ($option =='Dropbox'){
            return $this->DropboxCloud->getSingleDrive($key);
        }else{
            return response()->json("{$option}");
        }
    }

    public function getAllDrive($option){
        if ($option ==='S3'){
            return $this->S3Cloud->getAllDrive();
        }elseif ($option =='Google'){
            return $this->GoogleCloud->getAllDrive();
        }elseif ($option =='Dropbox'){
            return $this->DropboxCloud->getAllDrive();
        }else{
            return response()->json("{$option}");
        }
    }

    public function newFolder($option){
        if ($option ==='S3'){
            return $this->S3Cloud->newFolder();
        }elseif ($option =='Google'){
            return $this->GoogleCloud->newFolder();
        }elseif ($option =='Dropbox'){
            return $this->DropboxCloud->newFolder();
        }else{
            return response()->json("{$option}");
        }
    }

    public function upLoadDrive($option, Request $request){
        if ($option ==='S3'){
            return $this->S3Cloud->upLoadDrive($request);
        }elseif ($option =='Google'){
            return $this->GoogleCloud->upLoadDrive($request);
        }elseif ($option =='Dropbox'){
            return $this->DropboxCloud->upLoadDrive($request);
        }else{
            return response()->json("{$option}");
        }
    }

    public function getfileUpLoadCloud($option,$key){
        if ($option ==='S3'){
            return $this->S3Cloud->getfileUpLoadCloud($key);
        }elseif ($option =='Google'){
            return $this->GoogleCloud->getfileUpLoadCloud($key);
        }elseif ($option =='Dropbox'){
            return $this->DropboxCloud->getfileUpLoadCloud($key);
        }else{
            return response()->json("{$option}");
        }
    }

    public function fileDownLoadCloud($option,$key){
        if ($option ==='S3'){
            return $this->S3Cloud->fileDownLoadCloud($key);
        }elseif ($option =='Google'){
            return $this->GoogleCloud->fileDownLoadCloud($key);
        }elseif ($option =='Dropbox'){
            return $this->DropboxCloud->fileDownLoadCloud($key);
        }else{
            return response()->json("{$option}");
        }
    }

    public function deleteDrive($option,$files){
        if ($option ==='S3'){
            return $this->S3Cloud->deleteDrive($files);
        }elseif ($option =='Google'){
            return $this->GoogleCloud->deleteDrive($files);
        }elseif ($option =='Dropbox'){
            return $this->DropboxCloud->deleteDrive($files);
        }else{
            return response()->json("{$option}");
        }
    }
}
