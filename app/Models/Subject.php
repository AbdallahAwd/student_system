<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject_name',
        'subject_code',
        'subject_deprt',
        'require_subject',
        'grade',
    ];

    protected $hidden = [
        'first_page_url',
        'next_page_url',
        'path',
    ];
}
