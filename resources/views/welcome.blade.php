@extends('layouts.app')

@section('content')
<div class="jumbotron jumbotron">
<div class="container-fluid">
    <h3 class="text-center">Онлайн справочник сотрудниов ОАО "Laratest" </h3>
    <div class="row justify-content-center">
        <div class="col">
            <div id="appmy2">
                <app-tree></app-tree>
            </div>  
        </div>
    </div>
</div>
</div>
@endsection
        <!-- <div class="mt-2 ">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div> -->

    </body>
</html>
