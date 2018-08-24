@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">Thank's</div>
					<div class="card-body">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif
						<p>Thank's for registration. Please activate your account for your e-mail.</p>
						<div class="row">
							<div class="col-md-12">
								<a class="btn btn-info" href="{{ route('mail.resend') }}">Re-send E-mail</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection