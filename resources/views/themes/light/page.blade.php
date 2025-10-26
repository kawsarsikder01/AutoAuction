
@extends($theme . 'layouts.app')
@if ($pageSeo['page_title'])
@section('title',trans(strip_tags($pageSeo['page_title'])))
@endif
@section('content')
    {!!  $sectionsData !!}
@endsection
