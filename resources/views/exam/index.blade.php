@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-5">

	    	@foreach( $exams as $exam )
	        <div class="col-4">
	            <div class="card">
				  	<div class="card-body">
				    	<h5 class="card-title">{{ $exam->title }}</h5>
				    	<h6 class="card-subtitle mb-2 text-muted">{{ implode(",", $exam->subject->pluck( 'title' )->all() ) }}</h6>
				    	<p class="card-text">{{ $exam->questions }}</p>
				    	<a href="#" class="card-link">Card link</a>
				    	<a href="#" class="card-link">Another link</a>
				  </div>
				</div>
	        </div>
	        @endforeach
	    
    </div>
</div>
@endsection
