<?php

namespace App\Http\Requests\Admin\Setting;

use App\Enum\UserType;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->user_type == UserType::ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'min:3', 'max:25', Rule::unique(User::class, 'username')->ignore($this->id)],
            'fullname' => 'required|min:3|max:25',
            'password' => ['nullable', Rule::requiredIf($this->id == null), 'min:6', 'max:25', 'confirmed'],
            'user_type' => ['required', Rule::enum(UserType::class)],
        ];
    }
}
