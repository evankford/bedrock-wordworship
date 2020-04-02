@extends('layouts.app')

@section('content')
 <main class="front-main page-header">

  <div class="front-main__background rellax background">
      {{ FrontPage::background() }}
  </div>
 @php
  $args = array('post_type' => 'release','posts_per_page'=>'30');
  $loop = new WP_Query($args);
  @endphp
  <div class="front-main__content">
    <div class="archive-title">
      <h1>@php echo __("Releases:") @endphp</h1>
    </div>
    <div class="loop">
      @while($loop->have_posts()) @php($loop->the_post())
      @include('partials.excerpt')
      @endwhile

    </div>
    {!! get_the_posts_navigation() !!}
  </div>
</main>
@endsection
