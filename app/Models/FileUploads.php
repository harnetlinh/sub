<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUploads extends Model
{
    use HasFactory;

    protected $fillable = [
        'key', 'url','size','type', 'last_sync_at'
    ];
    protected $dates = [
        'last_sync_at',
    ];
}
