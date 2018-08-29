@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card form-main">
					<div class="card-header-main">{{ __('404') }}</div>
					<hr>
					<div class="card-body-main">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif
						<p>{{ __('Watch your favorite films in live! No need to spend time for download, just choose and watch in live!') }}</p>
						<a class="btn btn-primary" href="{{ route('index') }}">
							{{ __('Home page') }}
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection