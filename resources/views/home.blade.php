@extends('layouts.app')

@section('content')
<section>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
            
                <h5>Welcome Back {{auth()->user()->full_name}}</h5>
                <p>Your recent courses</p>
            </div>
            <div class="col">
                <a class="nav-link" href="{{ url('/learning/my-courses')}}" >My Courses</a>
            </div>
        </div>
    </div>
</section>
@endsection
