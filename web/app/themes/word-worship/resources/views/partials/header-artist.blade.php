@if (get_field('header_location') == 'top' || get_post_type() == 'artist')

<header class="banner site-header">
  @include('partials.artist-branding')
</header>

@endif