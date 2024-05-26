@extends('layouts.backendApp')
@section('title', 'Product Add')

@section('content')
    <form action="{{ route('backend.product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8 textt-center m-auto">
                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 text-center m-auto">
                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Product</h4>
                    </div>
                    <div class="card-form__body card-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                placeholder="title" value="{{ old('title') }}">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>SKU Code</label>
                            <input type="text" class="form-control @error('sku') is-invalid @enderror" name="sku"
                                placeholder="sku" value="{{ old('sku') }}">
                            @error('sku')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
                                placeholder="price" value="{{ old('price') }}">
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Sale Price</label>
                            <input type="number" class="form-control @error('sale_price') is-invalid @enderror"
                                name="sale_price" placeholder="sale price" value="{{ 'sale_price' }}">
                            @error('sale_price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Categories:</label>
                            <select name="categories[]"
                                class="form-control @error('categories') is-invalid @enderror selectTwo" multiple>
                                <option disabled>Select</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('categories')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Image:</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Product Gallery</h4>
                    </div>
                    <div class="card-form__body card-body">
                        <div class="form-group">
                            <label>Gallery Image:</label>
                            <input type="file" class="form-control @error('gallery_image') is-invalid @enderror"
                                name="gallery_image[]" multiple>
                            @error('gallery_image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="form-control bg-primary text-white">Submit</button>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Product Description</h4>
                    </div>
                    <div class="card-form__body card-body">
                        <div class="form-group">
                            <label>Short Description:</label>
                            <textarea name="short_description" cols="30" rows="3"
                                class="form-control @error('short_description') is-invalid @enderror" placeholder="Short Description">{{ old('short_description') }}</textarea>
                            @error('short_description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea name="description" cols="30" rows="5"
                                class="form-control @error('description') is-invalid @enderror summernote" placeholder="Description">{{ old('Description') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>additional information:</label>
                            <textarea name="additional_information" cols="30" rows="3"
                                class="form-control @error('additional_information') is-invalid @enderror summernote"
                                placeholder="Additional Information">{{ old('additional_information') }}</textarea>
                            @error('additional_information')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('css')
    <link type="text/css" href="{{ asset('backend/css/select2.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('backend/css/sweetalert2.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('backend/css/summernote-bs4.min.css') }}" rel="stylesheet">
@endsection

@section('js')
    <script src="{{ asset('backend/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('backend/js/summernote-bs4.min.js') }}"></script>
    <script>
        // summernote
        $('.summernote').summernote({
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.selectTwo').select2({
                placeholder: "Select Parent",
                allowClear: true
            });

            $('.parmanent_delete').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                        $(this).parent('form').submit();
                    }
                })
            });

        });
    </script>
@endsection
