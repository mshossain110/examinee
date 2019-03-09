
<div class="d-inline-block float-right">
    {{$questions->render("pagination::bootstrap-4")}}
</div>

<a href="{{route('question.create', $exam->id)}}" class="btn btn-primary btn-sm">Create Exam</a>
<div class="list-group mt-5">
    @foreach ($questions as $question)
        <li class="list-group-item mb-2 questions{{$question->id}}">
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
                    <a href="{{route('question.edit',[$question->id, $exam->id])}}" class="mr-2">
                        <i class="fas fa-pen-square"></i>
                    </a>
                    <a href="{{route('question.destroy',$question->id)}}" onclick="event.preventDefault();deletePost(this)">
                        <i class="fas fa-trash-alt" style="color: red"></i>
                    </a>
                </p>
            </div>
            
            {{-- <form id="delete-form" action="{{route('question.destroy',$question->id)}}" method="POST" style="display: none;">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="DELETE">
            </form> --}}
        </li>
    @endforeach
    @if(count($exam->questions) == 0 )
        <p class="text-muted text-left"> No exam question found </p>
    @endif
</div>