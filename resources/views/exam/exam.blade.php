@extends('layouts.student')

@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
			  	<div class="card-body">
			    	<h5 class="card-title">{{ $exam->title }}</h5>
			    	<h6 class="card-subtitle mb-2 text-muted">{{ $exam->subject  }}</h6>
			    	<p class="card-text">{{ $exam->description }}</p>
			  </div>
			</div>
        </div>
    </div>
    <div class="row mt-5">
    	<form class="form-horizontal" method="POST" action="{{ route('exam.end', [ 'id' => $exam->id ]) }}" >
    		{{ csrf_field() }}
	        @foreach( $exam->questions as $question ) 
	        <div class="col-12">
	        	<h5> {{ $question->question }}</h5>
	        	{{-- @if( $question->qtype == 0) --}}
	        		<div class="opptions_area">

	        			@foreach( $question->options as $k  => $v)
	        			<div class="form-check">
							<input class="form-check-input" type="checkbox" name="answer[{{ $question->id }}]" value="{{ $k }}">
							<label class="form-check-label">{{ $v }}</label>
						</div>
	        			@endforeach
	        		</div>
	        	{{-- @endif --}}
	        </div>
	        @endforeach
	        <div class="form-group mt-5">
                <div class="col-md-8 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        End Exam
                    </button>
                </div>
            </div>
    	</form>
    </div>
</div>
@endsection
