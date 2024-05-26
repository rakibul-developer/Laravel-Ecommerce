@extends('backend.dashboard')
@section('title', 'Role and Permission')
@section('content')
    <div class="card card-form">
        <div class="row no-gutters justify-content-center">
            <div class="col-lg-8 card-form__body card-body">
                <form action="{{route('backend.permission.insert')}}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Add Permission:</label>
                        <input type="text" name="name" class="form-control" placeholder="Add Permission">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="card card-form">
        <div class="row no-gutters">
            <div class="col-lg-12 card-form__body card-body">
                <form action="{{route('backend.role.insert')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Add Role:</label>
                        <input type="text" class="form-control" name="name" placeholder="Add Role">
                    </div>
                    <div class="form-group">
                        <label> Select Permission :</label>
                        <br>
                        @foreach ($permissions as $permission)
                            <label class="col-lg-2 border-1">
                                <input type="checkbox" name="permission[]" value="{{$permission->id}}"> {{$permission->name}}
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
