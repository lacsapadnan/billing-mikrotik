@aware(['title' => '', 'path' => [], 'action'])
<div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">

    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack ">



        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                {{$title}}
            </h1>
            <!--end::Title-->


            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                @foreach($path as $label=>$url)
                <!--end::Item-->
                @if($loop->last)
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">{{$label}}</li>
                <!--end::Item-->
                @else
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{$url}}" class="text-muted text-hover-primary">{{$label}}</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                @endif

                @endforeach

            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
        {{$action}}
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Toolbar container-->
</div>
