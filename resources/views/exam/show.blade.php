@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-5 mb-5">
	        <div class="col-sm-4">
	            <div class="card">
				  	<div class="card-body">
				    	<h5 class="card-title">{{ $exam->title }}</h5>
				    	<h6 class="card-subtitle mb-2 text-muted">{{ $exam->subject  }}</h6>
				    	<p class="card-text">{{ $exam->description }}</p>
				    	{{-- <a href="#" class="card-link">Start Exam</a> --}}
				  </div>
				</div>
	        </div>
    </div>
    
    <div class="card">
      <div class="card-header">
        <span class="font-weight-bold text-info">Exam Result History</span>
        <span class="float-right text-lowercase font-weight-bold">Total Marks: <span class="text-primary">{{$totalMarks}}</span></span>
      </div>
      <div class="card-body">
        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Mark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exam->examResults as $result)
                        <tr>
                                <td>{{\App\User::username($result->sid)}}</td>
                                <td>{{\App\User::useremail($result->sid)}}</td>
                                <td>{{\App\Result::calculateMark($result->id)}}</td>
                        </tr>
                    @endforeach
                </tbody>
        </table>
      </div>
    </div>


</div>
@endsection
