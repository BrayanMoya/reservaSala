@extends('layout')
@include('select2')
@section('title', '/ Editar Sala '.$sala->SALA_ID)
@section('scripts')
    <script>
    </script>
@endsection

@section('content')
	<h1 class="page-header">Actualizar Sala</h1>

	@include('partials/errors')

	{{ Form::model($sala, [ 'action' => [ 'SalasController@update', $sala->SALA_ID ], 'method' => 'PUT', 'files' => true, 'class' => 'form-vertical' ]) }}

	  	<div class='col-md-8 col-md-offset-0'>
			@include('widgets.forms.input', ['type'=>'text', 'name'=>'SALA_DESCRIPCION', 'column'=>10, 'label'=>'Descripción', 'options'=>['maxlength' => '300', 'required'] ])
		</div>

		<div class='col-md-8 col-md-offset-0'>
			@include('widgets.forms.input', ['type'=>'number', 'name'=>'SALA_CAPACIDAD', 'column'=>5, 'label'=>'Capacidad de Personas', 'options'=>['maxlength' => '300', 'required'] ])
		</div>

		<!--
		@include('widgets.forms.input', ['type'=>'file', 'name'=>'AUSE_ARCHIVO', 'label'=>'Soporte', 'options'=>['accept' =>'image/*']])
		-->

		<div class='col-md-8 col-md-offset-0'>
			{{ Form::label('SALA_FOTOSALA', 'Foto Sala') }}
			{{ Form::file('SALA_FOTOSALA', [ 
				'class' => 'form-control',
				'accept' => 'image/*',
				'max' => '500',
				'column' => 4,
				'required',
			]) }}
		</div>

		<div class='col-md-8 col-md-offset-0'>
			{{ Form::label('SALA_FOTOCROQUIS', 'Foto Croquis') }}
			{{ Form::file('SALA_FOTOCROQUIS', [ 
				'class' => 'form-control',
				'accept' => 'image/*',
				'max' => '500',
				'column' => 4,
				'required',
			]) }}
		</div>

		<div class='col-md-8 col-md-offset-0'>
			@include('widgets.forms.input', ['type'=>'select', 'column'=>4, 'name'=>'ESTA_ID', 'label'=>'Estado', 'data'=>$arrEstadosSala, 'options'=>['required' ]])

			@include('widgets.forms.input', ['type'=>'select', 'column'=>4, 'name'=>'SEDE_ID', 'label'=>'Sede', 'data'=>$arrSedes, 'options'=>['required' ]])

		</div>

		<div class='col-md-8 col-md-offset-0'>
			@include('widgets.forms.input', ['type'=>'textarea', 'name'=>'SALA_OBSERVACIONES', 'column'=>10, 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])
		</div>

		<!-- Botones -->
		<div class='col-md-8 col-md-offset-0'>
			<div class="text-right">
		    	{{ Form::button('<i class="fa fa-exclamation" aria-hidden="true"></i> Reset', array('class'=>'btn btn-warning', 'type'=>'reset')) }}
		        <a class="btn btn-warning" role="button" href="{{ URL::to('salas/') }}">
		            <i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
		        </a>
				{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Actualizar', array('class'=>'btn btn-primary', 'type'=>'submit')) }}
			</div>
	    </div>

	{{ Form::close() }}
    </div>

@endsection