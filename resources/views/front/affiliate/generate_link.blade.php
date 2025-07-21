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
                <label for="">Copy below link:</label>
                <textarea name="" id="" class="form-control input-lg" cols="30" rows="10" disabled>{{$link->shorter_link}}
                </textarea>
            </div>

            <div>

            </div>
        </div>
    </div>
</div>
@endsection