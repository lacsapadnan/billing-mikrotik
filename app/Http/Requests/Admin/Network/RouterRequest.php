<?php

namespace App\Http\Requests\Admin\Network;

use App\Models\Router;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class RouterRequest extends FormRequest
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
            'name' => 'required|min:4|max:30',
            'ip_address' => 'ip',
            'port' => 'numeric',
        ];
    }

    protected function prepareForValidation()
    {
        // extract ip address untuk divalidasi
        if (explode(':', $this->ip_address)[1]) {
            $this->merge([
                'port' => explode(':', $this->ip_address)[1],
                'ip_address' => explode(':', $this->ip_address)[0],
            ]);
        }
    }

    protected function passedValidation()
    {
        // kembalikan kembali ip address
        if ($this->port) {
            $this->merge([
                'ip_address' => $this->ip_address.':'.$this->port,
            ]);
        }
        if (Router::where('ip_address', $this->ip_address)
            ->when($this->method() == 'PATCH', fn ($query) => $query->where('id', '!=', $this->id))
            ->exists()
        ) {
            throw ValidationException::withMessages([
                'ip_address' => 'Router already exists',
            ]);
        }
    }
}
