<header class="banner site-header">
  <div class="container site-header__wrap">
    <div class="site-header__brand">
      <a class="brand" href="{{ home_url('/') }}">{{App::logo()}}</a>
      {{App::icons()}}
    </div>
    <div class="site-header__links">
      <nav class="nav-primary">
        @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
        @endif
      </nav>
      {{App::links()}}
    </div>
  </div>
</header>
