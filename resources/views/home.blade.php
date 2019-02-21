@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				@guest
				<div class="card form-main">
					<div class="card-header-main">{{ __('Welcome to') }} {{ config('app.name', 'Laravel') }}</div>
					<hr>
					<div class="card-body-main">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif
						<p>{{ __('Watch your favorite films in live! No need to spend time for download, just choose and watch in live!') }}</p>
						<a class="btn btn-primary" href="{{ route('register') }}">
							{{ __('Register for free') }}
						</a>
					</div>
				</div>
				@endguest
			</div>
		</div>
	</div>
@endsection


