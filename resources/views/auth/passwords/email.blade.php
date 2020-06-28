@extends('layout')

<!-- Main Content -->

@section('head')
<style type="text/css">
	html, body {height: 100%;}
	body {
		background: url('../assets/images/logo-default.png') no-repeat fixed center;
	}
	.panel {
		background: rgba(255, 255, 255, 0.91);
	}
	.container {
		margin-top: 0px !important;
		height: 100%;
		width: 100%;
		display: table;
	}
	.row {
		display: table-cell;
		height: 100%;
		vertical-align: middle;
	}
</style>
@parent
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">¿Olvidó su Contraseña?</div>
				<div class="panel-body">


					@if ($errors->has('email'))
						@if (session('status'))
							<div class="alert alert-danger">
								{{ session('status') }}
							</div>
						@endif
					@else
						@if (session('status'))
							<div class="alert alert-success">
								{{ session('status') }}
							</div>
						@endif
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
						{{ csrf_field() }}

						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							<label for="email" class="col-md-4 control-label">Usuario Academusoft</label>

							<div class="col-md-6">
								<input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">

								@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									<i class="fa fa-btn fa-envelope" aria-hidden="true"></i> Enviar enlace al correo
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
