
  <div class="site-header__wrap artist-details">
    <div class="artist-details__brand site-header__brand">
      <a href="{{the_permalink(Artist::id())}}" class="brand">{{Artist::logo()}}</a>
      {{Artist::icons()}}
    </div>
    <div class="artist-details__links site-header__links">
      {{Artist::links()}}
    </div>
  </div>
