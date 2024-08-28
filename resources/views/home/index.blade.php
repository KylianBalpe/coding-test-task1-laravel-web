@extends('home.layout.main')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Latest Products</h1>
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
                <div class="d-flex justify-content-center mt-4">
                    <a href="{{ route('home.product') }}" class="btn btn-outline-primary">View all products</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.confirm-delete').on('click', function (e) {
            e.preventDefault();
            Swal.fire({
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-primary'
                },
                title: 'Are you sure?',
                text: "Deleted data cannot be restored!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('form').submit();
                }
            });
        });

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });
        @if (session()->has('error'))
        Toast.fire({
            icon: "error",
            title: "{{ session('error') }}"
        });
        @endif
    </script>
@endsection
