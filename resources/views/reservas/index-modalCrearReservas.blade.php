
@section('scripts')
<script type="text/javascript">
$(document).ready(function () {

	$('#btn-reservar').click(function() {
				if($('#tipoRepeticionHF').is(':checked')) { 
					var varfechaHasta = $('#fechaHasta').data("DateTimePicker").date();
					//var varfechaHasta1 = moment(varfechaHasta, 'YYYY-MM-DD HH:mm').format('YYYY-MM-DD HH:mm');
					  if (varfechaHasta === null) {
					  //	alert('esta blanco');
				//	  	alert(varfechaHasta);

					  	$.msgBox({
							title:"Información",
							content:"El campo Fecha Hasta esta vacio",
							type:"warning"
						}); 

        				//alert('El campo Fecha Hasta esta vacio');
        			$("#fechaHasta").focus();
        			return false;
    				}

				//	alert(varfechaHasta); 

	}

    //Se obtiene el valor del campo
    var name = $('#nHoras').val();

    //Se verifica que el valor del campo este vacio
    if (name === '') {
          	$.msgBox({
							title:"Información",
							content:"El campo Horas está vacio",
							type:"warning"
						}); 
        $("#nHoras").focus();
        return false;
    }
    //Se verifica longitud del campo
    else if (name.length != 1) {
           	$.msgBox({
							title:"Información",
							content:"La longitud del campo hora es incorrecta",
							type:"warning"
						}); 
        return false;
    }

    var selectPeriodo= $('#RESE_PERIODO').val();

       if (selectPeriodo == '' || selectPeriodo == null) {
	      	 	$.msgBox({
								title:"Información",
								content:"Debes seleccionar un Periodo",
								type:"warning"
							}); 
	      	$("#RESE_PERIODO").focus();
	        return false;
        }

    var selectFranja= $('#RESE_FRANJA').val();

       if (selectFranja == '' || selectFranja == null) {
	      	 	$.msgBox({
								title:"Información",
								content:"Debes seleccionar una Franja",
								type:"warning"
							}); 
	      	$("#RESE_FRANJA").focus();
	        return false;
        }

    var selectFaculta = $('#RESE_FACULTAD').val();

       if (selectFaculta == '' || selectFaculta == null) {
	      	 	$.msgBox({
								title:"Información",
								content:"Debes seleccionar una Facultad",
								type:"warning"
							}); 

	      	$("#RESE_FACULTAD").focus();
	        return false;
    	}

    var selectPrograma = $('#RESE_PROGRAMA').val();

       if (selectPrograma == '' || selectPrograma == null) {
	      	 	$.msgBox({
								title:"Información",
								content:"Debes seleccionar un Programa",
								type:"warning"
							}); 

	      	$("#RESE_PROGRAMA").focus();
	        return false;
    	}

    var selectGrupo = $('#RESE_GRUPO').val();

       if (selectGrupo == '' || selectGrupo == null) {
	      	 	$.msgBox({
								title:"Información",
								content:"Debes seleccionar un Grupo",
								type:"warning"
							}); 
	      	$("#RESE_GRUPO").focus();
	        return false;
    	}

     var selectAsignatura = $('#RESE_MATERIA').val();

       if (selectAsignatura == '' || selectAsignatura == null) {
	      	//alert("Debes seleccionar una Asignatura");
	      	 	$.msgBox({
								title:"Información",
								content:"Debes seleccionar una Asignatura",
								type:"warning"
							}); 
	      	$("#RESE_MATERIA").focus();
	        return false;
    	}


	});

});

