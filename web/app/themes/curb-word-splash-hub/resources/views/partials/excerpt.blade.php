<a href="{{get_the_permalink()}}" @php post_class("single-block artist-block") @endphp>
<div class="single-block__background">
    {{Excerpt::background()}}
  </div>
  <div class="single-block__content entry-content">
    <header>
      @if (get_post_type() == 'release')
      <h4 class="h5 caps">{{Release::artist()}}</h4>
      @endif
      <h2 class="entry-title h3">{!! get_the_title() !!}</h2>
      @if (get_post_type() == 'release')
      <h4 class="h5 caps">{{Release::date()}}</h4>
      @endif
      <div class="button simple">More <i class="icon-arrow-right"></i></div>
    </header>
  </div>
</a>
