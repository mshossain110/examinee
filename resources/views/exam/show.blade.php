@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-5">


	        <div class="col-4">
	            <div class="card">
				  	<div class="card-body">
				    	<h5 class="card-title">{{ $exam->title }}</h5>
				    	<h6 class="card-subtitle mb-2 text-muted">{{ $exam->subject  }}</h6>
				    	<p class="card-text">{{ $exam->description }}</p>
				    	<a href="#" class="card-link">Start Exam</a>
				  </div>
				</div>
	        </div>

	    
    </div>
</div>
@endsection
