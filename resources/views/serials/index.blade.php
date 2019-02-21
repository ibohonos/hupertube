@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<span>{{ __('Serials') }}</span>
					</div>
					<div class="card-body">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif
						@if (Auth::user())
							<serials user_token="{{ Auth::user()->api_token }}"></serials>
						@else
							<serials user_token="Null"></serials>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
