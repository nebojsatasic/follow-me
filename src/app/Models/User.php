<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Creating the default profile and sending the welcome email after a new user is registered.
     *
     *@ return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($user) {
            $user->profile()->create([
                'title' => $user->username
            ]);

            Mail::to($user->email)->send(new WelcomeMail());
        });
    }

    /**
     * Get the profile associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne;
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Get the posts that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany;
     */
    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    /**
     * Get the profiles that the user is following.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany;
     */
    public function following()
    {
        return $this->belongsToMany(Profile::class);
    }
}
