<?php

namespace App\Http\Requests\Admin;

use App\Enum\ServiceType;
use App\Models\Customer;
use App\Support\Lang;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
            'username' => [
                'required', 'min:3', 'max:55',
                Rule::unique(Customer::class, 'username')->ignore($this->id),
            ],
            'fullname' => 'required|min:3|max:25',
            'password' => 'required|min:3|max:35',
            'pppoe_password' => 'nullable',
            'email' => 'required|email',
            'address' => 'nullable',
            'phonenumber' => 'nullable',
            'service_type' => ['required', new Enum(ServiceType::class)],
            'long' => 'nullable',
            'lat' => 'nullable',
            'ktp' => 'nullable',
        ];
    }

    protected function passedValidation()
    {
        if (empty($this->pppoe_password)) {
            $this->merge([
                'pppoe_password' => $this->password,
            ]);
        }
        $this->merge([
            'username' => Lang::phoneFormat($this->username),
            'phonenumber' => Lang::phoneFormat($this->phonenumber),
        ]);
    }
}
