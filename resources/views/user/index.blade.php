@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">Hello {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
					<div class="card-body">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif
						<div class="row">
							<div class="col-12">
								<div class="img-circle" style="float: left;">
									{{--<img src="{{ url(Auth::user()->avatar) }}" class="img-circle">--}}
									<avatar-crope img="{{ url(Auth::user()->avatar) }}" token="{{ Auth::user()->api_token  }}"></avatar-crope>
								</div>
								<div style="float: right;">
									<a href="{{ route('profile.edit') }}" class="btn btn-secondary">Edit</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
