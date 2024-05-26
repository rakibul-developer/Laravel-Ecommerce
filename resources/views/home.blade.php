@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Users') }}</h3>
                    </div>

                    <div class="card-body">
                        {{-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif --}}

                        {{-- {{ __('You are logged in!') }} --}}

                        <table class="table">
                            <tr>
                                <th>Id</th>
                                <th>Role</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>

                                    @foreach ($user->roles as $role)
                                        <td><span class="badge bg-dark">{{ $role->name }}</span></td>
                                    @endforeach

                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @can('view')
                                            <a href="#" class="btn btn-info btn-sm">View</a>
                                        @endcan
                                        @can('edit')
                                            <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                        @endcan
                                        @can('status')
                                            <a href="#" class="btn btn-warning btn-sm">Status</a>
                                        @endcan
                                        @can('delete')
                                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
