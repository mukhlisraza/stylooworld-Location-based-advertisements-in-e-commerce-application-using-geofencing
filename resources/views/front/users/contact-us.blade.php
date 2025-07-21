@extends('layouts.front_layout.front_layout')
@section('content')

<section>
	<div class="container">
		<div id="contact-page" class="container">
			<div class="bg">
				<div class="row">
					<div class="col-sm-12">
						<h2 class="title text-center">Contact <strong>Us</strong></h2>

					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="contact-form">
							@if($errors->any())
							<div class="alert alert-danger" style="margin-top:10px;">
								<ul>
									@foreach($errors->all() as $errors)
									<li>
										{{$errors}}
									</li>
									@endforeach
								</ul>
							</div>
							@endif
							@if (Session::has('error_message'))
							<div class="alert alert-danger " role="alert">
								{{Session::get('error_message') }}
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							@endif

							@if (Session::has('success_message'))
							<div class="alert alert-success " role="alert">
								{{Session::get('success_message') }}
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							@endif

							<div class="status alert alert-success" style="display: none"></div>
							<form id="main-contact-form" action="{{url('/contact')}}" class="contact-form row" name="contact-form" method="post">
								@csrf
								<div class="form-group col-md-6">
									<input type="text" name="name" id="name" class="form-control" required="required" placeholder="Name">
								</div>
								<div class="form-group col-md-6">
									<input type="email" name="email" id="email" class="form-control" required="required" placeholder="Email">
								</div>
								<div class="form-group col-md-12">
									<input type="text" name="subject" id="subject" class="form-control" required="required" placeholder="Subject">
								</div>
								<div class="form-group col-md-12">
									<textarea name="message" id="message" id="message" required="required" class="form-control" rows="8" placeholder="Your Message Here"></textarea>
								</div>
								<div class="form-group col-md-12">
									<button type="submit" class="btn btn-primary pull-right">Send</button>
								</div>
							</form>
						</div>
					</div>

				</div>
			</div>
		</div>
		<!--/#contact-page-->
	</div>
	</div>
</section>

@endsection