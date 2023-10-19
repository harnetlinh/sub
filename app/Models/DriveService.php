<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriveService extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','email', 'token','refresh_token','type'
    ];
}
