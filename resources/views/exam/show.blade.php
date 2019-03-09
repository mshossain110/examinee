@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-5 mb-5">
	        <div class="col-sm-4">
	            <div class="card">
				  	<div class="card-body">
				    	<h5 class="card-title">{{ $exam->title }}</h5>
				    	<h6 class="card-subtitle mb-2 text-muted"> subject{!! $exam->subjects->pluck('title')  !!}</h6>
				    	<p class="card-text">{{ $exam->description }}</p>
				    	{{-- <a href="#" class="card-link">Start Exam</a> --}}
				  </div>
				</div>  
	        </div>
            <div class="col-sm-8">
                <h6 class="text-center text-muted">Result Graph </h6>
                <h6 class="font-weight-bold text-info text-center"> Min: {{round($min)}}  Avg: {{round($avg)}} Max: {{round($max)}}</h6>
                <canvas id="myChart" style="max-height: 200px;"></canvas>
                    
            </div>
    </div>
    

    <div class="row">
        <div class="col-md-6" id="oldquestion">
            <div class="card">
                <div class="card-header">
                    <span class="font-weight-bold text-info">Exam Question</span>
                </div>
                <div class="card-body question" id="newwquestion">
                    <!--here ajax data append -->
                    @include('exam.ajax.questions')
                </div>
            </div>
        </div>
        <div class="col-md-6" >
            
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
                                <td>{{ $result->obtain }}</td>
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
@section('extra-js')
    <script type="text/javascript">
        

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href');
            // console.log(page);
            // $('tbody a').css('color', '#dfecf6');
            // $('table').append('<img style="position: absolute; left: 40%; top: 40%; z-index: 100000;" src="{{asset('uploads/Spinner.gif')}}" />');
         
            getArticles(page);
            window.history.pushState("", "", page);
        });

        function getArticles(page) {
            $.ajax({
                url : page,
            }).done(function (data) {
               // console.log(data);
               // location.reload();
                $('.question').html(data);
            }).fail(function () {
                console.log('failed to load data');
            });
        }
       
    </script>

    <!-- delete question -->
    <script type="text/javascript">
        function deletePost(ad){
            var hrefv = $(ad).attr('href');
            var v_token = "{{csrf_token()}}";
            var parametros = {_method: 'DELETE', _token: v_token};
            $.ajax({
                type: "POST",
                url: hrefv,
                data: parametros,
                success: function(data){
                    $('.questions'+ data).fadeOut('slow');
                    $('.question').load('{{ route( 'exam.show', [ 'id' => $exam->id, 'questions' => 'all' ]) }}');

                }
            });
        }

    </script>

    <script type="text/javascript">
            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'pie',
                // The data for our dataset
                data: {
                    datasets: [{
                        data: [{{ $dataset }}],
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)'
                      ],
                    }],
                     labels: [
                        'Lowest',
                        'Average',
                        'Highest'
                    ]
                },
                // Configuration options go here
                options: {}
            });
        </script>
@endsection