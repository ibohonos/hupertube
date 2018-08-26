@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card form-main">
					<div class="card-header-main">{{ __('Welcome to HYPERTUBE') }}</div>
					<hr>
					<div class="card-body-main">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif
						@guest
							<p>Watch your favorite films in live! No need to spend time for download,
								just choose and watch in live!
							</p>
							<a class="btn btn-primary" href="{{ route('register') }}">
							{{ __('Register for free') }}
							</a>
						@else
							{{ __('You are logged in!') }}
							<test-api token="{{ Auth::user()->api_token  }}"></test-api>
						@endguest
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
