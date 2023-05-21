<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSub extends Model
{

    use HasFactory;
    protected $fillable = [
        'subject_name',
        'subject_code',
        'subject_deprt',
        'user_id',
    ];

    protected $hidden = [
        'first_page_url',
        'next_page_url',
        'user_id',
        'path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pdf()
    {
        return $this->hasMany(StorePdf::class);
    }
}
