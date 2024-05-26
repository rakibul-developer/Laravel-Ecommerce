@extends('layouts.backendApp')

@section('title', 'All Products')

@section('content')
    <div class="row">
        <div class="col-lg-12">
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
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th>SKU</th>
                                        <th>Categories</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="staff">
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>
                                                @if ($product->image)
                                                    <img src="{{ asset('storage/product/' . $product->image) }}"
                                                        width="60" height="60" alt="">
                                                @else
                                                    <img src="{{ Avatar::create($product->title)->setDimension(60)->setFontSize(18)->toBase64() }}"
                                                        alt="">
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($product->title, 30, '...') }}</td>
                                            <td>{{ Str::limit($product->slug, 30, '...') }}</td>
                                            <td>{{ $product->sku }}</td>
                                            <td>
                                                @foreach ($product->categories as $category)
                                                <span class="badge badge-info">{{$category->name}}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{route('backend.product.inventory.index', $product->slug)}}" class="mb-1 m-1 btn btn-sm btn-warning">+ Inventory</a>
                                                <a href="{{route('backend.product.edit', $product->id)}}" class="mb-1 m-1 btn btn-sm btn-primary">Edit</a>
                                                <a href="#" class="mb-1 m-1 btn btn-sm btn-info">View</a>
                                                <form class="d-inline" action="" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="mb-1 m-1 btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4 border-top pt-2">
                                {{ $products->links() }}
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
                                    {{-- @foreach ($trashCategories as $category) --}}
                                    <tr>
                                        <td></td>
                                        <td>
                                            {{-- @if ($category->image)
                                                    <img src="{{ asset('storage/category/' . $category->image) }}"
                                                        width="60" height="60px" alt="{{ $category->name }}">
                                                @else
                                                    <img src="{{ Avatar::create($category->name)->setDimension(60)->setFontSize(18)->toBase64() }}"
                                                        alt="$category->name">
                                                @endif --}}
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td>0</td>
                                        <td>
                                            <a href="" class="mb-1 m-1 btn btn-sm btn-info">Restore</a>
                                            <form class="d-inline" action="" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="mb-1 m-1 btn btn-sm btn-danger parmanent_delete">Parmanently
                                                    Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    {{-- @endforeach --}}
                                </tbody>
                            </table>

                            <div class="mt-4 border-top pt-2">
                                {{-- {{ $trashCategories->links() }} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
