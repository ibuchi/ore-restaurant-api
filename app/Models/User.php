<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserTypes;
use App\Observers\ObservesWrites;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory,
        Notifiable,
        HasApiTokens;

    const FULL_TEXT_COLUMNS = ['first_name', 'middle_name', 'last_name', 'phone', 'email'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

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
            'dob' => 'date'
        ];
    }

    public function isStaff(): bool
    {
        return $this->type == UserTypes::STAFF->value;
    }

    /**
     * @return Attribute
     */
    public function name(): Attribute
    {
        return Attribute::get(fn () => Str::title("$this->first_name $this->last_name"));
    }

    /**
     * @return Attribute
     */
    public function fullName(): Attribute
    {
        return Attribute::get(fn () => Str::title("$this->first_name $this->middle_name $this->last_name"));
    }

    public function token(): Attribute
    {
        return Attribute::get(
            fn () => [
                'value'  => $this->createToken("Personal access token")->plainTextToken,
                'type'    => 'Bearer',
                'expires_at' => now()->addMinutes(config('sanctum.expiration'))->toDateTimeString()
            ]
        );
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
