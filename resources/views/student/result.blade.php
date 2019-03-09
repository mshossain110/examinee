@extends('layouts.student')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-12" >
            
            <div class="card">
                <div class="card-header">
                    <span class="font-weight-bold text-info">Exam Result History</span>
                </div>
                <div class="card-body">
                <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Exam Name</th>
                            <th>Teacher Name</th>
                            <th>Obtain</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                            <tr>
                                <td>{{ $result->resultExam->title }}</td>
                                <td>{{ $result->resultExam->examUser->name }}</td>
                                <td>{{ $result->obtain }}</td>
                                <td>{{ $result->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

              </div>
            </div>
        </div>
    </div>

</div>
@endsection
