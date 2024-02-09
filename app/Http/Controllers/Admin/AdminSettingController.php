<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AdminUserDataTable;
use App\Enum\UserType;
use App\Enum\VoucherFormat;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\SettingUserRequest;
use App\Http\Requests\Admin\Setting\SettingXenditRequest;
use App\Models\User;
use App\Support\Facades\Config;
use App\Support\Facades\Xendit;
use Illuminate\Http\Request;

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

    public function general()
    {
        $config = Config::all();
        $voucherFormats = array_column(VoucherFormat::cases(), 'name', 'value');

        return view('admin.setting.general', compact('config', 'voucherFormats'));
    }

    public function updateGeneral(Request $request)
    {
        $request->validate([
            'CompanyName' => 'required|string',
        ]);

        foreach ($request->all() as $key => $config) {
            Config::set($key, $config ?? '');
        }

        return redirect()->back()->with('success', 'General setting has been updated');

    }

    public function localisation()
    {
        $config = Config::all();

        return view('admin.setting.localisation', compact('config'));
    }

    public function updateLocalisation(Request $request)
    {
        foreach ($request->all() as $key => $config) {
            Config::set($key, $config ?? '');
        }

        return redirect()->back()->with('success', 'Localisation setting has been updated');
    }

    public function listUser(AdminUserDataTable $dataTable)
    {
        return $dataTable->render('admin.setting.user.list');
    }

    public function createUser()
    {
        $mode = 'add';
        $userTypes = collect(UserType::cases())->flatMap(fn ($type) => [$type->value => $type->label()]);

        return view('admin.setting.user.form', compact('mode', 'userTypes'));
    }

    public function storeUser(SettingUserRequest $request)
    {
        User::create($request->validated());

        return redirect()->route('admin:setting.user.index')->with('success', 'User has been created');
    }

    public function destroyUser(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'User has been deleted');
    }

    public function editUser(User $user)
    {
        $mode = 'edit';
        $userTypes = collect(UserType::cases())->flatMap(fn ($type) => [$type->value => $type->label()]);

        return view('admin.setting.user.form', compact('mode', 'userTypes', 'user'));
    }

    public function updateUser(SettingUserRequest $request, User $user)
    {
        $user->update(array_filter($request->validated()));

        return redirect()->route('admin:setting.user.index')->with('success', 'User has been updated');
    }
}
