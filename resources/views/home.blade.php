@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">{{ __('Dashboard') }}</div>
					<div class="card-body">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif
						@guest
							{{ __('Please login or register') }}
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
