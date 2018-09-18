@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card  form-login-register">
				<div class="card-header">{{ __('Login') }}</div>

				@if (session('not_activate'))
					<span class="alert alert-danger text-center" role="alert">
						<strong>{{ session('not_activate') }}</strong>
						@php (session()->remove('not_activate'))
					</span>
				@endif
				<div class="card-body">
					<form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
						@csrf

						<div class="form-group row">
							<label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

							<div class="col-md-6">
								<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

								@if ($errors->has('email'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

							<div class="col-md-6">
								<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

								@if ($errors->has('password'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-6 offset-md-4">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

									<label class="form-check-label" for="remember">
										{{ __('Remember Me') }}
									</label>
								</div>
							</div>
						</div>

						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<button type="submit" class="btn btn-primary">
									{{ __('Login') }}
								</button>

								<a class="btn btn-link" href="{{ route('password.request') }}">
									{{ __('Forgot Your Password?') }}
								</a>
							</div>
						</div>
					</form>

					<div class="form-group">
						<label for="name" class="col-md-4 control-label"></label>
						<div class="col-md-12 social-container">
							<a href="{{ route('social', 'facebook') }}" class="btn btn-social-icon btn-facebook"><i class="fas fa-facebook"></i> Facebook</a>
							<a href="{{ route('social', 'google') }}" class="btn btn-social-icon btn-google-plus"><i class="fa fa-google-plus"></i> Google</a>
							<a href="{{ route('social', 'github') }}" class="btn btn-social-icon btn-github"><i class="fab fa-github"></i> Github</a>
							<a href="{{ route('social', 'intra') }}" class="btn btn-social-icon btn-intra"><i class="fab fa-intra"></i> Intra</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
