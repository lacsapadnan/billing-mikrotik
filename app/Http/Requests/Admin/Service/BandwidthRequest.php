<?php

namespace App\Http\Requests\Admin\Service;

use App\Enum\RateUnit;
use App\Models\Bandwidth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BandwidthRequest extends FormRequest
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
            'name_bw' => ['required', 'min:5', 'max:15', Rule::unique(Bandwidth::class, 'name_bw')->ignore($this->id)],
            'rate_down' => 'required|integer',
            'rate_down_unit' => ['required', Rule::enum(RateUnit::class)],
            'rate_up' => 'required|integer',
            'rate_up_unit' => ['required', Rule::enum(RateUnit::class)],
        ];
    }
}
