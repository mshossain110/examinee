@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-5">

	    	@foreach( $questions as $question )
	        <div class="col-4">
	            <div class="card">
				  	<div class="card-body">
				    	<h5 class="card-title">{{ $question }}</h5>
				    	<a href="#" class="card-link">Card link</a>
				    	<a href="#" class="card-link">Another link</a>
				  </div>
				</div>
	        </div>
	        @endforeach
	    
    </div>
</div>
@endsection
