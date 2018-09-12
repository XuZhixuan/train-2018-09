@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5>所有小组</h5>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">组名</th>
                        <th scope="col">域名</th>
                        <th scope="col">创建于</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groups as $group)
                        <tr>
                            <th scope="row">{{ $group->id }}</th>
                            <td>{{ $group->name }}</td>
                            <td><a href="{{ $group->domain_name }}">{{ $group->domain_name }}</a></td>
                            <td>{{ $group->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {!! $groups->render() !!}
    </div>
@endsection