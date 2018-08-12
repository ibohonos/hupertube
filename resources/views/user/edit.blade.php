@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">Edit {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
					<div class="card-body">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif
						<div class="row">
							<div class="col-12">
								<h2>Connect to socials</h2>
								<div class="card-group">
									@if(!Auth::user()->facebook_id)
										<a href="{{ route('social', 'facebook') }}" class="btn btn-social-icon btn-facebook"><i class="fas fa-facebook"></i>Facebook</a>
									@endif
									@if(!Auth::user()->google_id)
										<a href="{{ route('social', 'google') }}" class="btn btn-social-icon btn-google-plus"><i class="fa fa-google-plus"></i>Google</a>
									@endif
									@if(!Auth::user()->github_id)
										<a href="{{ route('social', 'github') }}" class="btn btn-social-icon btn-github"><i class="fab fa-github"></i>Github</a>
									@endif
									@if(!Auth::user()->intra_id)
										<a href="{{ route('social', 'intra') }}" class="btn btn-social-icon btn-intra"><i class="fab fa-intra"></i>Intra</a>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
