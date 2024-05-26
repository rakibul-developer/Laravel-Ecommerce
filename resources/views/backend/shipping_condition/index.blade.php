@extends('layouts.backendApp')
@section('title', 'Shipping Details')

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
                <div class="card-body tab-content">
                    <div class="table-responsive border-bottom" data-toggle="lists">

                        <table class="table mb-0 thead-border-top-0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Location</th>
                                    <th>Shipping Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="staff">
                                @foreach ($shippingConditions as $shippingCondition)
                                    <tr class="shipping_parent">
                                        <td>{{ $shippingCondition->id }}</td>
                                        <td>{{ $shippingCondition->location }}</td>
                                        <td>{{ $shippingCondition->shipping_amount }}</td>
                                        <input type="hidden" class="shipping_id" value="{{ $shippingCondition->id }}">
                                        <td>
                                            <a href="{{route('backend.shippingcondition.edit', $shippingCondition->id)}}" class="mb-1 m-1 btn btn-sm btn-primary">Edit</a>
                                            <button class="mb-1 m-1 btn btn-sm btn-info viewButton" data-toggle="modal"
                                                data-target="#viewPage">View</button>
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
                            {{-- {{ $coupons->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-form__body card-body">
                    <form action="{{ route('backend.shippingcondition.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Location:</label>
                            <input type="text" class="form-control" name="location" placeholder="Loction">
                            @error('location')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Shipping Amount:</label>
                            <input type="number" class="form-control" name="shipping_amount"
                                placeholder="Enter Shipping Amount">
                            @error('shipping_amount')
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

<!-- Modal -->
<div class="modal fade" id="viewPage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table mb-0 thead-border-top-0">
                    <h1 class="pb-3 text-center">Shipping Details</h1>
                    <tbody class="list shipping_data" id="staff">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('js')
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            var viewButton = $('.viewButton');

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

            viewButton.on('click', function() {
                var shipping_id = $(this).parents('.shipping_parent').find('.shipping_id');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('backend.shippingcondition.show') }}',
                    data: {
                        shipping_id: shipping_id.val(),
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        $('.shipping_data').html(data);
                    }
                });
            });

        });
    </script>
@endsection
