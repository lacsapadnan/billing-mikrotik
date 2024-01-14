@section('active-menu', $activeMenu)
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LaravelNuxBill - {{ $title }}</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('includes.style')
    @stack('addon-style')
</head>

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true"
    data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true"
    data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
    class="app-default">
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            @include('partials.header')
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                @include('partials.admin.sidebar')
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <div class="d-flex flex-column flex-column-fluid">
                        <x-app.toolbar :title="$title">
                            <x-slot:action>
                                {{ @$toolbarAction }}
                            </x-slot>
                        </x-app.toolbar>
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            {{ $slot }}
                        </div>
                    </div>
                    @include('partials.footer')
                </div>
            </div>
        </div>
    </div>


    @include('includes.script')
    @stack('addon-script')

    @if (session()->has('success'))
        <script>
            let message = "{{ session('success') }}";
            Swal.fire('Success', message, 'success');
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            let message = "{{ session('error') }}";
            Swal.fire('error', message, 'error');
        </script>
    @endif
</body>

</html>
