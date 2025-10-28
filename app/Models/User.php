<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmail;
use App\Notifications\ResetPassword;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    // Tambahkan relasi-relasi berikut
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Send the email verification notification.
     * 
     * MENGGUNAKAN CUSTOM NOTIFICATION - UBAH KATA-KATA EMAIL DI: app/Notifications/VerifyEmail.php
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Send the password reset notification.
     * 
     * MENGGUNAKAN CUSTOM NOTIFICATION - UBAH KATA-KATA EMAIL DI: app/Notifications/ResetPassword.php
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
