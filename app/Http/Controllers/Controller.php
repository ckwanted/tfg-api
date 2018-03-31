<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Returns if it's me or an administrator
     *
     * @param User $user
     * @return bool
     */
    public function is_me(User $user) {
        $me = auth()->user();

        if( ($me->getRol() == "admin") || ($me->id == $user->id)) return true;

        return false;
    }

}
