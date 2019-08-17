@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8 m-0 mt-5">
            <div class="card">
                <div class="card-header">
                    <span class="font-weight-bold text-info">Standard Derivation for Students</span>
                </div>
                <div class="card-body p-0">
                    <canvas id="myChart"></canvas>

                </div>
            </div>
        </div>

        <div class="col-4 m-0 mt-5">
            <div class="card">
                <div class="card-header">
                    <span class="font-weight-bold text-info">Students information</span>
                </div>
                <div class="card-body">
                   <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                           <thead>
                               <tr>
                                   <th>Student_id</th>
                                   <th>Name</th>
                               </tr>
                           </thead>
                           <tbody>
                               @foreach($students as $student)
                                   <tr>
                                           <td>{{ $student->id }}</td>
                                           <td>{{ $student->name }}</td>
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
@push('footer')

    <script type="text/javascript">
        var ctx = document.getElementById('myChart').getContext('2d');
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [1, 2, 3, 4],
                datasets: [{
                    data: [100, 200, 120, 120],
                    backgroundColor: 'rgb(255, 99, 132)',
                    label: 'SD',
                }],
            },

            options: {
                scales: {
                    yAxes: [{ 
                      scaleLabel: {
                        display: true,
                        labelString: "Result",
                        ticks: {
                            beginAtZero: true,
                            min: 0,
                        }
                      }
                    }],
                    xAxes: [{ 
                      scaleLabel: {
                        display: true,
                        labelString: "Student ID"
                      }
                    }]
                }
            },
        });
        
    </script>
@endpush
