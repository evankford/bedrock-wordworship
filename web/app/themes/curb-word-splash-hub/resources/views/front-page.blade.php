@extends('layouts.app')

@section('content')
 <main class="front-main page-header">

  <div class="front-main__background">
      {{ FrontPage::background() }}
  </div>
  <div class="front-main__content">
    {{-- <h1>{{ FrontPage::mainImage('front-main__logo') }}</h1> --}}
    <div class="front-buttons">
      @if (FrontPage::artistsActive())
          <h2 class="h4"><a class="button" href="/artists">{{FrontPage::artistsHeader()}}</a></h2>
      @endif
      @if (FrontPage::releasesActive())
          <h2 class="h4"><a class="button" href="/releases">{{FrontPage::releasesHeader()}}</a></h2>
      @endif
    </div>
  </div>
 </main>
@endsection
