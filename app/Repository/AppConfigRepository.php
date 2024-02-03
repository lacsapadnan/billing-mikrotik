<?php

namespace App\Repository;

use App\Models\AppConfig;
use Illuminate\Support\Collection;

class AppConfigRepository
{
    protected Collection $config;

    public function __construct()
    {
        $this->reload();
    }

    protected function reload()
    {
        $this->config = AppConfig::pluck('value', 'setting');
    }

    public function get(string $key = null)
    {
        return @$this->config[$key] ?? '';
    }

    public function all()
    {
        return @$this->config ?? collect([]);
    }

    public function set(string $key, string $value)
    {
        AppConfig::query()->updateOrCreate(['setting' => $key], ['value' => $value]);
        $this->reload();
    }
}
