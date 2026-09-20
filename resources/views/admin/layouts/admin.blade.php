@include('admin.layouts.header')

<div class="d-flex justify-content-between">
    <div class="col-2 bg-grey sidebar">
        @include('admin.layouts.sidebar')
    </div>
    <div class="col-10 p-4">
        @yield('content')
    </div>
</div>

@include('admin.layouts.footer')
