@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col mt-5">
            <div class="card">
            	<div class="card-header">
            		<h3>Create Question</h3>
            	</div>
            	<div class="card-body">
            		<form class="form-horizontal" method="POST" action="{{ route('question.store') }}">
                        {{ csrf_field() }}


                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}" id="qtype">
                            <label for="title" class="col-md-4 control-label">Question type</label>

                            <div class="col">
                                <div class="btn-group" role="group" >
                                    <button type="button" class="btn btn-secondary active" data-title="0">Objective</button>
                                    <button type="button" class="btn btn-secondary" data-title="1">True/False</button>
                                    
                                    <input type="hidden" name="qtype" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Question</label>

                            <div class="col">
                                <textarea class="form-control" id="question" name="question" cols="100" rows="8">{{ old('question') }}</textarea>

                                @if ($errors->has('question'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('question') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}" id="qoption">
                            <label for="description" class="col-md-4 control-label">Options</label>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Currect Answere</th>
                                        <th>Option</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="option-input option-0">
                                        <td>
                                            <input class="form-control" type="checkbox" name="answer[]" value="0">
                                        </td>
                                        <td>
                                            <textarea class="form-control" name="options[0]"></textarea>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger remove"> remove</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-secondary" id="addoption">Add More Option</button>
                            
                        </div>

                        <div class="form-group form-row">
                            

                            <div class="col">
                                <label for="subject" class="control-label mr-2">Exam </label>
                                <select id="subject" class="form-control" name="eid">
                                    @foreach( $exams as $exam )
                                    <option value="{{ $exam->id }}">{{$exam->title}}</option>
                                    @endforeach
                                </select>
                                
                            </div>

                            <div class="col">
                                <label for="subject" class="control-label mr-2">Topic </label>
                                <select id="topic" class="form-control" name="tid">
                                    @foreach( $topics as $topic )
                                    <option value="{{ $topic->id }}">{{$topic->title}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('topic'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('topic') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <div class="col">
                                <label for="mark" class="control-label mr-2">Mark </label>
                                <input type="number" class="form-control" name="mark" value="1">
                                @if ($errors->has('mark'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mark') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col">
                                <label for="nagetive_mark" class="control-label mr-2">Mark </label>
                                <input type="number" class="form-control" name="nagetive_mark" value="0">
                                @if ($errors->has('nmark'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nmark') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col">
                                <label for="nagetive_mark" class="control-label mr-2">Defficulty </label>
                                <select id="defficulty" class="form-control" name="defficulty">
                                    
                                    <option value="1"> Level 1</option>
                                    <option value="2"> Level 2</option>
                                    <option value="3"> Level 3</option>
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="col-md-4 control-label">Answer Hint (Optional)</label>

                            <div class="col">
                                <textarea class="form-control" id="answer_hint" name="hint" >{{ old('question') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-md-4 control-label">Answer Explanation (Optional)</label>

                            <div class="col">
                                <textarea class="form-control" id="explanation" name="answer_explanation" >{{ old('question') }}</textarea>
                            </div>
                        </div>

                        

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Create
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
