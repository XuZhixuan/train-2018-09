@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5>所有部门</h5>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">部门</th>
                        <th scope="col">人数</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $department)
                        <tr>
                            <th scope="row">{{ $department->id }}</th>
                            <td><a href="{{ route('departments.show', [$department]) }}">{{ $department->name }}</a></td>
                            <td>{{ $department->members_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection