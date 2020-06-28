@extends('layout')

@section('head')
<style type="text/css">
	html, body {height: 100%;}
	body {
		background: url('assets/images/logo-default.png') no-repeat fixed right bottom;
	}
	.panel {
		background: rgba(255, 255, 255, 0.8);
	}
	.container {
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
<h1 class="page-header"></h1>


		<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-body">
					{{ Form::open( [ 'url'=>'login' , 'role'=>'form', 'class'=>'form-vertical' ] ) }}

						<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
							<label for="username" class="control-label">Usuario</label>
							<div class="input-group">
								<span class="input-group-addon"><em class="fa fa-user"></em></span>
								<input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}">
							</div>
							@if ($errors->has('username'))
								<span class="help-block">
									<strong>{{ $errors->first('username') }}</strong>
								</span>
							@endif
						</div>

						<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
							<label for="password" class="control-label">Contraseña</label>
							<div class="input-group">
								<span class="input-group-addon"><em class="fa fa-key"></em></span>
								<input id="password" name="password" type="password" class="form-control" autocomplete="off" max="30">
							</div>
							@if ($errors->has('password'))
								<span class="help-block">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
						</div>

						<div class="form-group">
							<div class="col-md-offset-1">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Recordarme
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">

							<div class="row">
									<div class="col-xs-5">
										<button type="submit" class="btn btn-primary" name="login">
											<i class="fa fa-sign-in"></i> Iniciar sesión
										</button>
									</div>
									<div class="col-xs-6">
										<a class="btn btn-link" href="{{ url('/password/reset') }}">
											¿Olvidó su contraseña?
										</a>
									</div>
								</div>
						</div>
					{{ Form::close() }}
				</div>
			</div>
				<center><img align=center src=assets/images/logogb.png border=0 style="max-width: 145px; max-height: 145px"></center>
		</div>




@endsection
