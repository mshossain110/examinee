@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col mt-5">
            <div class="card">
            	<div class="card-header">
            		<h3>Edit Topic</h3>
            	</div>
            	<div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('topic.update', ['id' => $topic->id ]) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col">
                                <input id="title" type="text" class="form-control" name="title" value="{{ $topic->title }}" required autofocus>

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
                                
                            <textarea id="description" name="description" cols="100" rows="8">{{ $topic->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
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
