@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">{{ __('Profile :first_name :last_name', ['first_name' => $user->first_name, 'last_name' => $user->last_name]) }}</div>
					<div class="card-body">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif
						<div class="row">
							<div class="col-md-3">
								<div class="img-circle" style="float: left;">
									<img src="{{ url($user->avatar) }}" class="img-circle" width="100%">
								</div>
							</div>
							<div class="col-md-9">
								<div style="float: right;">
									@if(Auth::id() === $user->id)
										<a href="{{ route('profile.edit') }}" class="btn btn-secondary">{{ __('Edit') }}</a>
									@endif
								</div>
								<div class="info">
									<div class="row">
										<div class="col-md-3">
											{{ __('Name') }}:
										</div>
										<div class="col-md-9">
											{{ $user->name }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											{{ __('Full name') }}:
										</div>
										<div class="col-md-9">
											{{ $user->first_name }} {{ $user->last_name }}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
