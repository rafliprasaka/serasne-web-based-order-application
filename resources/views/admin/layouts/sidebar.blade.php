<div class="d-flex flex-column">
    <div class="brand">
        <h2 class="fw-bold text-center pt-4">Serasne</h2>
    </div>
    <hr/>
    <div class="">
        <ul class="d-flex flex-column navigation">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>

            @if (in_array(auth()->user()->role, ['admin', 'cashier']))
                <li><a href="{{ route('products.index') }}"><i class="fa fa-list"></i> Products</a></li>
                <li><a href="{{ route('categories.index') }}"><i class="fa fa-list"></i> Categories</a></li>
            @endif

            @if (auth()->user()->role == 'admin')
                <li><a href="{{ route('users.index')}}"><i class="fa fa-users"></i> Users</a></li>
            @endif

            <li><a href="{{ route('tables.index')}}"><i class="fa-solid fa-utensils"></i> Table</a></li>

            <li><a href="{{ route('transactions.index')}}"><i class="fa-solid fa-file-invoice-dollar"></i> Transactions</a></li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
