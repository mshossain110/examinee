@extends('layouts.app')

@section('content')
<section>
    <single-course :course='@json($course)'></single-course>
</section>
@endsection
