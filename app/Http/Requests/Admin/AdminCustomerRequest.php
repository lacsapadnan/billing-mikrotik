<?php

namespace App\Http\Requests\Admin;

use App\Enum\ServiceType;
use App\Support\Facades\Config;
use App\Support\Lang;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AdminCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|min:3|max:55|unique:customers,username',
            'fullname' => 'required|min:3|max:25',
            'password' => 'required|min:3|max:35',
            'pppoe_password' => 'nullable',
            'email' => 'required|email',
            'address' => 'nullable',
            'phonenumber' => 'nullable',
            'service_type' => ['required', new Enum(ServiceType::class)],
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'username' => Lang::phoneFormat($this->username),
            'phonenumber' => Lang::phoneFormat($this->phonenumber),
        ]);
    }
}
