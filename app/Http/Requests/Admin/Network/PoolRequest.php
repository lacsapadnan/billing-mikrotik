<?php

namespace App\Http\Requests\Admin\Network;

use App\Models\Pool;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PoolRequest extends FormRequest
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
            'pool_name' => ['required', 'min:3', 'max:30', Rule::unique(Pool::class, 'pool_name')->ignore($this->id)],
            'range_ip' => 'required',
            'router_id' => 'required|integer',
        ];
    }
}
