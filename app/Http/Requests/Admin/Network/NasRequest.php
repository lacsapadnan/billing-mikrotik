<?php

namespace App\Http\Requests\Admin\Network;

use App\Models\Router;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class NasRequest extends FormRequest
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
            'nasname' => 'required|min:3|max:30',
            'shortname' => 'required|max:32',
            'type' => 'required|max:30',
            'ports' => 'required|max:5',
            'secret' => 'required|max:60',
            'server' => 'required|max:64',
            'community' => 'required|max:50',
            'description' => 'max:200',
            'routers' => 'required|max:32',
        ];
    }
}
