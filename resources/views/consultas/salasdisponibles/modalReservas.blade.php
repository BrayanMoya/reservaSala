@section('head')
	<style type="text/css">
		.modal {
		  text-align: center;
		}

		@media screen and (min-width: 768px) {
		  .modal:before {
			display: inline-block;
			vertical-align: middle;
			content: " ";
			height: 100%;
		  }
		}

		.modal-dialog {
		  display: inline-block;
		  text-align: left;
		  vertical-align: middle;
		}

		.fa-3x{
			vertical-align: middle;
		}

		.my-custom-scrollbar {
		position: relative;
		height: 400px;
		overflow: auto;
		}
		.table-wrapper-scroll-y {
		display: block;
		}

	</style>
@parent
@endsection

@section('scripts')
	<script type="text/javascript">
		//Carga de datos a mensajes modales para eliminar y clonar registros
		$(document).ready(function () {
			$('#modalreservas').on('show.bs.modal', function (event) {

				var button = $(event.relatedTarget); // Button that triggered the modal
				var modal = $(this);

				var id = button.data('id'); // Se obtiene valor en data-id
				modal.find('.id').text(id); //Se asigna en la etiqueta con clase id

				var modelo = button.data('modelo');
				modal.find('.modelo').text(modelo);

				var descripcion = button.data('descripcion');
	//				alert(modal.find('.descripcion').text(descripcion));
				modal.find('.descripcion').text(descripcion);

				var index = button.data('index'); // Se obtiene valor Del index del for {i}
				//alert(index);
				var salas = {!! $salasIndex !!};
				//console.log(salas);
				// alert(salas);
				var reservas = salas[index]['reservas'];
				console.log(reservas);
				//alert(reservas);
				var html = '';
				//Cabecera de la tabla
				html += '<h3>reservas de la sala -> '+descripcion+'</h3>'+
						'<div  class="table-wrapper-scroll-y my-custom-scrollbar">'+
			'<table  class="table table-bordered table-striped mb-0" width="100%"  border="0" cellspacing="0" cellpadding="0" style="font-size:12px">'+
                          ' <thead>'+
                            '<tr>'+
                              '<th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">#ID</th>'+
                              '<th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Calendario</th>'+
															'<th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Fech Inicio</th>'+
															'<th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Fech Final</th>'+
															'<th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Descripción</th>'+

							  '</tr>'+
							  '</thead>'+
							  '<tbody>';
						if (reservas.length<=0){ //Si no hay reservas en la sala
							html= '<div class="col-xs-12">'+
          				'<div class="alert alert-danger" id="note1">'+
                    		'La sala seleccionada no tienes reservas asignadas.'+
                    		'</div>'+
                    		'<div class="alert alert-success" id="note2">'+
                    		'Acción: La sala esta disponibles para asignar reservas.'+
                    		'</div>'+
                    	'</div>';
						}else{// Si hay reservas en la sala {Arma tabla}
								for (var i = 0 ; i < reservas.length; i++){
									html +=   '<tr>'+
				                              '<td>'+reservas[i].RESE_ID+'</td>'+
																			'<td>'+reservas[i].RESE_PERIODO+'</td>'+
																			'<td>'+reservas[i].RESE_FECHAINI+'</td>'+
																			'<td>'+reservas[i].RESE_FECHAFIN+'</td>'+
				                              '<td>'+reservas[i].RESE_TITULO+'</td>'+
								  			'</tr>';
								}; //Finaliza el for
							html+= '</tbody>'+
							  '</table>'+
							  '</div>';
							  };//Finaliza el if-else

				modal.find('.reservas').html(html);	//Ingresa html al modal

				var urlForm = button.data('action'); // Se cambia acción del formulario.
				$('.frmModal').attr('action', urlForm);
			});
		});
	</script>
@parent
@endsection

<!-- Mensaje Modal para mostrar reservas-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalreservas" role="dialog" tabindex="-1" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header alert-info">
				<h4 class="modal-title">Reservas <span class="id"></span></h4>
			</div>

			<div class="modal-body">

				<div class="row">
					<div class="col-xs-2">
						<em class="fa fa-tasks  fa-3x fa-fw"></em>
					</div>
					<div class="col-xs-10">
						<!--<h3><span class="descripcion"></span></h3>-->
						<h4><span class="reservas"></span></h4>
					</div>
				</div>
			</div>
          <div class="modal-footer">
            <button type="submit" class="btn-xs btn-danger btn-xs" data-dismiss="modal">
                  <span class="glyphicon glyphicon-remove"></span> Salir
                </button>
          </div>
		</div>
	</div>
</div><!-- Fin de  Mensaje Modal para mostrar reservas-->
