@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5>{{ $department->name }}</h5>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">姓名</th>
                    <th scope="col">小组</th>
                </tr>
                </thead>
                <tbody>
                @foreach($department->members as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td><a href="{{ route('users.show', [$user]) }}">{{ $user->name }}</a></td>
                        @if($user->group)
                            <td><a href="{{ $user->group->domain_name }}">{{ $user->group->name }}</a></td>
                        @else
                            <td><a href="#">-</a></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection