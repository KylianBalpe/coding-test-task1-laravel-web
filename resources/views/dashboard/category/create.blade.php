@extends('dashboard.layout.main')

@section('main-content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $title_2 }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                {{ $title }}
                            </li>
                            <li class="breadcrumb-item active">
                                {{ $title_2 }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('category.index') }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i>
                                    Back
                                </a>
                            </div>
                            <form action="{{ route('category.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Category Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name"
                                               class="form-control @error('name') is-invalid @enderror" id="name"
                                               placeholder="Category name" value="{{ old('name') }}">
                                        @error('name')
                                        <div class="invalid-feedback mb-1">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $('.select2').select2()
    </script>
@endsection
