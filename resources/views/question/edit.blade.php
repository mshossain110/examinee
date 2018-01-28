@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col mt-5">
            <div class="card">
            	<div class="card-header">
            		<h3>Update Exam</h3>
            	</div>
            	<div class="card-body">
            		<form class="form-horizontal" method="POST" action="{{ route('exam.update', ['id' => $exam->id ]) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Exam Title</label>

                            <div class="col">
                                <input id="title" type="text" class="form-control" name="title" value="{{ $exam->title }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Description</label>

                            <div class="col">
                                
                        	<textarea id="description" name="description" cols="100" rows="8">{{ $exam->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                            <label for="subject" class="col-md-4 control-label">Subject</label>

                            <div class="col">
                                
                            	<select id="subject" name="sid">
                                    @foreach( $subjects as $subject )
                            		<option value="{{ $subject->id }}">{{$subject->title}}</option>
                                    @endforeach
                            	</select>
                                @if ($errors->has('subject'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('subject') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Create Exam
                                </button>
                            </div>
                        </div>
                    </form>
            	</div>
            </div>
        </div>
    </div>
</div>
@endsection
