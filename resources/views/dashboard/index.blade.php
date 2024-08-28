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
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <div class="d-flex flex-row justify-content-between align-items-center px-5">
                                    <h4 class="m-0">Total Product</h4>
                                    <h3 class="m-0">{{ $totalProduct }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <div class="d-flex flex-row justify-content-between align-items-center px-5">
                                    <h4 class="m-0">Total Category</h4>
                                    <h3 class="m-0">{{ $totalCategory }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h4>Latest products</h4>
                                <div class="table-responsive m-0    ">
                                    <table class="table table-sm table-borderless table-striped m-0">
                                        <thead>
                                        <tr>
                                            <th class="text-center" style="width: 40px">No</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Category</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($products as $item)
                                            <tr>
                                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                                <td class="align-middle">{{ $item->name }}</td>
                                                <td class="align-middle">
                                                    Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                                <td class="align-middle">{{ $item->category->name }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center p-5">Product data is empty</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
