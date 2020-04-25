@extends('layouts.app')

@section('content')
<page-student></page-student>
@endsection


@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.10/plyr.css" />

@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.10/plyr.min.js" ></script>
@endpush