@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col ">
            <div class="list-group mt-5">
            	@foreach ($topics as $topic)
				 <li class="list-group-item">
				    <div class="d-flex w-100 justify-content-between">
				    	<h5 class="mb-1">{{ $topic->title }}</h5>
				      	<small>{{ $topic->created_at }}</small>
				    </div>
				    <p class="mb-1">{{ $topic->description }}</p>
				  </li>
				  @endforeach
				</div>
        </div>
    </div>
</div>
@endsection
