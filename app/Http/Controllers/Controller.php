<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Returns if it's me or an administrator
     *
     * @param User $user
     * @return bool
     */
    protected function is_me(User $user) {
        $me = auth()->user();

        if( ($me->getRol() == "admin") || ($me->id == $user->id)) return true;

        return false;
    }

    /**
     * Returns if is my course
     *
     * @param Course $course
     * @return bool
     */
    protected function is_my_course(Course $course) {
        $me = auth()->user();

        switch($me->getRol()) {
            case "admin":
                return true;
            default:

                foreach($me->courses as $myCourse) {
                    if($myCourse->id == $course->id) return true;
                }
                break;
        }

        return false;
    }

    public function getAmazonUrlToken($uri) {
        if($uri == null) return null;
        $s3 = Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $expiry = "+30 minutes";

        $command = $client->getCommand('GetObject', [
            'Bucket' => config('filesystems.disks.s3.bucket'),
            'Key'    => $uri
        ]);

        $request = $client->createPresignedRequest($command, $expiry);

        return (string) $request->getUri();
    }

}
