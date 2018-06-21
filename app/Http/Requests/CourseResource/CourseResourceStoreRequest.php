<?php

namespace App\Http\Requests\CourseResource;

use Illuminate\Foundation\Http\FormRequest;

class CourseResourceStoreRequest extends FormRequest {

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
            'section_id'    => 'required',
            'title'         => 'required',
        ];
    }
}
