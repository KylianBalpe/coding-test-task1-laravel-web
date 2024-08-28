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
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('product.index') }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i>
                                    Back
                                </a>
                            </div>
                            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="name">Product Name<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="name"
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       id="name"
                                                       placeholder="Product name" value="{{ old('name') }}">
                                                @error('name')
                                                <div class="invalid-feedback mb-1">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="name">Category<span
                                                        class="text-danger">*</span></label>
                                                <select
                                                    class="form-control select2 select2-hidden-accessible @error('category_id') is-invalid @enderror"
                                                    style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                    id="category_id"
                                                    name="category_id">
                                                    <option selected="selected" disabled>Category</option>
                                                    @foreach ($categories as $item)
                                                        <option data-id="{{ $item->id }}" value="{{ $item->id }}"
                                                                @if (old('category_id') == $item->id) selected @endif>{{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                <div class="invalid-feedback mb-1">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="description">Product Description<span
                                                        class="text-danger">*</span></label>
                                                <textarea name="description"
                                                          class="form-control @error('description') is-invalid @enderror"
                                                          id="description"
                                                          placeholder="Product description"
                                                          rows="4"
                                                >{{ old('description') }}</textarea>
                                                @error('name')
                                                <div class="invalid-feedback mb-1">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="image">Product Image<span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file"
                                                               class="custom-file-input @error('image') is-invalid @enderror"
                                                               id="image" name="image" accept="image/*">
                                                        <label class="custom-file-label" for="image">Choose product
                                                            image</label>
                                                    </div>
                                                </div>
                                                @error('image')
                                                <div class="mb-1 text-danger w-100"
                                                     style="margin-top: 0.25rem; font-size: 80%">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="price">Product Price</label>
                                                <input type="number"
                                                       class="form-control @error('price') is-invalid @enderror"
                                                       id="price"
                                                       name="price"
                                                       placeholder="Product price"
                                                       value="{{ old('price') }}">
                                                @error('price')
                                                <div class="invalid-feedback mb-1">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex flex-row justify-content-end">
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

        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endsection
