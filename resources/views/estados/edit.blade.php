@extends('layout')
@include('select2')
@section('title', '/ Editar Estado')
@section('scripts')
    <script>
    </script>
@endsection

@section('content')

	<h1 class="page-header">Actualizar Estados</h1>

	@include('partials/errors')

	<!-- if there are creation errors, they will show here -->
	{{ Html::ul($errors->all() )}}

		{{ Form::model($estado, array('action' => array('EstadosController@update', $estado->ESTA_ID,), 'method' => 'PUT', 'class' => 'form-vertical')) }}

	  	<div class='col-md-8 col-md-offset-0'>
			@include('widgets.forms.input', ['type'=>'text', 'name'=>'ESTA_DESCRIPCION', 'column'=>8, 'label'=>'Descripción', 'options'=>['maxlength' => '100', 'required'] ])
		</div>


		<div class='col-md-8 col-md-offset-0'>
			@include('widgets.forms.input', ['type'=>'select', 'column'=>5, 'name'=>'TIES_ID', 'label'=>'Tipo de Estado', 'data'=>$arrTipoEstados, 'options'=>['required' ]])
		</div>

		<br><br>

	  

	    <div class='col-md-8 col-md-offset-0'>
			<div class="text-right">
		    	{{ Form::button('<i class="fa fa-exclamation" aria-hidden="true"></i> Reset', array('class'=>'btn btn-warning', 'type'=>'reset')) }}
		        <a class="btn btn-warning" role="button" href="{{ URL::to('estados' ) }}">
		            <i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
		        </a>
				{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Actualizar', array('class'=>'btn btn-primary', 'type'=>'submit')) }}
	    	</div>
	    </div>

	{{ Form::close() }}
    </div><!-- End ng-controller -->

@endsection