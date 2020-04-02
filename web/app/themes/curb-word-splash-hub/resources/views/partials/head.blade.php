<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  @if (get_post_type() == 'artist' || get_post_type() == 'release')
    {!!App::style()!!}
  @endif
  @php wp_head() @endphp
</head>
