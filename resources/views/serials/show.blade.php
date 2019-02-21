@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						@if (Auth::user())
							<serial-details imdb_id="{{ $video['imdb_id'] }}" user_token="{{ Auth::user()->api_token }}"></serial-details>
						@else
							<serial-details imdb_id="{{ $video['imdb_id'] }}" user_token="Null"></serial-details>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
