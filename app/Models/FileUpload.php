<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    protected $table = 'file_uploads';

    // The attributes that are mass assignable
    protected $fillable = [
        'username',
        'email',
        'model_name',
        'csv_file_path', // S3 URL of the CSV file
        'python_file_path', // S3 URL of the Python file
        'pdf_file_path', // S3 URL of the PDF file
        'original_csv_filename',
        'original_py_filename',
    ];

    // Optional: If you want to cast any attributes to specific data types
    protected $casts = [
        'csv_file_path' => 'string',
        'python_file_path' => 'string',
    ];
}
