@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5>用户列表</h5>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">姓名</th>
                    <th scope="col">部门</th>
                    <th scope="col">小组</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>@if($user->department) {{ $user->department->name }} @else - @endif</td>
                        <td>@if($user->group) <a href="{{ $user->group->domain_name }}">{{ $user->group->name }}</a> @else - @endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {!! $users->render() !!}
@endsection