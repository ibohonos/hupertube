@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<span>Video {{ $video->title }}</span>
					</div>
					<div class="card-body">
						<div>
							<video controls>
								<source src="/play/videos/{{ $video->video }}" type="video/mp4">
							</video>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
