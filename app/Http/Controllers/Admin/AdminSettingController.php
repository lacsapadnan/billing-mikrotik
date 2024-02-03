<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\SettingXenditRequest;
use App\Support\Facades\Config;
use App\Support\Facades\Xendit;

class AdminSettingController extends Controller
{
    public function xendit()
    {
        $channels = config('payment.xendit.channels');
        $xendit = [
            'xendit_secret_key' => Config::get('xendit_secret_key'),
            'xendit_verification_token' => Config::get('xendit_verification_token'),
            'xendit_channels' => Config::get('xendit_channels') ? explode(',', Config::get('xendit_channels')) : [],
        ];

        return view('admin.setting.xendit', compact('channels', 'xendit'));
    }

    public function updateXendit(SettingXenditRequest $request)
    {
        Xendit::updateConfig($request->validated());

        return redirect()->back()->with('success', 'Xendit setting has been updated');
    }
}
