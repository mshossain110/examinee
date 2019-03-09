@extends('layouts.app')

@section('content')
<div class="container">
	<a href="{{route('topic.create')}}" class="btn btn-primary">Create</a>

    <div class="row">
        <div class="col ">
            <div class="list-group mt-5">
            	@foreach ($topics as $topic)
				 <li class="list-group-item">
				    <div class="d-flex w-100 justify-content-between">
				    	<h5 class="mb-1">{{ $topic->title }}</h5>
				      	<small>{{ $topic->created_at }}</small>
				    </div>
			        <div class="d-flex w-100 justify-content-between">
			    	    <p class="mb-1 w-90">{{ $topic->description }}</p>
			    		<p>
			    			<a href="{{route('topic.edit',$topic->id)}}" class="mr-2">
			    				<i class="fas fa-pen-square"></i>
			    			</a>
			    			<a href="javascript:void(0)" onclick="event.preventDefault();
			    			    document.getElementById('delete-form{{$topic->id}}').submit();">
			    				<i class="fas fa-trash-alt" style="color: red"></i>
			    			</a>
			          	</p>
			        </div>
			        <form id="delete-form{{$topic->id}}" action="{{route('topic.destroy',$topic->id)}}" method="POST" style="display: none;">
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
