<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ctfDataStore extends Model
{
    use HasFactory;

    protected $table = 'ctf_data_stores';

    protected $fillable = [
        'username',
        'email',
        'institution_affiliation',
        'wrds_image',
        'wrds_image_access',
    ];
}
