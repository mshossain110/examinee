@extends('layouts.student')

@section('content')
<div class="container">
	    @if(Session::has('msg'))
	        <div class="alert alert-danger">
	            <span class="glyphicon glyphicon-ok"></span><em> 
	            {!! session('msg') !!}</em>
	        </div>
	    @endif	
    <div class="row mt-5">
	    @foreach( $exams as $exam )
	        <div class="col-4">
	            <div class="card">
				  	<div class="card-body">
			  		    <div class="d-flex w-100 justify-content-between">
					    	<h5 class="card-title">{{ $exam->title }}</h5>
			  		    </div>
				    	<h6 class="card-subtitle mb-2 text-muted">{{ $exam->subject  }}</h6>
				    	<p class="card-text">{{ $exam->description }}</p>
				    	<a href="{{ route( 'exam.start', [ 'id' => $exam->id ]) }}" class="card-link">Start Exam</a>
				  	</div>
				</div>
	        </div>
	    @endforeach
	    
    </div>
</div>
@endsection
