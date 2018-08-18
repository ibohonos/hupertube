@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<span>Add video</span>
					</div>
					<div class="card-body">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif
						<form method="POST" action="{{ route('videos.store') }}" aria-label="{{ __('Create video') }}" enctype="multipart/form-data">
							@csrf

							<div class="form-group row">
								<label for="title" class="col-sm-4 col-form-label text-md-right">{{ __('Title') }}</label>

								<div class="col-md-6">
									<input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required autofocus>

									@if ($errors->has('title'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('title') }}</strong>
										</span>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label for="desc" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

								<div class="col-md-6">
									<textarea id="desc" class="form-control{{ $errors->has('desc') ? ' is-invalid' : '' }}" name="desc" required>{{ old('desc') }}</textarea>

									@if ($errors->has('desc'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('desc') }}</strong>
										</span>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label for="video" class="col-md-4 col-form-label text-md-right">{{ __('Video') }}</label>
								<div class="col-md-6">
									{{--<label for="video" class="custom-file-label">{{ __('Choose file') }}</label>--}}
									<input id="video" type="file" class="form-control{{ $errors->has('video') ? ' is-invalid' : '' }}" name="video" required accept="video/*">
									@if ($errors->has('video'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('video') }}</strong>
										</span>
									@endif
								</div>
							</div>

							<div class="form-group row mb-0">
								<div class="col-md-8 offset-md-4">
									<button type="submit" class="btn btn-primary">
										{{ __('Create') }}
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
