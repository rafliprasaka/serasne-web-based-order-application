@extends('customer.layouts.customer')

@section('content')
<h3 class="fw-bold py-3">OUR MENU</h3>

<nav class="p-2">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      @foreach($categories as $index => $category)
        <button class="nav-link {{ $index === 0 ? 'active' : '' }}" id="nav-{{ $category->category_name }}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{ $category->category_name }}" type="button" role="tab" aria-controls="nav-{{ $category->category_name }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}">{{ $category->category_name }}</button>
      @endforeach
    </div>
</nav>
  <div class="tab-content" id="nav-tabContent">
    @foreach($categories as $index => $category)
      <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="nav-{{ $category->category_name }}" role="tabpanel" aria-labelledby="nav-{{ $category->category_name }}-tab">
        <div class="row p-2">
          @foreach($products->where('category_id', $category->id) as $product)
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                    @if ($product->product_image)
                        <img src="{{ asset('storage/' . $product->product_image) }}" alt="Product Image" style="width: 100%; height: 100px;border-radius:10px">
                    @else
                        No Image
                    @endif
                  <h6 class="product-title py-2">{{ $product->product_name }}</h6>
                  <p class="product-price">Rp {{ number_format($product->price,0,',','.') }}</p>

                  <a href="{{ route('order', ['table' => request()->route('table'), 'product' => $product->id]) }}"
                    class="btn btn-success btn-sm w-100">Add</a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endforeach
  </div>


@endsection
