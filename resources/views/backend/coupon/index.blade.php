@extends('layouts.backendApp')
@section('title', 'Coupon Details')

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
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Applicable Amount</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="staff">
                                    @foreach ($coupons as $coupon)
                                        <tr class="coupon_parent">
                                            <td>{{ $coupon->id }}</td>
                                            <td>{{ $coupon->name }}</td>
                                            <td>{{ $coupon->amount }}</td>
                                            <td>{{ $coupon->applicable_amount }}</td>
                                            <td>{{ $coupon->start_date->isoFormat('D-MMM-YYYY') }}</td>
                                            <td>{{ $coupon->end_date->isoFormat('D-MMM-YYYY') }}</td>
                                            <input type="hidden" value="{{ $coupon->id }}" class="coupon_id">
                                            <td>
                                                <a href="{{route('backend.coupon.edit', $coupon->id)}}" class="mb-1 m-1 btn btn-sm btn-primary">Edit</a>
                                                <button class="mb-1 m-1 btn btn-sm btn-info viewButton" data-toggle="modal"
                                                    data-target="#viewPage">View</button>
                                                <a href="{{ route('backend.coupon.status_deacitve', $coupon->id) }}"
                                                    class="mb-1 m-1 btn btn-sm btn-warning">Deactive</a>
                                                <form class="d-inline"
                                                    action="{{ route('backend.coupon.delete', $coupon->id) }}"
                                                    method="post">
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
                    <div class="tab-pane fade" id="deactive">
                        <table class="table mb-0 thead-border-top-0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Applicable Amount</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="staff">
                                @foreach ($deactiveCoupons as $coupon)
                                    <tr>
                                        <td>{{ $coupon->id }}</td>
                                        <td>{{ $coupon->name }}</td>
                                        <td>{{ $coupon->amount }}</td>
                                        <td>{{ $coupon->applicable_amount }}</td>
                                        <td>{{ $coupon->start_date->isoFormat('D-MMM-YYYY') }}</td>
                                        <td>{{ $coupon->end_date->isoFormat('D-MMM-YYYY') }}</td>
                                        <td>
                                            <a href="{{ route('backend.coupon.status_acitve', $coupon->id) }}"
                                                class="mb-1 m-1 btn btn-sm btn-success">Active</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="trash">
                        <div class="table-responsive border-bottom" data-toggle="lists">
                            <div class="table-responsive border-bottom" data-toggle="lists">
                                <table class="table mb-0 thead-border-top-0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th>Applicable Amount</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="staff">
                                        @foreach ($trashCoupons as $coupon)
                                            <tr>
                                                <td>{{ $coupon->id }}</td>
                                                <td>{{ $coupon->name }}</td>
                                                <td>{{ $coupon->amount }}</td>
                                                <td>{{ $coupon->applicable_amount }}</td>
                                                <td>{{ $coupon->start_date->isoFormat('D-MMM-YYYY') }}</td>
                                                <td>{{ $coupon->end_date->isoFormat('D-MMM-YYYY') }}</td>
                                                <td>
                                                    <a href="{{ route('backend.coupon.restore', $coupon->id) }}"
                                                        class="mb-1 m-1 btn btn-sm btn-info">Restore</a>
                                                    <form class="d-inline"
                                                        action="{{ route('backend.coupon.parmanentDelete', $coupon->id) }}"
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
                            </div>

                            <div class="mt-4 border-top pt-2">
                                {{-- {{ $trashCategories->links() }} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-form__body card-body">
                    <form action="{{ route('backend.coupon.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Coupon Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Name">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Amount:</label>
                            <input type="number" class="form-control" name="amount" placeholder="Enter Amount">
                            @error('amount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Applicable Amount:</label>
                            <input type="number" class="form-control" name="applicable_amount" placeholder="Enter Amount">
                            @error('applicable_amount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Start Date:</label>
                            <input type="date" class="form-control" name="start_date">
                            @error('start_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>End Date:</label>
                            <input type="date" class="form-control" name="end_date">
                            @error('end_date')
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
                    <h1 class="pb-3 text-center">Coupon Details</h1>
                    <tbody class="list coupon_data" id="staff">
                        
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
                var coupon_id = $(this).parents('.coupon_parent').find('.coupon_id');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('backend.coupon.show') }}',
                    data: {
                        coupon_id: coupon_id.val(),
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        $('.coupon_data').html(data);
                        console.log(data);
                    }
                });
            });

        });
    </script>
@endsection
