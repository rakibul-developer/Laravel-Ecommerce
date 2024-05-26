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
                <div class="card-body">
                    <div class="table-responsive border-bottom" data-toggle="lists">

                        <table class="table mb-0 thead-border-top-0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>color</th>
                                    <th>size</th>
                                    <th>stock</th>
                                    <th>additional_price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="staff">
                                @foreach ($inventories as $inventory)
                                    <tr>
                                        <td>{{ $inventory->id }}</td>
                                        <td>{{ $inventory->color->name }}</td>
                                        <td>{{ $inventory->size->name }}</td>
                                        <td>{{ $inventory->stock }}</td>
                                        <td>{{ $inventory->additional_price }}</td>
                                        <td>
                                            <a href="#" class="mb-1 m-1 btn btn-sm btn-primary">Edit</a>
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
                            {{-- {{ $categories->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-form__body card-body">
                    <form action="{{ route('backend.product.inventory.store') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $product->id }}" name="product_id" class="select_id">
                        <div class="form-group">
                            <label>Size:</label>
                            <select name="size" class="form-control selectTwo select_size">
                                <option disabled selected>Select</option>
                                @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                @endforeach
                            </select>

                            @error('size')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Color:</label>
                            <select name="color" class="form-control selectTwo select_color" disabled>

                            </select>

                            @error('color')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Stock:</label>
                            <input type="number" class="form-control" name="stock" placeholder="Name">
                            @error('stock')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Additional Price:</label>
                            <input type="text" class="form-control" name="additional_price"
                                placeholder="Additional Price">
                            @error('additional_price')
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
@endsection

@section('js')
    <script src="{{ asset('backend/js/select2.min.js') }}"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
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

            // ajax
            $('.select_size').on('change', function() {
                var size_id = $('.select_size').val();
                var product_id = $('.select_id').val();
                var colorBox = $('.select_color');

                colorBox.removeAttr("disabled");
                $.ajax({
                    type: 'POST',
                    url: '{{ route('backend.product.inventory.size.select') }}',
                    dataType: 'JSON',
                    data: {
                        size_id: size_id,
                        product_id: product_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        colorBox.html(data);
                    }
                });
            });


        });
    </script>
@endsection
