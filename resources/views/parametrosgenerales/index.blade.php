@extends('layout')
@section('title', '/ Parámetros Generales')
@include('datatable')
@section('content')

	<h1 class="page-header">Parámetros Generales</h1>
	<div class="row well well-sm">

		<div id="btn-create" class="pull-right">
			
	
			<a class='btn btn-primary' role='button' href="{{ URL::to('parametrosgenerales/create') }}">
				<i class="fa fa-plus" aria-hidden="true"></i> Nuevo Parámetro General
			</a>
		</div>
	</div>
	
<table class="table table-striped" id="tabla">
	<thead>
		<tr class="info">
			<th class="col-md-1">Descripción</th>
			<th class="col-md-2">Valor</th>
			<th class="col-md-1">Observaciones</th>
			<th class="col-md-2">Acciones</th>

		</tr>
	</thead>
	<tbody>
		@foreach($parametrosgenerales as $parametrogeneral)
		<tr>
			<td>{{ $parametrogeneral -> PAGE_DESCRIPCION }}</td>
			<td>{{ $parametrogeneral -> PAGE_VALOR }}</td>
			<td>{{ $parametrogeneral -> PAGE_OBSERVACIONES }}</td>
			<td>

			<!-- Muestra este registro (Utiliza método show encontrado en GET /reservas/{reserva_id}/pregs/{id} -->
				<a class="btn btn-small btn-success btn-xs" href="{{ URL::to('parametrosgenerales/'.$parametrogeneral->PAGE_ID) }}">
					<span class="glyphicon glyphicon-eye-open"></span> Ver
				</a>

				<!-- Edita este registro (Utiliza método edit encontrado en GET /reservas/{reserva_id}/pregs/{id}/edit -->
				<a class="btn btn-small btn-info btn-xs" href="{{ URL::to('parametrosgenerales/'.$parametrogeneral->PAGE_ID.'/edit') }}">
					<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
				</a>

				<!-- Botón Borrar (destroy) -->			
				<!-- Mensaje Modal. Bloquea la pantalla mientras se procesa la solicitud -->				
									
										{{ Form::button('<i class="fa fa-user-times" aria-hidden="true"></i> Borrar',[
										'class'=>'btn btn-xs btn-danger',
										'data-toggle'=>'modal',
										'data-id'=>$parametrogeneral->PAGE_ID,
											'data-modelo'=>'parametrogeneral',
											'data-descripcion'=>$parametrogeneral -> PAGE_DESCRIPCION,
											'data-action'=>'parametrosgenerales/'.$parametrogeneral->PAGE_ID,
											'data-target'=>'#pregModalDelete',
										]) }}
					<!-- Fin Botón Borrar (destroy) -->

							
				
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@include('partials/modalDelete') <!-- incluye el modal del Delete -->
@endsection
