@extends('layouts.front_layout.front_layout')
@section('content')
<div class="container bootstrap snippets bootdey">
    <div class="row">

        <div class="profile-info col-md-12">
            <div class="panel">
                <div class="bio-graph-heading">
                    Earn money with kirmaan, by referring a product to any one.
                </div>

            </div>
            <div class="panel">

                <form action="{{url('affiliate/search')}}" method="GET" class="search-form">
                    <input type="text" placeholder="Search.." class="form-control input-lg" value="{{request()->input('query')}}" name="query" id="query" minlength="3" required>
                    <button type="submit" class="affiliate_button"> Search </button>
                </form>

            </div>

            <div>

            </div>
        </div>
    </div>
</div>
@endsection