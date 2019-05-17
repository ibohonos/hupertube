@extends('layouts.app')

@section('title', __('Movies'))

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<span>{{ __('Movies') }}</span>
					</div>
					<div class="card-body">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif
						@if (Auth::user())
							<videos user_token="{{ Auth::user()->api_token }}"></videos>
						@else
							<videos user_token="Null"></videos>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
