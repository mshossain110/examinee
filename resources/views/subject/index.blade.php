@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col ">
            <div class="list-group mt-5">
            	@foreach ($subjects as $subject)
				 <li class="list-group-item">
				    <div class="d-flex w-100 justify-content-between">
				    	<h5 class="mb-1">{{ $subject->title }}</h5>
				      	<small>{{ $subject->created_at }}</small>
				    </div>
				    <p class="mb-1">{{ $subject->description }}</p>
				  </li>
				  @endforeach
			</div>
        </div>
    </div>
</div>
@endsection
