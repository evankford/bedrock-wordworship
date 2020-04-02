@extends('layouts.artist')

@section('content')
@include('partials.page-header')

@php $releases = Artist::releases(); @endphp
<div class="loop">
  @if ($releases->have_posts())
  @while ($releases->have_posts()) @php ($releases->the_post())
  @include('partials.excerpt')
  @php(wp_reset_postdata())
  @endwhile
  @else
  {!!Artist::fallback()!!}
  @endif
  @include('partials.artist-navigation')

</div>
@endsection
