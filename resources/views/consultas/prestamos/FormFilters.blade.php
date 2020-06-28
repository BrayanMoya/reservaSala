@include('select2')
@section('head')
	<style>
		/* Define el tamaño de los input-group-addon para que sean todos iguales */
		.input-group-addon {
			min-width:100px;
			text-align:left;
		}
	</style>
@parent
@endsection



<!-- Filtrar datos en vista -->

<div id="frm-find" class="col-xs-3 col-md-9 col-lg-9">
	<a class='btn btn-primary' role='button' data-toggle="collapse" data-target="#filters" href="#">
		<i class="fa fa-filter" aria-hidden="true"></i>
		<span class="hidden-xs">Filtrar resultados</span>
		<span class="sr-only">Filtrar</span>
	</a>
</div>


<div id="filters" class="collapse">
	<div class="form-group col-xs-6 col-md-4">
		{{ Form::open(['id'=>'formFilter' , 'class' => 'form-vertical']) }}

		<div class="input-group">
			@include('widgets.forms.input', ['type'=>'select', 'column'=>10, 'name'=>'SEDE_ID', 'id'=>'SEDE_ID', 'label'=>'Sede', 'data'=>$arrSedes])
		</div>

		<div class="input-group">
			@include('widgets.forms.input', ['type'=>'select', 'column'=>10, 'name'=>'SALA_ID', 'id'=>'SALA_ID', 'label'=>'Sala', 'data'=>$arrSalas])
		</div>


	{{ Form::close() }}
	</div>
	<div class="form-group col-xs-6 col-md-4">
			<div class="input-group">
				@include('widgets.forms.input', ['type'=>'text', 'name'=>'COD_ID', 'id'=>'COD_ID', 'column'=>10, 'label'=>'Identificación', 'options'=>['maxlength' => '100' ,'placeholder'=>'Ingrese un Documento',] ])
			</div>
			</div>
</div>
