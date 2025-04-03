<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'timestamp',
        'sign_in_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function signIn()
    {
        return $this->belongsTo(SignIn::class);
    }
}
