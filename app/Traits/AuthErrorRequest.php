<?php

namespace App\Traits;

trait AuthErrorRequest {

    public function response(array $errors) {
        return response()->json([
            'error'         => 'Unauthorised',
            'status_code'   => 400
        ], 400);
    }

}