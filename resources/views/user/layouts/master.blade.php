<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title'){{ config('app.name') }}</title>
    <meta charset="utf-8"/>
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.png') }}"/>
    <meta name="viewport" content="width=device-width, shrink-to-fit=no"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>

    <link id="themePlugin" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link id="themeBundle" href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('assets/plugins/custom/selectpicker/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>

    @yield('customStyles')

</head>

<body id="kt_body" class="header-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">

<div id="loader"></div>

@include('user.layouts.modals.quickActions')

<div class="d-flex flex-column flex-root" id="rootDocument">
    <div class="page d-flex flex-row flex-column-fluid">

        @include('user.layouts.sidebar')
        @include('user.layouts.body')

    </div>
</div>

<div class="hideIfMobile">
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black"/>
                <path
                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                    fill="black"/>
            </svg>
        </span>
    </div>
</div>

<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/jquery.touchSwipe.js') }}"></script>

<script src="{{ asset('assets/js/custom.js') }}"></script>

<script src="{{ asset('assets/plugins/custom/selectpicker/js/bootstrap-select.js') }}"></script>


<script>



</script>

@yield('customScripts')

</body>
</html>
