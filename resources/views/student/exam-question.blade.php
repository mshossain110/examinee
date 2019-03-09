@extends('layouts.student')

@section('content')
<div class="container">
    @if(Session::has('msg'))
        <div class="alert alert-danger">
            <span class="glyphicon glyphicon-ok"></span><em> 
            {!! session('msg') !!}</em>
        </div>
    @endif	
    <div class="float-right d-inline-block searchHide">
    	{{$exams->links("pagination::bootstrap-4")}}
    </div>
    <div class="form-group">
    	<input type="text" name="search" class="form-control w-25 mt-3 mb-0" id="search" placeholder="search exam">
	</div>
    <div class="row mt-5" id="searchData">
    	@include('student.ajax')
	    
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
		    	url: '{{ route('student.home') }}',
		    	method: 'get',
		    	data: {search:query},
		    	success:function(data){
		    		console.log(data);
		    		$('#searchData').html(data);
		    		if (data.length == 0) {
		    			$('#searchData').append("No Data Found");
		    		}
		    	}
		    });
		});
	</script>
@endsection