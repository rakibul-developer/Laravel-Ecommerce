@extends('layouts.backendApp')
@section('title', 'Product Category')

@section('content')
    <div class="row">
        <div class="col-lg-8 text-center m-auto">
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header card-header-tabs-basic nav" role="tablist">
                    <a href="#active" class="active" data-toggle="tab" role="tab" aria-selected="true">Active</a>
                    <a href="#deactive" data-toggle="tab" role="tab" aria-selected="false">Deactive</a>
                    <a href="#trash" data-toggle="tab" role="tab" aria-selected="false">Trash</a>
                </div>
                <div class="card-body tab-content">
                    <div class="tab-pane active show fade" id="active">
                        <div class="table-responsive border-bottom" data-toggle="lists">

                            <table class="table mb-0 thead-border-top-0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Product Count</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="staff">
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>
                                                @if ($category->image)
                                                    <img src="{{ asset('storage/category/' . $category->image) }}"
                                                        width="60" height="60px" alt="{{ $category->name }}">
                                                @else
                                                    <img src="{{ Avatar::create($category->name)->setDimension(60)->setFontSize(18)->toBase64() }}"
                                                        alt="$category->name">
                                                @endif
                                            </td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->slug }}</td>
                                            <td>{{$category->products_count}}</td>
                                            <td>
                                                <a href="#" class="mb-1 m-1 btn btn-sm btn-primary">Edit</a>
                                                <a href="#" class="mb-1 m-1 btn btn-sm btn-info">View</a>
                                                <form class="d-inline"
                                                    action="{{ route('backend.product.category.delete', $category->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="mb-1 m-1 btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @if ($category->subCategories)
                                            @foreach ($category->subCategories as $subCategory)
                                                <tr class="bg-success">
                                                    <td> -- </td>
                                                    <td>
                                                        @if ($subCategory->image)
                                                            <img src="{{ asset('storage/category/' . $subCategory->image) }}"
                                                                width="40" height="40px"
                                                                alt="{{ $subCategory->name }}">
                                                        @else
                                                            <img src="{{ Avatar::create($subCategory->name)->setDimension(40)->setFontSize(18)->toBase64() }}"
                                                                alt="$category->name">
                                                        @endif
                                                    </td>
                                                    <td>{{ $subCategory->name }}</td>
                                                    <td>{{ $subCategory->slug }}</td>
                                                    <td>{{ $subCategory->products_count }}</td>
                                                    <td>
                                                        <a href="#" class="mb-1 m-1 btn btn-sm btn-primary">Edit</a>
                                                        <a href="#" class="mb-1 m-1 btn btn-sm btn-info">View</a>
                                                        <form class="d-inline"
                                                            action="{{ route('backend.product.category.delete', $subCategory->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="mb-1 m-1 btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4 border-top pt-2">
                                {{ $categories->links() }}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="deactive">
                        Deactive
                    </div>
                    <div class="tab-pane fade" id="trash">
                        <div class="table-responsive border-bottom" data-toggle="lists">

                            <table class="table mb-0 thead-border-top-0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Product Count</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="staff">
                                    @foreach ($trashCategories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>
                                                @if ($category->image)
                                                    <img src="{{ asset('storage/category/' . $category->image) }}"
                                                        width="60" height="60px" alt="{{ $category->name }}">
                                                @else
                                                    <img src="{{ Avatar::create($category->name)->setDimension(60)->setFontSize(18)->toBase64() }}"
                                                        alt="$category->name">
                                                @endif
                                            </td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->slug }}</td>
                                            <td>0</td>
                                            <td>
                                                <a href="{{ route('backend.product.category.restore', $category->id) }}"
                                                    class="mb-1 m-1 btn btn-sm btn-info">Restore</a>
                                                <form class="d-inline"
                                                    action="{{ route('backend.product.category.parmanentDelete', $category->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="mb-1 m-1 btn btn-sm btn-danger parmanent_delete">Parmanently
                                                        Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4 border-top pt-2">
                                {{ $trashCategories->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-form__body card-body">
                    <form action="{{ route('backend.product.category.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Category Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Name">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Parent:</label>
                            <select name="parent" class="form-control selectTwo">
                                <option disabled>Select</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            @error('parent')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea name="description" cols="30" rows="5" class="form-control" placeholder="Description"></textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Image:</label>
                            <input type="file" class="form-control" name="image">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link type="text/css" href="{{ asset('backend/css/select2.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('backend/css/sweetalert2.min.css') }}" rel="stylesheet">
@endsection

@section('js')
    <script src="{{ asset('backend/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/js/sweetalert2.min.js') }}"></script>
    <script>
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
