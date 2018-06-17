<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\CartRequest;
use Illuminate\Support\Facades\DB;

class CartController extends Controller {

    /**
     * Pay for the cart
     *
     * @param CartRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pay(CartRequest $request) {

        DB::beginTransaction();

        auth()->user()->payments()->sync($request->courses);

        DB::commit();

        return response()->json([
            'message' => 'completed correctly'
        ]);

    }

}
