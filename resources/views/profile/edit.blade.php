<x-customer-layout title="Edit Profile" active-menu="profile" :path="['Edit Profile' => '']">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl sm:px-6 lg:px-8 space-y-6">
            <div class="py-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="py-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg"> --}}
            {{--     <div class="max-w-xl"> --}}
            {{--         @include('profile.partials.delete-user-form') --}}
            {{--     </div> --}}
            {{-- </div> --}}
        </div>
    </div>
</x-customer-layout>
