    @foreach( $exams as $exam )
        <div class="col-4 mt-2 mb-2">
            <div class="card">
			  	<div class="card-body">
		  		    <div class="d-flex w-100 justify-content-between">
				    	<h5 class="card-title">{{ $exam->title }}</h5>
		  		    </div>
			    	<h6 class="card-subtitle mb-2 text-muted">{{ $exam->subject  }}</h6>
			    	<p class="card-text">{{ $exam->description }}</p>

			    	@if(empty($exam->questions))
				    	<a href="javascript:void(0)" class="card-link text-">No Question</a>
			    	@else
				    	<a href="{{ route( 'exam.start', [ 'id' => $exam->id ]) }}" class="card-link">Start Exam</a>
			    	@endif
			  	</div>
			</div>
        </div>
    @endforeach