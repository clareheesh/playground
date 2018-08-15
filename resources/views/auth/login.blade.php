@extends('light-bootstrap-dashboard::layouts.auth')

@section('content')
<div class="form-container">
  <form class="form form--login" action="{{ route('login') }}" method="POST">
    {{ csrf_field() }}

    <div>
      <input placeholder="Email" name="email" type="email" required />
      @if($errors->has('email'))
        <span class="help-block">{{ $errors->first('email') }}</span>
      @endif
    </div>

    <div>
      <input placeholder="Password" type="password" name="password" required>
      @if( $errors->has('password') )
        <span class="help-block">{{ $errors->first('password') }}</span>
      @endif
    </div>

    <div>
      <input id="remember" name="remember" type="checkbox" data-toggle="checkbox" checked> <label for="remember" class="checkbox">Remember me</label>
    </div>

    <div>
      <button type="submit">Login</button>
      <p><small><a href="{{ route('password.request') }}" class="text-muted">Forgot mPassword?</a></small></p>
    </div>
  </form>
</div>
@endsection
