@extends('layout')

@section('content')

<h1 class="page-header">Parámetro General {{ $parametrogeneral->PAGE_ID }} </h1>

	<div class="jumbotron text-center">
		<h3><strong>Parámetro:</strong> {{ $parametrogeneral->PAGE_DESCRIPCION }}
		<p>
			<strong>Valor:</strong> {{ $parametrogeneral->PAGE_VALOR }} <br>
		</p>
		<p>
			<strong>Observaciones:</strong> {{ $parametrogeneral->PAGE_OBSERVACIONES }} <br>
		</p>
	</div>
	<div class="text-right">
		<a class="btn btn-primary" role="button" href="{{ URL::to('parametrosgenerales') }}">
			<i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
		</a>
	</div>

@endsection