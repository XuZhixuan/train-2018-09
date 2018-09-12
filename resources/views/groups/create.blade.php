@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5>创建小组</h5>
        </div>
        <div class="panel-body">
            <form action="{{ route('groups.store') }}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name">小组名称：</label>
                    <input class="form-control" type="text" name="name" placeholder="仅支持英文">
                </div>
                <div class="form-group">
                    <label for="member_1">成员1：</label>
                    <select class="form-control" name="member_1" id="member_1" disabled>
                            <option value="{{ Auth::id() }}" selected="selected">{{ Auth::user()->name }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="member_2">成员2：</label>
                    <select class="form-control" name="member_2" id="member_2">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">提交</button>
            </form>
        </div>
    </div>
@endsection