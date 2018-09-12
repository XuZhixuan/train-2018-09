@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <h1 class="dispaly-4">你好，新同学</h1>
        <p class="lead">欢迎来到新员工培训系统</p>
        <hr class="my-4">
        <p class="lead">
            @auth
                <a class="btn btn-primary btn-lg" href="{{ route('users.show', Auth::user()) }}" role="button">进入控制台</a>
            @endauth
            @guest
                    <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">现在登陆</a>
            @endguest
        </p>
        <p>更多内容敬请期待</p>
    </div>
@endsection