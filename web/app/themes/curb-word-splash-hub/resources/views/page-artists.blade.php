@extends('layouts.app')

@section('content')
 <main class="front-main page-header">

  <div class="front-main__background rellax background">
      {{ FrontPage::background() }}
  </div>
 @php
  $args = array('post_type' => 'artist','posts_per_page'=>'-1');
  $loop = new WP_Query($args);
  @endphp
  <div class="front-main__content">
    <div class="archive-title">
      <h1>@php echo __("Artists:") @endphp</h1>
    </div>
    <div class="loop">
      @while($loop->have_posts()) @php($loop->the_post())
      @include('partials.excerpt')
      @endwhile
    </div>
  </div>
</main>
@endsection
