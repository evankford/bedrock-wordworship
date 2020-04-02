@extends('layouts.artist')

@section('content')
{{-- @include('partials.header-artist') --}}
{{-- @include('partials.page-header') --}}
<div class="loop loop--sections">
  @php $content = Release::get_content() @endphp
  @foreach ($content as $content_item)
    {!!Release::section($content_item, $loop->index)!!}
  @endforeach
</div>
@if (get_field('header_location') == 'bottom')
<div class="footer-branding">
  @include('partials.artist-branding')
</div>
@endif
@endsection