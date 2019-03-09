	    @foreach( $exams as $exam )
	        <div class="col-4">
	            <div class="card mb-2">
				  	<div class="card-body">
			  		    <div class="d-flex w-100 justify-content-between">
					    	<h5 class="card-title">{{ $exam->title }}</h5>
			  				<p>
			  					<a href="{{route('exam.edit',$exam->id)}}" class="mr-2">
			  						<i class="fas fa-pen-square"></i>
			  					</a>
			  					<a href="javascript:void(0)" onclick="event.preventDefault();
			  					    document.getElementById('delete-form{{$exam->id}}').submit();">
			  						<i class="fas fa-trash-alt" style="color: red"></i>
			  					</a>

			  		      	</p>
			  		    </div>
			  		    <form id="delete-form{{$exam->id}}" action="{{route('exam.destroy',$exam->id)}}" method="POST" style="display: none;">
			  		        {{ csrf_field() }}
                            <input name="_method" type="hidden" value="DELETE">
			  		    </form>
				    	<h6 class="card-subtitle mb-2 text-muted">{{ $exam->subject  }}</h6>
				    	<p class="card-text">{{ $exam->description }}</p>
				    	<a href="{{ route( 'exam.show', [ 'id' => $exam->id ]) }}" class="card-link">Show Details</a>
				  	</div>
				</div>
	        </div>
	    @endforeach