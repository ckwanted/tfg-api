<?php

namespace App\Http\Requests\Auth;

use App\Traits\AuthErrorRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest {

    use AuthErrorRequest;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name'              => 'required',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|string|min:4',
            'confirm_password'  => 'same:password'
        ];
    }

}
