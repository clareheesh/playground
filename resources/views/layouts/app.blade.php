@extends('light-bootstrap-dashboard::layouts.main')

@section('sidebar-menu')
  <ul class="nav">
    <li @if(isset($page) && $page == 'dolls')class="active"@endif><a class="nav-link" href="/dolls"><i class="pe-7s-user"></i> <p>Dolls</p></a></li>
    {{--<li @if(isset($page) && $page == 'tasks')class="active"@endif><a class="nav-link" href="#"><i class="pe-7s-pen"></i> <p>Tasks</p></a></li>--}}
    {{--<li><a class="nav-link" href="#"><i class="pe-7s-cash"></i> <p>Finances</p></a></li>--}}
    <li><a class="nav-link" target="_blank" href="//53stitches.com"><i class="nc-icon nc-tv-2"></i> <p>53stitches</p></a></li>
    <li><a class="nav-link" target="_blank" href="//53stitches.etsy.com"><i class="nc-icon nc-money-coins"></i> <p>Etsy</p></a></li>
    <li><a class="nav-link" target="_blank" href="//www.ravelry.com"><i class="nc-icon nc-palette"></i> <p>Ravelry</p></a></li>
  </ul>
@endsection
