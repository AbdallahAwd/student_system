<?php

namespace App\Models;

use App\Models\UserSub;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorePdf extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'path',
        'user_sub_id',
    ];

    protected $hidden = [
        'user_sub_id',

    ];
    public function subject()
    {
        return $this->belongsTo(UserSub::class);
    }
}