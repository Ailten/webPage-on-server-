<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // champs to send for create an instance of this model.
    protected $fillable = [
        'twitch_id',
        'twitch_access_token',  // not sur need to fillable.
        'twitch_refresh_token',  // not sur need to fillable.
        'twitch_email',
        'twitch_pseudo',
        'twitch_profile_picture',
    ];

    // champs ignored when cast into array or json (to protect secret data befor print at screen).
    protected $hidden = [
        'twitch_access_token',
        'twitch_refresh_token',
        'twitch_email',
        'remember_token',
    ];


    public function characters() {
        return $this->hasMany(Character::class);
    }
    public function inventories() {
        return $this->hasMany(Inventory::class);
    }
}
