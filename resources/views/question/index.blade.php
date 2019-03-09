@extends('layouts.app')

@section('content')
<div class="container">
	<a href="{{route('question.create', 0)}}" class="btn btn-primary">Create</a>
    <div class="row">
        <div class="col ">

            <div class="list-group mt-5">
            	<div class="d-inline-block float-right">
            		{{$questions->render("pagination::bootstrap-4")}}
            	</div>
            	@foreach ($questions as $question)
					<li class="list-group-item mb-2">
					    <div class="d-flex w-100 justify-content-between">
					    	<h5 class="mb-1">{{ $question->question }}</h5>

					      	<small>{{ $question->created_at }}</small>
					    </div>
					    <div class="d-flex w-100 justify-content-start">
						    <p class="mb-1 w-90">
						    	@foreach($question->options as $key => $value)
					    			option {{ $key }}: {{$value}}<br>
					    		@endforeach
					    	</p>
					    </div>
					    <div class="d-flex w-100 justify-content-between">
						    <p class="mb-1 w-90"> Correct Ans: 
					    		@foreach($question->answer as $key => $value)
					    			{{$value}}
					    		@endforeach
					    	</p>
							<p>
								<a href="{{route('question.edit',[ $question->id, 0 ])}}" class="mr-2">
									<i class="fas fa-pen-square"></i>
								</a>
								<a href="javascript:void(0)" onclick="event.preventDefault();
								    document.getElementById('delete-form{{$question->id}}').submit();">
									<i class="fas fa-trash-alt" style="color: red"></i>
								</a>
					      	</p>
					    </div>
					    
						<form id="delete-form{{$question->id}}" action="{{route('question.destroy',$question->id)}}" method="POST" style="display: none;">
		  		        	{{ csrf_field() }}
	                    	<input name="_method" type="hidden" value="DELETE">
		  		        </form>
				  	</li>
				@endforeach
				<!-- pagination -->
				
			</div>
        </div>
    </div>
</div>
@endsection
