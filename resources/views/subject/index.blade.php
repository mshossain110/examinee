@extends('layouts.app')

@section('content')
<div class="container">
	<a href="{{route('subject.create')}}" class="btn btn-primary">Create</a>
    
    <div class="row">
        <div class="col ">
            <div class="list-group mt-5">
            	
            	<div class="d-inline-block float-right">
            		{{$subjects->render("pagination::bootstrap-4")}}
            	</div>

            	@foreach ($subjects as $subject)
				 <li class="list-group-item">
				    <div class="d-flex w-100 justify-content-between">
				    	<h5 class="mb-1">{{ $subject->title }}</h5>

				      	<small>{{ $subject->created_at }}</small>
				    </div>
				    <div class="d-flex w-100 justify-content-between">
					    <p class="mb-1 w-90">{{ $subject->description }}</p>
						<p>
							<a href="{{route('subject.edit',$subject->id)}}" class="mr-2">
								<i class="fas fa-pen-square"></i>
							</a>
							<a href="javascript:void(0)" onclick="event.preventDefault();
							    document.getElementById('delete-form{{$subject->id}}').submit();">
								<i class="fas fa-trash-alt" style="color: red"></i>
							</a>
				      	</p>
				    </div>
				    
					<form id="delete-form{{$subject->id}}" action="{{route('subject.destroy',$subject->id)}}" method="POST" style="display: none;">
	  		        	{{ csrf_field() }}
                    	<input name="_method" type="hidden" value="DELETE">
	  		        </form>
				  </li>
				  @endforeach
			</div>
        </div>
    </div>
</div>
@endsection
