@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.courses.title')</h3>
    @can('course_create')
    <p>
        <a href="{{ route('courses.create') }}" class="btn btn-success">@lang('Add New')</a>
        
    </p>
    @endcan

    <p>
        <ul class="list-inline">
            <li><a href="{{ route('courses.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">All</a></li> |
            <li><a href="{{ route('courses.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Trash</a></li>
        </ul>
    </p>
    

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('All')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($courses) > 0 ? 'datatable' : '' }} @can('course_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('course_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        @if (Auth::user()->isAdmin())
                            <th>@lang('Teacher')</th>
                        @endif
                        <th>@lang('Course Title')</th>
                        <th>@lang('Course Slug')</th>
                        <th>@lang('Description')</th>
                        <th>@lang('Course Price')</th>
                        <th>@lang('Thumbanile')</th>
                        <th>@lang('Start At')</th>
                        <th>@lang('Status')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($courses) > 0)
                        @foreach ($courses as $course)
                            <tr data-entry-id="{{ $course->id }}">
                                @can('course_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                @if (Auth::user()->isAdmin())
                                <td>
                                    @foreach ($course->teachers as $singleTeachers)
                                        <span class="label label-info label-many">{{ $singleTeachers->name }}</span>
                                    @endforeach
                                </td>
                                @endif
                                <td>{{ $course->title }}</td>
                                <td>{{ $course->slug }}</td>
                                <td>{!! $course->description !!}</td>
                                <td>{{ $course->price }}</td>
                                <td>@if($course->course_image)<a href="{{ asset('uploads/' . $course->course_image) }}" target="_blank"><img src="{{ asset('uploads/thumb/' . $course->course_image) }}"/></a>@endif</td>
                                <td>{{ $course->start_date }}</td>
                                <td>{{ Form::checkbox("status", 1, $course->status == 1 ? true : false, ["disabled"]) }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("Are you sure?")."');",
                                        'route' => ['courses.restore', $course->id])) !!}
                                    {!! Form::submit(trans('Restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("Are you sure?")."');",
                                        'route' => ['courses.perma_del', $course->id])) !!}
                                    {!! Form::submit(trans('app_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                                                </td>
                                @else
                                <td>
                                    @can('course_view')
                                    <a href="{{ route('admin.lessons.index',['course_id' => $course->id]) }}" class="btn btn-xs btn-primary">@lang('Lesson Title')</a>
                                    @endcan
                                    @can('course_edit')
                                    <a href="{{ route('courses.edit',[$course->id]) }}" class="btn btn-xs btn-info">@lang('Edit')</a>
                                    @endcan
                                    @can('course_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("Are you sure?")."');",
                                        'route' => ['courses.destroy', $course->id])) !!}
                                    {!! Form::submit(trans('Delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="12">@lang('No entries in table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('course_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('courses.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection