@extends('layouts.app')

@section('content')
<div class="container">
	<a href="{{route('exam.create')}}" class="btn btn-primary">Create</a>
    <div class="float-right d-inline-block searchHide">
    	{{$exams->links("pagination::bootstrap-4")}}
    </div>
    <div class="form-group">
    	<input type="text" name="search" class="form-control w-25 mt-3 mb-0" id="search" placeholder="search exam">
	</div>
    <div class="row mt-5" id="searchData">	
    	
	    @include('exam.ajax.index')
	    
    </div>
</div>
@endsection
@section('extra-js')
	<script type="text/javascript">
		$(document).on('keyup', '#search', function(){
		    var query = $(this).val();
		    $('.searchHide').addClass('d-none');
		    $('.searchHide').removeClass('d-inline-block');
		    $.ajax({
		    	url: '{{ route('exam.index') }}',
		    	method: 'get',
		    	data: {search:query},
		    	success:function(data){
		    		$('#searchData').html(data);
		    		if (data.length == 0) {
		    			$('#searchData').append("No Data Found");
		    		}
		    	}
		    });
		});
	</script>
@endsection