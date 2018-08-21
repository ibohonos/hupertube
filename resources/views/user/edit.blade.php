@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">Edit {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
					<div class="card-body">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif
						<div class="row">
							<div class="col-12">
								<h2 class="text-center">Edit</h2>
								<form method="post" action="{{ route('edit.save') }}">
									@csrf
									<div class="form-group row">
										<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Login') }}</label>

										<div class="col-md-6">
											<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Auth::user()->name }}" required>

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
											<input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ Auth::user()->first_name }}" required>

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
											<input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ Auth::user()->last_name }}" required>

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
											<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ Auth::user()->email }}" required>

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
											<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

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
											<input id="password-confirm" type="password" class="form-control" name="password_confirmation">
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<button type="submit" class="btn btn-success btn-lg mx-auto d-block">
												{{ __('Update') }}
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-12">
								<h2 class="text-center">Connect to socials</h2>
								<div class="card-group">
									@if(!Auth::user()->facebook_id)
										<a href="{{ route('social', 'facebook') }}" class="btn btn-social-icon btn-facebook"><i class="fas fa-facebook"></i> Facebook</a>
									@else
										<a href="{{ route('unlink', 'facebook') }}" class="btn btn-social-icon btn-facebook"><i class="fas fa-facebook"></i> Unlink Facebook</a>
									@endif
									@if(!Auth::user()->google_id)
										<a href="{{ route('social', 'google') }}" class="btn btn-social-icon btn-google-plus"><i class="fa fa-google-plus"></i> Google</a>
									@else
										<a href="{{ route('unlink', 'google') }}" class="btn btn-social-icon btn-google-plus"><i class="fa fa-google-plus"></i> Unlink Google</a>
									@endif
									@if(!Auth::user()->github_id)
										<a href="{{ route('social', 'github') }}" class="btn btn-social-icon btn-github"><i class="fab fa-github"></i> Github</a>
									@else
										<a href="{{ route('unlink', 'github') }}" class="btn btn-social-icon btn-github"><i class="fab fa-github"></i> Unlink Github</a>
									@endif
									@if(!Auth::user()->intra_id)
										<a href="{{ route('social', 'intra') }}" class="btn btn-social-icon btn-intra"><i class="fab fa-intra"></i> Intra</a>
									@else
										<a href="{{ route('unlink', 'intra') }}" class="btn btn-social-icon btn-intra"><i class="fab fa-intra"></i> Unlink Intra</a>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
