<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'timestamp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function signOut()
    {
        return $this->hasOne(SignOut::class);
    }
}
