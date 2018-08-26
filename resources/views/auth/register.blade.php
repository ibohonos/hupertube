@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card  form-login-register">
				<div class="card-header">{{ __('Register') }}</div>

				<div class="card-body">
					<form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
						@csrf

						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

							<div class="col-md-6">
								@if(!empty($name))
									<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $name }}" required autofocus>
								@else
									<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
								@endif

								@if ($errors->has('name'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('name') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group row">
							<label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

							<div class="col-md-6">
								@if(!empty($first_name))
									<input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ $first_name }}" required>
								@else
									<input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required>
								@endif

								@if ($errors->has('first_name'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('first_name') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group row">
							<label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

							<div class="col-md-6">
								@if(!empty($last_name))
									<input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ $last_name }}" required>
								@else
									<input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required>
								@endif

								@if ($errors->has('last_name'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('last_name') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

							<div class="col-md-6">
								@if(!empty($email))
									<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email }}" required>
								@else
									<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
								@endif

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
							<label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

							<div class="col-md-6">
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
							</div>
						</div>

						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-2">
								@if (isset($social) && $social)
									<input type="hidden" name="social" value="{{ $social }}">
								@endif
								@if (isset($social_id) && $social_id)
									<input type="hidden" name="social_id" value="{{ $social_id }}">
								@endif
								@if (isset($avatar) && $avatar)
									<input type="hidden" name="avatar" value="{{ $avatar }}">
								@endif
								<button type="submit" class="btn btn-primary">
									{{ __('Register') }}
								</button>
							</div>
						</div>
					</form>
					<div class="form-group">
						<label for="name" class="col-md-4 control-label">{{ __('Register With') }}</label>
						<div class="col-md-12">
							<a href="{{ route('social', 'facebook') }}" class="btn btn-social-icon btn-facebook"><i class="fas fa-facebook"></i>Facebook</a>
							<a href="{{ route('social', 'google') }}" class="btn btn-social-icon btn-google-plus"><i class="fa fa-google-plus"></i>Google</a>
							<a href="{{ route('social', 'github') }}" class="btn btn-social-icon btn-github"><i class="fab fa-github"></i>Github</a>
							<a href="{{ route('social', 'intra') }}" class="btn btn-social-icon btn-intra"><i class="fab fa-intra"></i>Intra</a>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
