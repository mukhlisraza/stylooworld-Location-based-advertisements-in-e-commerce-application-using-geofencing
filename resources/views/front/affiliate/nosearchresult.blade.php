@extends('layouts.front_layout.front_layout')
@section('content')
<div class="container bootstrap snippets bootdey">
    <div class="row">

        <div class="profile-info col-md-12">
            <div class="panel">
                <div class="bio-graph-heading">
                    Aliquam ac magna metus. Nam sed arcu non tellus fringilla fringilla ut vel ispum. Aliquam ac magna metus.
                </div>

            </div>
            <div class="panel">

                <form action="{{url('affiliate/search')}}" method="GET" class="search-form">
                    <input type="text" placeholder="Search.." class="form-control input-lg" value="{{request()->input('query')}}" name="query" id="query" minlength="3" required>
                    <button type="submit" class="affiliate_button"> Search </button>
                </form>

            </div>

            <div>
                <div class="jumbotron text-center">
                    <h1 class="display-3">Oops!</h1>

                    <p class="lead">Sorry, Requested search product not found!</p>

                    <hr>

                    <p class="lead">
                        <a class="btn btn-primary btn-sm" href="{{url('/')}}" role="button">Continue to homepage</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection