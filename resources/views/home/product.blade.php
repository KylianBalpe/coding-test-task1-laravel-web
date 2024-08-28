@extends('home.layout.main')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">All Products</h1>
                    </div>
                    <div class="col-sm-6">
                        <form method="GET" action="{{ route('home.product') }}"
                              class="d-flex flex-row justify-content-center align-items-center">
                            <div class="form-inline">
                                <select name="category" class="custom-select mx-2"
                                        onchange="this.form.submit()">
                                    <option selected value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option
                                            value="{{ $category->id }}" {{ $category->id == $requestCategory ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-inline">
                                <div class="input-group">
                                    <input class="form-control" type="search" name="search"
                                           placeholder="Search Product"
                                           aria-label="Search" value="{{ $searchRequest }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-dark" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <div class="row">
                    @forelse($products as $item)
                        <div class="col-md-4 col-xl-3">
                            <div class="card">
                                <div class="card-header">
                                    <img class="image img-fluid"
                                         src="{{ asset('storage/images/product/' . $item->image) }}"
                                         alt="{{ $item->name }}">
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-column">
                                        <div class="card-title font-weight-bold mb-1">
                                            {{ $item->name }}
                                        </div>
                                        <p class="m-0 text-truncate">{{ $item->description }}</p>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex flex-row justify-content-between align-items-center">
                                        <span class="m-0">Rp. {{ number_format($item->price, 0, ',', '.') }}</span>
                                        <span class="badge badge-primary px-2 py-1">{{ $item->category->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">No products found.</p>
                    @endforelse
                </div>
                <div class="d-flex justify-content-center pt-3">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
