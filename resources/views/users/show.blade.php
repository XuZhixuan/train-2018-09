@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="media">
                        <div align="center">
                            <img class="thumbnail img-responsive" src="{{ $user->avatar }}" width="300px" height="300px">
                        </div>
                        <div class="media-body">
                            <hr>
                            <h4><strong>部门</strong></h4>
                            <p>@if($user->department) {{ $user->department->name }} @else 暂无 @endif</p>
                            <hr>
                            <h4><strong>注册于</strong></h4>
                            <p>{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                <span>
                    <h1 class="panel-title pull-left" style="font-size:30px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
                </span>
                </div>
            </div>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>我的小组</h4>
                </div>
                <div class="panel-body">
                    @if(Auth::check() && Auth::user()->group)
                        <h4><strong>小组名</strong></h4>
                        <span class="pull-right">
                            <i @if(Auth::user()->group->status) class="status-active" @else class="status-inactive" @endif></i>
                            @if(Auth::user()->group->status) Enabled @else Disabled @endif
                        </span>
                        <hr>
                        <p><a href="{{ Auth::user()->group->domain_name }}">{{ Auth::user()->group->name }}</a></p>
                        <hr>
                        @can('show', $user)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">项目</th>
                                        <th scope="col">用户名</th>
                                        <th scope="col">密码</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">FTP</th>
                                        <td>{{ Auth::user()->group->ftp_username }}</td>
                                        <td><code>{{ Auth::user()->group->ftp_password }}</code></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Database</th>
                                        <td>{{ Auth::user()->group->db_username }}</td>
                                        <td><code>{{ Auth::user()->group->db_password }}</code></td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">姓名</th>
                                        <th scope="col">部门</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(Auth::user()->group->users as $user)
                                        <tr>
                                            <th scope="row">{{ $user->id }}</th>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->department->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <h4>Dangerous Zone</h4>
                            <form action="{{ route('groups.destroy', Auth::user()->group) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-danger">退出小组</button>
                            </form>
                        @endcan
                    @else
                        <a href="{{ route('groups.create') }}">创建小组</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
