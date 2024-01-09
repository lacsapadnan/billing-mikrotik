<?php

namespace Database\Seeders;

use App\Models\AppConfig;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $values = [
            ['CompanyName', 'PHPNuxBill'],
            ['currency_code', 'Rp.'],
            ['language', 'english'],
            ['show-logo', '1'],
            ['nstyle', 'blue'],
            ['timezone', 'Asia/Jakarta'],
            ['dec_point', ','],
            ['thousands_sep', '.'],
            ['rtl', '0'],
            ['address', ''],
            ['phone', ''],
            ['date_format', 'd M Y'],
            ['note', 'Thank you...'],
        ];
        AppConfig::insert(array_map(fn ($val) => ['setting' => $val[0], 'value' => $val[1]], $values));
    }
}
