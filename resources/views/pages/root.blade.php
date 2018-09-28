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
    <div class="links">
        <hr>
        <h4>后端组学习资料</h4><br>
        <a href="https://pan.baidu.com/s/1XCL9DVpAxmajUDSag_KRbA">第一期培训视频</a>
        <a href="https://www.bilibili.com/video/av31335724">第二期培训视频</a>
        <a href="https://www.bilibili.com/video/av31949590">第三期培训视频</a>
        <a href="https://www.bilibili.com/video/av31354021">第四期培训视频</a>
        <hr>
    </div>
@endsection