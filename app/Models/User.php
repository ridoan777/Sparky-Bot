<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
	use HasFactory, Notifiable;

	protected $guarded = [];

	protected $fillable = [
		'user_uid',

		'name',
		'role',

		'phone',
		'email',
		'email_verified_at',
		'password',
		'bio',
		'address',
		'avatar',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */

	protected $hidden = [
		'password',
		'remember_token',
		'otp',
		'otp_expiration',
		'reset_token',
	];

	// protected $hidden = [
	//     'password',
	//     'remember_token',
	//     'created_at',
	//     'updated_at',
	//     'deleted_at',
	//     'email_verified_at',
	//     'phone',
	//     'address',
	//     'bio',
	//     'otp',
	//     'otp_expiration',
	//     'reset_token',
	// ];


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

	// JWT methods
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	public function getJWTCustomClaims()
	{
		return [];
	}

	// ----------------- URL FRIENDLY IMAGE -----------------
	protected $appends = ['avatar_url'];

	public function getAvatarUrlAttribute()
	{
		if ($this->avatar){
			return Storage::url($this->avatar);
		}
		return null;
	}


	// ----------------- URL FRIENDLY IMAGE -----------------
}
