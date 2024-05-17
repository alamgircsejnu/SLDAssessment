<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\UserSaved;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prefixname',
        'firstname',
        'middlename',
        'lastname',
        'suffixname',
        'username',
        'email',
        'password',
        'remember_token',
        'photo',
        'type',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFullnameAttribute()
    {
        return $this->firstname. ' '. $this->middlename. ' '. $this->lastname;
    }

    public function getAvatarAttribute()
    {
        return $this->photo ? asset($this->photo) : asset('media/profile_photo/default/default.jpg');
    }

    public function getMiddleinitialAttribute()
    {
        return $this->middlename ? strtoupper(substr($this->middlename, 0, 1)) . '.' : null;
    }

    protected $dispatchesEvents = [
        'saved' => UserSaved::class,
    ];

    public function details()
    {
        return $this->hasMany(Detail::class);
    }
}
