<?php

namespace App\Http\Requests\Admin\Service;

use App\Enum\PlanType;
use App\Enum\RateUnit;
use App\Enum\ValidityUnit;
use App\Models\Bandwidth;
use App\Models\Plan;
use App\Models\Pool;
use App\Models\Router;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PppoeRequest extends FormRequest
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
            'enabled' => 'boolean',
            'name' => 'required',
            'bandwidth_id' => [Rule::exists(Bandwidth::class, 'id')],
            'price' => ['required', 'integer'],
            'validity' => ['required', 'integer'],
            'validity_unit' => ['required', Rule::enum(ValidityUnit::class)],
            'router_id' => [Rule::exists(Router::class, 'id')],
            'pool_id' => ['required', Rule::exists(Pool::class, 'id'), 'nullable'],
            'pool_expired_id' => [Rule::exists(Pool::class, 'id'), 'nullable'],
        ];
    }

    protected function passedValidation()
    {
        if (Plan::where('type', PlanType::PPPOE)->where('name', $this->name)
            ->when($this->method() == 'PATCH', fn ($query) => $query->where('id', '!=', $this->id))
            ->exists()
        ) {
            throw ValidationException::withMessages(['name' => 'Pppoe name already exists']);
        }
        $bandwidth = Bandwidth::find($this->bandwidth_id);
        if ($bandwidth->rate_down_unit == RateUnit::Kbps) {
            $unitdown = 'K';
            $raddown = '000';
        } else {
            $unitdown = 'M';
            $raddown = '000000';
        }
        if ($bandwidth->rate_up_unit == RateUnit::Kbps) {
            $unitup = 'K';
            $radup = '000';
        } else {
            $unitup = 'M';
            $radup = '000000';
        }
        $this->merge([
            'rate' => $bandwidth->rate_up.$unitup.'/'.$bandwidth->rate_down.$unitdown,
            'radiusrate' => $bandwidth->rate_up.$radup.'/'.$bandwidth->rate_down.$raddown,
            'type' => PlanType::PPPOE->value,
        ]);
    }
}
