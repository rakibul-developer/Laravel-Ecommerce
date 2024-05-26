@extends('layouts.backendApp')
@section('title', 'Product Add')

@section('content')
    <form action="{{ route('backend.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8 textt-center m-auto">
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
                                placeholder="title" value="{{ $product->title }}">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>SKU Code</label>
                            <input type="text" class="form-control @error('sku') is-invalid @enderror" name="sku"
                                placeholder="sku" value="{{ $product->sku }}">
                            @error('sku')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
                                placeholder="price" value="{{ $product->price }}">
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Sale Price</label>
                            <input type="number" class="form-control @error('sale_price') is-invalid @enderror"
                                name="sale_price" placeholder="sale price" value="{{ $product->sale_price }}">
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
                                    <option value="{{ $category->id }}"
                                        {{ in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('categories')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Image:</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="file_input"
                                name="image">
                            <div class="mt-3">
                                <img src="{{ asset('storage/product/' . $product->image) }}" id="show_img" width="100"
                                    alt="{{ $product->tilte }}">
                            </div>
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="form-control bg-primary text-white">Update</button>
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
                                class="form-control @error('short_description') is-invalid @enderror" placeholder="Short Description">{{ $product->short_description }}</textarea>
                            @error('short_description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea name="description" cols="30" rows="5"
                                class="form-control @error('description') is-invalid @enderror summernote" placeholder="Description">{{ $product->description }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>additional information:</label>
                            <textarea name="additional_information" cols="30" rows="3"
                                class="form-control @error('additional_information') is-invalid @enderror summernote"
                                placeholder="Additional Information">{{ $product->add_info }}</textarea>
                            @error('additional_information')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Product Gallery</h4>
                </div>
                <div class="card-form__body card-body">
                    <div class="form-group">
                        <label>Gallery Image:</label>
                        <input type="file" class="form-control @error('gallery_image') is-invalid @enderror"
                            name="gallery_image[]" multiple>
                        <button type="submit" class="form-control bg-primary text-white mt-3">Gallery Update</button>
                        <table class="table mt-5">
                            <tr>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($product->galleries as $gallery)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/product/' . $gallery->image) }}" width="100"
                                            alt="">
                                    </td>
                                    <td>
                                        <a href="#" class="mb-1 m-1 btn btn-sm btn-primary">Edit</a>
                                        <a href="#" class="mb-1 m-1 btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        @error('gallery_image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link type="text/css" href="{{ asset('backend/css/select2.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('backend/css/summernote-bs4.min.css') }}" rel="stylesheet">
@endsection

@section('js')
    <script src="{{ asset('backend/js/select2.min.js') }}"></script>
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
        });

        // Image Change
        let imgf = document.querySelector('#file_input');
        let output = document.querySelector('#show_img');

        imgf.addEventListener("change", function(event) {
            let tmppath = URL.createObjectURL(event.target.files[0]);
            output.src = tmppath;
        });
    </script>
@endsection
