@extends('backend.dashboard')
@section('title', 'Role Edit')
@section('content')
    <div class="card card-form">
        <div class="row no-gutters">
            <div class="col-lg-12 card-form__body card-body">
                <form action="{{route('backend.role.update', $role->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Add Role:</label>
                        <input type="text" class="form-control" name="name" value="{{$role->name}}" placeholder="Add Role">
                    </div>
                    <div class="form-group">
                        <label> Select Permission :</label>
                        <br>
                        @foreach ($permissions as $permission)
                            <label class="col-lg-2 border-1">
                                <input type="checkbox" name="permission[]" {{in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? "checked" : "" }} value="{{$permission->id}}"> {{$permission->name}}
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
