@extends($theme . 'layouts.app')
@section('title',trans('Home'))
@section('content')
    @include($theme.'sections.about')
    @include($theme . 'partials.footer')
@endsection
