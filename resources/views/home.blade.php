@extends('layouts.app')

@section('content')
<section>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Fluid jumbotron</h1>
            <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
        </div>
    </div>
</section>
<section>
    <div class="container mt-5">
        @foreach ($subjects as $subject)

        <div class="card mb-5 border-0">
            <div class="card-header bg-primary text-light">
                {{$subject->title}}
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($subject->courses as $course)

                    <div class="col-3">
                        <course :course='@json($course)'>

                            <template v-slot:button>
                                <a class="btn btn-primary" href="{{$course->permalink}}" role="button">View</a>
                            </template>
                        </course>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection