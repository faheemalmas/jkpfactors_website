<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonTaskFramework extends Model
{
    use HasFactory;

    protected $table = 'common_task_frameworks';

    protected $fillable = [
    'username', 'emailaddress', 'functionname', 'file_path'
    ];
}
