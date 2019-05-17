@extends('layouts.app')

@section('title', __('You view later list'))

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">{{ __('You view later list') }}</div>
					<div class="card-body">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif
						<div class="row">
							<div class="col-12">
								<all-view-later user_token="{{ Auth::user()->api_token }}"></all-view-later>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
