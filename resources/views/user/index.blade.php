@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">{{ __('Hello :first_name :last_name', ['first_name' => Auth::user()->first_name, 'last_name' => Auth::user()->last_name]) }}</div>
					<div class="card-body">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif
						<div class="row">
							<div class="col-md-6">
								<avatar-crope img="{{ url(Auth::user()->avatar) }}" token="{{ Auth::user()->api_token  }}"></avatar-crope>
							</div>

							<div class="col-md-6">
								<fieldset>
									<legend class="text-center">Your details</legend>
									<a href="{{ route('profile.edit') }}"><i class="fab fa-pen-square fa-2x"></i></a>
									<ul>
										<li>Username: {{Auth::user()->name}}</li>
										<li>Name: {{Auth::user()->first_name}} </li>
										<li>Surname: {{Auth::user()->last_name}}</li>
										<li>Email: {{Auth::user()->email}}</li>
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
