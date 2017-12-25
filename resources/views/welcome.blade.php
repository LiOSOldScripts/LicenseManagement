@extends('layouts.app')

@section('content')
<div id="welcome">
    <div class="jumbotron">
        <div class="container">
            <h1 class="jumbotron__header">Welcome!</h1>

            <p class="jumbotron__body">
                Welcome to PUSHER - It allows you to manage all your ordered license-keys. For questions please create a account and ask our support.
            </p>
        </div>
    </div>

    <div class="container">
        <ol class="steps">
            <li class="steps__item">
                <div class="body">
                    <h2>Create a account</h2>

                    <p>
                        <a href="http://pasternt.storage-plan.org/auth/register">Register here</a> and <a href="">login</a> afterwards
                    </p>
                </div>
            </li>

            <li class="steps__item">
                <div class="body">
                    <h2>Master Your Craft</h2>

                    <p>
                        Ready to keep learning more about Laravel? Start here:
                    </p>

                    <ul>
                        <li><a href="http://laravel.com/docs">Laravel Documentation</a></li>
                        <li><a href="https://laracasts.com">Laravel 5 From Scratch (via Laracasts)</a></li>
                    </ul>
                </div>
            </li>

            <li class="steps__item">
                <div class="body">
                    <h2>Forge Ahead</h2>

                    <p>
                        When you're finished building your application, Laravel still has your back. Check out <a href="https://forge.laravel.com">Laravel Forge</a>.
                    </p>
                </div>
            </li>
        </ol>
    </div>
</div>
@stop
