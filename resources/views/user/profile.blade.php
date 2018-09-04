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
							<div class="col-md-6">
								<div class="user-avatar">
									<img class="avatar" src="{{ url($user->avatar) }}">
								</div>
							</div>
							<div class="col-md-6">
								<fieldset>
									<legend class="text-center">User details</legend>
									@if(Auth::id() === $user->id)
										<a href="{{ route('profile.edit') }}"><i class="fab fa-pen-square fa-2x"></i></a>
									@endif
									<ul>
										<li>Username: {{ $user->name }}</li>
										<li>Name: {{ $user->first_name }}</li>
										<li>Surname: {{ $user->last_name }}</li>
										@if(Auth::id() === $user->id)
											<li>Email: {{ $user->email }}</li>
										@endif
									</ul>
								</fieldset>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
