@extends('layout')
@section('title', '/ Consulta Salas Disponibles')
@section('content')
@include('datatableExport')
@section('scripts')
    <script>

     $(document).ready(function (){

	    var table1 = $('#tabla').DataTable();
      table1.responsive.rebuild();
      table1.responsive.recalc();
      //table1.draw();
      table1.buttons().disable();
      table1.columns( [5] ).visible( false );
      table1.columns.adjust().draw( false );

		/*
		Button filter
		*/
		//BUSQUEDA POR COLUMNA

		$('#COD_ID').on( 'keyup', function () {
		    table1
		        .columns( 3 )
		        .search( this.value )
		        .draw();
		} );

    $('#RECU_ID').change(function () {
        table1
            .columns( 5 )
            .search( $('#RECU_ID option:selected').text() )
            .draw();
    } );

		$('#SALA_ID').change(function () {
		    table1
		        .columns( 2 )
		        .search( $('#SALA_ID option:selected').text() )
		        .draw();
		} );

		//CARGA DE COMBO POR JQUERY

		$('#SEDE_ID').change(function () {
		    table1
		        .columns( 1 )
		        .search( $('#SEDE_ID option:selected').text() )
		        .draw();




		//Habilitar selector de Salas

	 	crsfToken = document.getElementsByName("_token")[0].value;
 		var opcion = $("#SEDE_ID").val();

 				if(opcion != null && typeof opcion !== 'undefined' && opcion != ''){
					$.ajax({
			             url: 'consultaSalas',
			             data: 'sede='+ opcion,
			             dataType: "json",
			             type: "POST",
			             headers: {
			                    "X-CSRF-TOKEN": crsfToken
			                },
			              success: function(sala) {

					        $('#SALA_ID').empty();

							for(var i = 0; i < sala.length; i++){
								$("#SALA_ID").append('<option value=' + sala[i].SALA_ID + '>' + sala[i].SALA_DESCRIPCION + '</option>');
							}


			              },
			              error: function(json){
			                console.log("Error al crear evento ");
			              }
		        	}); //Fin ajax
				}
		});

	  });

     //Obtener fecha del sistemas
		var name="ReporteReservas";
		var title="Reporte De Reservas";
		var columnss= [ 0, 1, 2, 3,4,5, 6, 7, 8, 9, 10 ];
		function fecha(){
				var hoy = new Date();
				var dd = hoy.getDate();
				var mm = hoy.getMonth()+1; //hoy es 0!
				var yyyy = hoy.getFullYear();
				var hora = hoy.getHours();
				var minuto = hoy.getMinutes();
				var segundo = hoy.getSeconds();

				if(dd<10) {
				    dd='0'+dd
				}

				if(mm<10) {
				    mm='0'+mm
				}

				//hoy = mm+'/'+dd+'/'+yyyy;
				hoy = yyyy+mm+dd+'_'+hora+minuto+segundo;

				return hoy;
		}
    </script>
@parent
@endsection

	<h1 class="page-header">Salas Disponibles</h1>
	<div class="row well well-sm">
	@include('consultas/salasdisponibles/FormFilters')


	</div>

<table class="table table-striped" id="tabla">
	<thead>
		<tr class="info">
      <th class="col-xs-1">ID</th>
			<th class="col-xs-2">Sede</th>
			<th class="col-xs-2">Sala</th>
			<th class="col-xs-1">Capacidad</th>
			<th class="col-xs-2">Estado</th>
      <th class="col-xs-1">Recursos</th>
    <th class="col-xs-3"></th>
    <th > </th>
		</tr>
	</thead>
	<tbody>


    @foreach($salasIndex as $key => $val)
    @php ($first = '')

  		<tr>
  			<td>{{ $salasIndex[$key] -> SALA_ID }}</td>
  			<td>{{ $salasIndex[$key] -> sede -> SEDE_DESCRIPCION }}</td>
  			<td>{{ $salasIndex[$key] -> SALA_DESCRIPCION }}</td>
  			<td>{{ $salasIndex[$key] -> SALA_CAPACIDAD }}</td>
  			<td>{{ $salasIndex[$key] -> estado -> ESTA_DESCRIPCION }}</td>
        @foreach($salasIndex[$key] -> recursos as $reservation)
					 @php ($first .= $reservation->RECU_DESCRIPCION . "             " ."\f" )
				 @endforeach
				 <td> {{$first}} </td>
				 <td>



                  <!-- FIN Botón Recursos -->

                  {{ Form::open( ['url' => 'reservas/show', 'method' => 'get', 'class'=>'form-vertical' ]  ) }}
                  <!-- Botón Recursos -->
          {{ Form::button('<i class="fa fa-eye" aria-hidden="true"></i> Recursos',[
            'class'=>'btn btn-xs btn-warning',
                      'data-toggle'=>'modal',
                      'data-id'=>$val -> SALA_ID,
                        'data-modelo'=>'sala',
                        'data-index'=>$key,
                        'data-descripcion'=>$val -> SALA_DESCRIPCION,
                        'data-target'=>'#modalRecursos',
                ]) }}

          <!-- FIN Botón Recursos -->

          <!-- Botón Recursos -->
          {{ Form::button('<i class="fa fa-eye" aria-hidden="true"></i> Reservas',[
            'class'=>'btn btn-xs btn-info',
                      'data-toggle'=>'modal',
                      'data-id'=>$val -> SALA_ID,
                        'data-modelo'=>'sala',
                        'data-index'=>$key,
                        'data-descripcion'=>$val -> SALA_DESCRIPCION,
                        'data-target'=>'#modalreservas',
                ]) }}
                   <input name="sala" type="hidden" value="{{$val->SALA_ID}}">
                  {{ Form::button('<i class="fa fa-ticket" aria-hidden="true"></i> Reservar', [
                  'class'=>'btn btn-xs btn-primary',
                  'type'=>'submit',
                  ]) }}
                  {{ Form::close() }}


				  </td>
          <td>
          </td>
		</tr>
		@endforeach
	</tbody>
</table>
@include('consultas/salasdisponibles/modalRecursos')
@include('consultas/salasdisponibles/modalReservas')
@endsection
