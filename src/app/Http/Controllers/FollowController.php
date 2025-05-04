<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

/**
 * Class FollowController
 *
 * @package \App\Http\Controllers
 */
class FollowController extends Controller
{
    /**
     * Follow / unfollow an user's profile by the logged in user.
     *
     * @param User $user
     * @return bool
     */
    public function store(User $user)
    {
        if (auth()->user()->id == $user->id) {
            return false;
        }

        return auth()->user()->following()->toggle($user->profile);
    }
}
