@include('customer.layouts.header')

<div class="container-fluid d-flex justify-content-center align-items-center full-height">
    <div class="text-center bg-white shadow main-screen pb-5">
        @yield('content')
    </div>
</div>
<div class="container-fluid d-flex justify-content-center align-items-center">
    <nav class="navbar navbar-dark bg-dark nav-width">
        <div class="d-flex justify-content-between w-100">
            <a class="navbar-brand px-4 py-3" href="{{ route('menu', request()->route('table')) }}"><i class="fa fa-home"></i></a>
            <a class="navbar-brand px-4 py-3" href="{{ route('cart', request()->route('table')) }}"><i class="fa-solid fa-cart-shopping"></i></a>
            <a class="navbar-brand px-4 py-3" href="{{ route('bill', request()->route('table')) }}"><i class="fa-solid fa-receipt"></i></a>
        </div>
    </nav>
</div>

@include('customer.layouts.footer')
