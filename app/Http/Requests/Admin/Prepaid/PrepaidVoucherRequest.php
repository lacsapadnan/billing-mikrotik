<?php

namespace App\Http\Requests\Admin\Prepaid;

use App\Enum\VoucherFormat;
use App\Models\Plan;
use App\Models\Router;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PrepaidVoucherRequest extends FormRequest
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
            'router_id' => ['required', Rule::exists(Router::class, 'id')],
            'plan_id' => ['required', Rule::exists(Plan::class, 'id')],
            'count' => ['required', 'integer', 'min:1'],
            'format' => ['required', Rule::enum(VoucherFormat::class)],
            'length' => ['required', 'integer', 'min:5'],
            'prefix' => ['nullable', 'string'],
        ];
    }
}
