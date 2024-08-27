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
                                <div class="d-flex flex-row justify-content-end">
                                    <a href="{{ route('category.create') }}" class="btn btn-primary mb-4">
                                        <i class="fas fa-plus mr-2"></i>
                                        Add Category
                                    </a>
                                </div>
                                <div class="table-responsive m-0    ">
                                    <table class="table table-sm table-bordered table-striped table-hover m-0">
                                        <thead>
                                        <tr>
                                            <th class="text-center" style="width: 40px">No</th>
                                            <th>Name</th>
                                            <th class="text-center" style="width: 260px">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($categories as $item)
                                            <tr>
                                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                                <td class="align-middle">{{ $item->name }}</td>
                                                <td class="text-center align-middle">
                                                    <a href="{{ route('category.edit', $item->id) }}"
                                                       class="btn btn-sm btn-warning mr-2">
                                                        <span><i class="fas fa-pencil-alt mr-2"></i>Edit</span>
                                                    </a>
                                                    <form action="{{ route('category.delete', $item->id) }}"
                                                          method="post"
                                                          class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-sm btn-danger confirm-delete">
                                                            <span><i class="fas fa-trash mr-2"></i>Hapus</span>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center p-5">Category data is empty</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center pt-3">
                                    {{ $categories->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