$(function () {

	

	
	//Se determina cuales son los días de la semana que se encuentran seleccionados
	$("input[name=chkdias]").click(function(){
	  adiassel = $("input[name=chkdias]:checked").map(function(){
					return $(this).val();
				}).get();
	  console.log(adiassel);
	});




});
</script>
@parent
@endsection

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalcrearres" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content panel-info">

			<div class="modal-header panel-heading" style="border-top-left-radius: inherit; border-top-right-radius: inherit;">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Cerrar</span>
				</button>
				<h4 class="modal-title">Crear Reservas</h4>
			</div>

			<div class="modal-body">

				<div class="form-vertical" role="form">

				<div class="row">
						<div class="col-xs-7 form-group">
							<label>Desde:</label>
							<div class='input-group date' id='fechaInicio'>
								<input type='text' class="form-control" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>

						<div class="col-xs-5 form-group">
							<label>Horas:</label>
							<input type='number' class="form-control" min="1" max="12" id="nHoras" placeholder="No. de horas" />
						</div>

					</div>


					<div id="cp3" class="input-group colorpicker-component hide">
						<input type="text" class="form-control" id="color" readonly="true" />
						<span class="input-group-addon"><em></em></span>
					</div>

					<div class="form-group">
						<label>Tipo de Repetición:</label>
						<div class="input-group">
							<label class="radio-inline form-check-label">
								<input class="form-check-input" type="radio" name="tipoRepeticion" value="ninguna" checked>
								Ninguna
							</label>

            				@if (in_array(Auth::user()->rol->ROLE_ROL , ['audit','admin']))
							<label class="radio-inline">
								<input class="form-check-input" id="tipoRepeticionHF" type="radio" name="tipoRepeticion" value="hasta">
								Hasta una Fecha
							</label>
							@endif
						</div>
					</div>

					<div class="form-group reservaPorDias reservaHastaFecha hide">
						<label>Hasta:</label>
						<div class='input-group date' id='fechaHasta'>
							<input type='text' class="form-control" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>

					<div class="form-group reservaPorDias reservaHastaFecha hide">
						<label for="chkdias">Dias:</label>
						<div class="input-group">
							<select id="chkdias" name="chkdias[]" class="form-control" multiple="multiple" required>
								<option value="lunes" id="lu">Lunes</option>
								<option value="martes" id="ma">Martes</option>
								<option value="miércoles" id="mi">Miércoles</option>
								<option value="jueves" id="ju">Jueves</option>
								<option value="viernes" id="vi">Viernes</option>
								<option value="sábado" id="sa">Sábado</option>
								<option value="domingo" id="do" disabled>Domingo</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<!--
						<label>Facultad:</label>
						<div class="selectContainer">
							<select class="form-control" name="size" id="cboxFacultades">
							  <option selected disabled>Seleccione...</option>
							</select>
						</div>
						-->
						@include('widgets.forms.input', ['type'=>'select', 'column'=>5, 'name'=>'RESE_PERIODO', 'id'=>'RESE_PERIODO', 'label'=>'Periodo', 'data'=>$arrPeriodos, 'value'=>$arrPeriodos, 'options'=>['required', 'allowClear'=>false]])

						@include('widgets.forms.input', ['type'=>'select', 'column'=>10, 'name'=>'RESE_FRANJA', 'id'=>'RESE_FRANJA', 'label'=>'Franja', 'data'=>$arrFranjas, 'placeholder'=>'Seleccione...','allowClear'=>true, 'options'=>['required']])						

						@include('widgets.forms.input', ['type'=>'select', 'column'=>10, 'name'=>'RESE_FACULTAD', 'id'=>'RESE_FACULTAD', 'label'=>'Facultad', 'data'=>$arrFacultades, 'options'=>['required', 'allowClear'=>true]])

						@include('widgets.forms.input', ['type'=>'select', 'column'=>10, 'name'=>'RESE_PROGRAMA', 'id'=>'RESE_PROGRAMA', 'label'=>'Programa', 'data'=>$arrProgramas, 'placeholder'=>'Seleccione...','allowClear'=>true, 'options'=>['required']])

						@include('widgets.forms.input', ['type'=>'select', 'column'=>10, 'name'=>'RESE_GRUPO', 'id'=>'RESE_GRUPO', 'label'=>'Grupo', 'data'=>$arrGrupos, 'placeholder'=>'Seleccione...','allowClear'=>true, 'options'=>['required']])

						@include('widgets.forms.input', ['type'=>'select', 'column'=>10, 'name'=>'RESE_MATERIA', 'id'=>'RESE_MATERIA', 'label'=>'Materia', 'data'=>$arrMaterias, 'placeholder'=>'Seleccione...','allowClear'=>true, 'options'=>['required']])

						<!-- ============================= WebService Grupos ============================= -->
						@include('widgets.select-dependientews', ['url'=>'/buscaPrograma', 'selectPadre'=>'RESE_FACULTAD', 'selectHijo'=>'RESE_PROGRAMA', 'nombreBusqueda'=>'nombre', 'keyName'=>'codigo', 'keyValue'=>'nombre', 'auxValue'=>0, 'auxValue2'=>0, 'concatenado'=>0, 'campoconcat'=>0, 'placeholder'=>'Seleccione un Programa'])

						@include('widgets.select-dependientews', ['url'=>'/buscaGrupo', 'selectPadre'=>'RESE_PROGRAMA', 'selectHijo'=>'RESE_GRUPO', 'nombreBusqueda'=>'grupo', 'keyName'=>'grupo', 'keyValue'=>'grupo', 'auxValue'=>'RESE_FRANJA', 'auxValue2'=>'RESE_PERIODO', 'concatenado'=>0, 'campoconcat'=>0, 'placeholder'=>'Seleccione un Grupo'])

						@include('widgets.select-dependientews', ['url'=>'/buscaMateria', 'selectPadre'=>'RESE_GRUPO', 'selectHijo'=>'RESE_MATERIA', 'nombreBusqueda'=>'codMateria', 'keyName'=>'codMateria', 'keyValue'=>'nombreMateria', 'auxValue'=>'RESE_PERIODO', 'auxValue2'=>0, 'concatenado'=>'- SEMESTRE: ', 'campoconcat'=>'semestre', 'placeholder'=>'Seleccione un Grupo'])
						<!-- ================================================================================= -->
					</div>					

				</div> <!-- end Form -->
			</div>
						
			<div class="modal-footer">
				
				
				<button id="btn-reservar" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#msgModalProcessing">
					Crear Reserva
				</button>
				
				<button type="button" class="btn btn-default" data-dismiss="modal" id="cerrarmodal">
					Cerrar
				</button>
			</div>
		</div> <!-- end modal-content -->
	</div><!-- end modal-dialog -->
</div>

@include('select2')


