@props(['icon'=>'', 'title' => '', 'value' => '', 'color'=> '#333', 'prefix' => null, 'link' => '#', 'linkTitle' => 'Link'])
<div class="col-sm-6 col-xl-3 mb-xl-10">

    <div class="card h-lg-100 relative overflow-hidden card-widget">
        <!--begin::Body-->
        <div class="card-body d-flex justify-content-between align-items-start flex-column text-white" style="background-color: {{ $color }}">
            <!--begin::Icon-->
            <div class="m-0 absolute right-4">
                <i class="ki-duotone ki-{{ $icon }} fs-3hx text-gray-100 widget-icon transition-all duration-300">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                    <span class="path5"></span>
                </i>

            </div>
            <!--end::Icon-->

            <!--begin::Section-->
            <div class="d-flex flex-column my-7">
                <!--begin::Number-->
                <div class="fw-semibold"><span class="relative bottom-10">{{$prefix}}</span><span class="widget-value lh-1 ls-n2" style="font-size: clamp(1rem,{{20/(strlen($value)?:1)}}vw,3rem)">{{$value}}</span></div>
                <!--end::Number-->

                <div class="m-0">
                    <span class="fw-semibold fs-6 text-gray-100">{{$title}}</span>
                </div>
            </div>
            <!--end::Section-->
        </div>
                <a href="{{$link}}"  class="bg-gray-400 w-full absolute bottom-0 text-white text-center py-2 bg-opacity-50">
                    {{$linkTitle}}
                </a>
        <!--end::Body-->
    </div>

</div>
