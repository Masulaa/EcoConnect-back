<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255' . $this->user()->id,
            'password' => 'sometimes|string|min:8|confirmed',
            'address' => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string|max:20',
            'epcg_naplatni_broj' => 'sometimes|string|max:255',
            'epcg_broj_brojila' => 'sometimes|string|max:255',
            #'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096'
        ];
    }
}
