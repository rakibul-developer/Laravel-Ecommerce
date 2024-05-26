@extends('backend.dashboard')
@section('title', 'All Role and Permission')
@section('content')
    <div class="card card-form">
        <div class="row no-gutters justify-content-center">
            <div class="col-lg-12 card-form__body">

                <div class="table-responsive border-bottom" data-toggle="lists"
                    data-lists-values="[&quot;js-lists-values-employee-name&quot;]">

                    <table class="table mb-0 thead-border-top-0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Permission</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="list" id="staff">
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @foreach ($role->permissions as $permission)
                                            <span class="btn btn-sm btn-success">{{ $permission->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @can('see role')
                                            <a href="#" class="btn btn-info">View</a>
                                        @endcan
                                        @can('edit role')
                                            <a href="{{ route('backend.role.edit', $role->id) }}" class="btn btn-info">Edit</a>
                                        @endcan
                                        @can('status role')
                                            <a href="#" class="btn btn-warning">Status</a>
                                        @endcan
                                        @can('delete role')
                                            <a href="#" class="btn btn-danger">Delete</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
