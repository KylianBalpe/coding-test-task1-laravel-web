@extends('dashboard.layout.main')

@section('main-content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                {{ $title }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row justify-content-between">
                                    <form method="GET" action="{{ route('product.index') }}"
                                          class="d-flex flex-row justify-content-center align-items-center">
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
                                        <div class="form-inline">
                                            <select name="category" class="custom-select mx-2"
                                                    onchange="this.form.submit()">
                                                <option selected value="">All Categories</option>
                                                @foreach($categories as $category)
                                                    <option
                                                        value="{{ $category->id }}" {{ $category->id == $categoryRequest ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </form>
                                    <a href="{{ route('product.create') }}" class="btn btn-primary mb-4">
                                        <i class="fas fa-plus mr-2"></i>
                                        Add Product
                                    </a>
                                </div>
                                <div class="table-responsive m-0    ">
                                    <table class="table table-sm table-bordered table-striped table-hover m-0">
                                        <thead>
                                        <tr>
                                            <th class="text-center" style="width: 40px">No</th>
                                            <th>Name</th>
                                            <th class="w-25">Description</th>
                                            <th>Price</th>
                                            <th>Category</th>
                                            <th class="text-center" style="width: 100px">Image</th>
                                            <th class="text-center" style="width: 260px">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($products as $item)
                                            <tr>
                                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                                <td class="align-middle">{{ $item->name }}</td>
                                                <td class="align-middle">{{ $item->description }}</td>
                                                <td class="align-middle">
                                                    Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                                <td class="align-middle">{{ $item->category->name }}</td>
                                                <td class="text-center align-middle">
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                            data-toggle="modal"
                                                            data-target="#imgModal{{ $item->id }}">
                                                        Image
                                                    </button>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <a href="{{ route('product.edit', $item->id) }}"
                                                       class="btn btn-sm btn-warning mr-2">
                                                        <span><i class="fas fa-pencil-alt mr-2"></i>Edit</span>
                                                    </a>
                                                    <form action="{{ route('product.delete', $item->id) }}"
                                                          method="post"
                                                          class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-sm btn-danger confirm-delete">
                                                            <span><i class="fas fa-trash mr-2"></i>Delete</span>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center p-5">Product data is empty</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center pt-3">
                                    {{ $products->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @foreach($products as $item)
            <div class="modal fade show" id="imgModal{{ $item->id }}" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Image of {{ $item->name }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img class="image img-fluid" src="{{ asset('storage/images/product/' . $item->image) }}"
                                 alt="{{ $item->name  }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
        @if (session()->has('success'))
        Toast.fire({
            icon: "success",
            title: "{{ session('success') }}"
        });
        @endif
    </script>
@endsection
