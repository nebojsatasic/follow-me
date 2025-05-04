<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Profile
 *
 * @package \App\Models
 */
class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'url',
        'image'
    ];

    /**
     * Loading profile image if it is uploaded or default image.
     *
     * @return string
     */
    public function profileImage()
    {
        $imagePath = $this->image ? $this->image : 'profile/defaultImage.jpg';

        return '/storage/' . $imagePath;
    }

    /**
     * Get the user that owns the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo;
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the users that follow the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany;
     */
    public function followers()
    {
        return $this->belongsToMany(User::class);
    }
}
