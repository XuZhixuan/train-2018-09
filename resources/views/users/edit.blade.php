@extends('layouts.app')

@section('content')
    @include('shared._error')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5>更改个人信息</h5>
        </div>
        <div class="panel-body">
            <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="" class="avatar-label">用户头像</label>
                    <input class="form-control-file" type="file" name="avatar">
                    <br>
                    <img src="{{ $user->avatar }}" class="thumbnail img-responsive" width="200px">
                </div>
                <div class="form-group">
                    <label for="email">邮箱：</label>
                    <input class="form-control" type="email" name="email" id="email" value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <label for="department">部门：</label>
                    <select class="form-control" name="department_id" id="department">
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" @if($department->id == $user->department_id) selected="selected" @endif>{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">提交</button>
            </form>
        </div>
    </div>
@endsection
