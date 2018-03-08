<?php

namespace App\Traits;

trait StandarErrorRequest {

    public function response(array $errors) {
        return response()->json([
            'error'         => $errors,
            'status_code'   => 400
        ], 400);
    }

}