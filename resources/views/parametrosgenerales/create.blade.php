@extends('layout')
@section('title', '/ Crear Parámetro General')
@section('content')

	<h1 class="page-header">Nuevo Parámetro General</h1>

	@include('partials/errors')

	<!-- if there are creation errors, they will show here -->
	{{ Html::ul($errors->all() )}}

		{{ Form::open(array('url' => 'parametrosgenerales', 'class' => 'form-vertical')) }}

		<div class="form-group">
			{{ Form::label('PAGE_DESCRIPCION', 'Descripción') }} 
			{{ Form::text('PAGE_DESCRIPCION', old('PAGE_DESCRIPCION'), array('class' => 'form-control', 'required', 'max:100')) }}
		</div>

		<div class="form-group">
			{{ Form::label('PAGE_VALOR', 'Valor') }} 
			{{ Form::text('PAGE_VALOR', old('PAGE_VALOR'), array('class' => 'form-control', 'required', 'max:3000')) }}
		</div>

		<div class="form-group">
			{{ Form::label('PAGE_OBSERVACIONES', 'Observaciones') }} 
			{{ Form::textarea('PAGE_OBSERVACIONES', old('PAGE_OBSERVACIONES'), array('class' => 'form-control', 'max:3000')) }}
		</div>

		<div class="text-right">
			{{ Form::button('<i class="fa fa-exclamation" aria-hidden="true"></i> Reset', array('class'=>'btn btn-warning', 'type'=>'reset')) }}
			<a class="btn btn-warning" role="button" href="{{ URL::to('parametrosgenerales') }}">
				<i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
			</a>
			{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', array('class'=>'btn btn-primary', 'type'=>'submit')) }}
		</div>

		
		{{ Form::close() }}
@endsection
