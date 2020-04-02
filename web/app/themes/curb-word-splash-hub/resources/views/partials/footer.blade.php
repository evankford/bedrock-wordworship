

<footer class="content-info site-footer @php if (!in_array(get_post_type(), ['artist', 'release'])) echo 'curb-branding';@endphp">
  <div class="container">
    <div class="footer-widgets">
      @php dynamic_sidebar('sidebar-footer'); @endphp
    </div>
    @if (function_exists('get_field'))
    @if (!in_array(get_post_type(), ['artist', 'release']))
      <section class="site-footer__main">
        {{ Footer::logo() }}
      </section>
    @endif
      <section class="site-footer__super">
        <p class="copyright">&copy; {{ date("Y") }} {{Footer::copyright()}}</p>
        @if (has_nav_menu('footer_navigation'))
          {{wp_nav_menu(['theme_location' => 'footer_navigation'])}}
        @endif
      </section>
    @endif
  </div>
</footer>

@include('partials.browser-update')