@push('head')
	{!! Html::style('assets/stylesheets/toastr.min.css') !!}
@endpush

@push('scripts')
	{!! Html::script('assets/scripts/toastr.min.js') !!}
	{!! Html::script('assets/scripts/metodosVarios.js') !!}
	<script>		
		var fecha = new Fecha();
		var salario = 0;
		//fecha.elementoFechaActual('{{$fecha1}}');
		//fecha.elementoFechaActual('{{$fecha2}}');
		llenaDias('{{$fecha2}}');
		//Variable para validad Fecha Accidente
		var fechaAccidente="{{isset($fecha3) ? $Fecha3=$fecha3 : $Fecha3='NO_APLICA'}}";
		//Variable necesaria para prorroga ausentismo
		var FechaFinAuse="{{isset($fechaFin) ? $FechaFinAuse=$fechaFin : $FechaFinAuse='NO_APLICA'}}";

		$(document).on('blur','#{{$fecha1}}',function(){			
			if (fecha.validaFecha("{{$fecha1}}","{{$fecha2}}")) {
				fecha.mensaje("La fecha inicial no puede ser mayor a la fecha final");
				fecha.limpiaElemento('{{$fecha1}}');
				limpiaDias();
			}else{
				llenaDias('{{$fecha2}}');
			}
			
			if (FechaFinAuse=='FECHA_ADICIONAL') {				
				if (!fecha.validaFecha("{{$fecha1}}","<?php echo $FechaFinAuse; ?>")) {	
					fecha.mensaje("La fecha inicial no puede ser menor a la fecha final del ausentismo o prorroga");
					fecha.limpiaElemento('{{$fecha1}}');
					limpiaDias();		
				}else{
					llenaDias('{{$fecha2}}');
				}				
			}
			
		});	
		/*
		$(document).on('blur','#AUSE_DIAS',function(){
			$('#{{$fecha2}}').val(fecha.sumaDias($('#{{$fecha1}}').val(),$('#AUSE_DIAS').val()));
		});	*/

		//fecha.sumaDias($('#{{$fecha1}}').val(),$('#AUSE_DIAS').val())
		$(document).on('blur','#{{$fecha2}}',function(){
			if (fecha.validaFecha("{{$fecha1}}","{{$fecha2}}")) {
				fecha.mensaje("La fecha inicial no puede ser mayor a la fecha final");
				fecha.limpiaElemento('{{$fecha2}}');
				limpiaDias();
			}else{
				llenaDias('{{$fecha2}}');
			} 
		});	
		//La fecha del accidente no puede ser mayor la de la fecha inicial del ausentismo
		$(document).on('blur',"#<?php echo $Fecha3; ?>",function(){	
			if (fecha.validaFecha('<?php echo $Fecha3; ?>',"{{$fecha1}}")) {
				fecha.mensaje("La fecha del Accidente no puede ser mayor a la fecha final");
				fecha.limpiaElemento('<?php echo $Fecha3; ?>');
			}
		});	

		function llenaDias(fechaFinal){

				$('#AUSE_DIAS').val(fecha.cantDias(fecha.fechaElemento('{{$fecha1}}'),fecha.fechaElemento(fechaFinal)));
				$('#PROR_DIAS').val(fecha.cantDias(fecha.fechaElemento('{{$fecha1}}'),fecha.fechaElemento(fechaFinal)));
				//si los días de ausentismos y el ibc son mayores a cero, se realiza el cálculo del costo de ausentismo
				//=====================================================================================================
				var dias = $('#AUSE_DIAS').val();
				var ibc = $('#AUSE_IBC').val();
				if(dias>0 && ibc>0){			
					var valor = Math.round( (ibc/30)*dias );
					$('#AUSE_VALOR').val(valor);
				}else{
					$('#AUSE_VALOR').val("");
				}
				//=====================================================================================================

				$coau_id = $('#COAU_ID').val();
				$ause_dias = $('#AUSE_DIAS').val();
				$contrato = $('#CONT_ID').val();
				$fechainicio = $('#AUSE_FECHAINICIO').val();
				$fechafinal = $('#AUSE_FECHAFINAL').val();

				if($coau_id>0 && $ause_dias>0 && $contrato>0 && $fechainicio!=null && $fechafinal!= null){
				/*
				 KevinR: llamado ajax al metodo getDeterminaCartera del módulo de Ausentismos, con estos datos se determina la cantidad de días que asume la empresa y las entidades de seguridad social sobre una incapacidad de cualquier tipo.
				*/

					$.ajax({
						url: '{{url('cnfg-ausentismos/getDeterminaCartera')}}/'+$coau_id+'/'+$contrato+'/'+$fechainicio+'/'+$fechafinal,
						dataType: 'json',
						type:     'GET'
						//headers: {'X-CSRF-TOKEN': csrfToken}
					})
					.done(function( data, textStatus, jqXHR ) {
						//data[0] en este caso contiene la confirmación que determina si el concepto es sujeto a cartera
						if(data[0] == 'true'){
							if($ause_dias <= data[1]){
								$('#AUSE_DIASEMPRESA').val($ause_dias);
								$('#AUSE_DIASENTIDAD').val(0);
							}else{	
								//si es sujeto a cartera entonces los días que asume la entidad se determinan por la siguiente formula: DÍAS ASUME ENTIDAD = TOTAL DÍAS AUSENTISMO - DÍAS QUE ASUME LA EMPRESA. (los días que asume la empresa vienen dentro del arreglo en data[1])
								$('#AUSE_DIASENTIDAD').val($ause_dias - data[1]);
								//los días que asume la empresa son los que vengan en el arreglo en data[1] que son los que estan contenidos en el ParametroGeneral
								$('#AUSE_DIASEMPRESA').val(parseInt(data[1]));
							}
						}else{
							//si el concepto NO es sujeto a cartera de incapacidades, entonces los días total de ausentismos son los mismos que asume la empresa
							$('#AUSE_DIASENTIDAD').val(0);
							$('#AUSE_DIASEMPRESA').val($ause_dias);
						}

						if(data[2] == 'true'){
							//si el ausentismo se encuentra en periodo de carencia, entonces los días para la entidad son cero y la totalidad de días del ausentismo son asumidos por la empresa.
							$('#AUSE_DIASENTIDAD').val(0);
							$('#AUSE_DIASEMPRESA').val($ause_dias);
						}						
					})
					.fail(function( jqXHR, textStatus, errorThrown ) {
						//console.log('Err: '+JSON.stringify(jqXHR));
						//$('#response').html(event.responseText);
					})
					.always(function( data, textStatus, jqXHR ) {
						if (jqXHR === 'Forbidden')
							toastr['error']('Error en la conexión con el servidor. Presione F5.', 'Error');
						
						if (typeof jqXHR.responseJSON === 'undefined')
							toastr['error']('NetworkError: 500 Internal Server Error.', 'Error');

					});

				}

				$coau_id = $('#COAU_ID').val();
				$pror_dias = $('#PROR_DIAS').val();
				$contrato = $('#CONT_ID').val();
				$fechainicio = $('#PROR_FECHAINICIO').val();
				$fechafinal = $('#PROR_FECHAFINAL').val();

				if($coau_id>0 && $pror_dias>0 && $contrato>0 && $fechainicio!=null && $fechafinal!= null){
				/*
				 Exclusivo para Prorrogas de Ausentismos
				 KevinR: llamado ajax al metodo getDeterminaCartera del módulo de Ausentismos, con estos datos se determina la cantidad de días que asume la empresa y las entidades de seguridad social sobre una incapacidad de cualquier tipo.
				*/

					$.ajax({
						url: '{{url('cnfg-ausentismos/getDeterminaCartera')}}/'+$coau_id+'/'+$contrato+'/'+$fechainicio+'/'+$fechafinal,
						dataType: 'json',
						type:     'GET'
						//headers: {'X-CSRF-TOKEN': csrfToken}
					})
					.done(function( data, textStatus, jqXHR ) {
						//data[0] en este caso contiene la confirmación que determina si el concepto es sujeto a cartera
						if(data[0] == 'true'){

							if(data[2] == 'true'){
								//si el ausentismo se encuentra en periodo de carencia, entonces los días para la entidad son cero y la totalidad de días del ausentismo son asumidos por la empresa.
								$('#PROR_DIASENTIDAD').val(0);
								$('#PROR_DIASEMPRESA').val($ause_dias);
							}else{
								$('#PROR_DIASENTIDAD').val($ause_dias);
								$('#PROR_DIASEMPRESA').val(0);
							}	
						}else{
							//si el concepto NO es sujeto a cartera de incapacidades, entonces los días total de ausentismos son los mismos que asume la empresa
							$('#PROR_DIASENTIDAD').val(0);
							$('#PROR_DIASEMPRESA').val($ause_dias);
						}

					})
					.fail(function( jqXHR, textStatus, errorThrown ) {
						//console.log('Err: '+JSON.stringify(jqXHR));
						//$('#response').html(event.responseText);
					})
					.always(function( data, textStatus, jqXHR ) {
						if (jqXHR === 'Forbidden')
							toastr['error']('Error en la conexión con el servidor. Presione F5.', 'Error');
						
						if (typeof jqXHR.responseJSON === 'undefined')
							toastr['error']('NetworkError: 500 Internal Server Error.', 'Error');

					});

				}

		}

		function limpiaDias(){
			$('#AUSE_DIAS').val("");
			$('#PROR_DIAS').val("");
			$('#AUSE_DIASEMPRESA').val("");
			$('#AUSE_DIASENTIDAD').val("");
			$('#PROR_DIASEMPRESA').val("");
			$('#PROR_DIASENTIDAD').val("");
		}
		
		//==================================================================================
		//Bloque 1: KevinR
		//Se trae el salario del contrato seleccionado para ponerlo como IBC del ausentismo
		$('#CONT_ID').change(function(){
			if(this.value>0){
				$.ajax({
					url: '{{url('gestion-humana/getContrato')}}/'+this.value,
					dataType: 'json',
					type:     'GET'
					//headers: {'X-CSRF-TOKEN': csrfToken}
				})
				.done(function( data, textStatus, jqXHR ) {
					//$( "#success-indicator" ).fadeIn(100).delay(1000).fadeOut();
					if ( data.length == 1 )
						this.salario = data[0]['CONT_SALARIO'];
						if(this.salario != 0)
							$('#AUSE_IBC').val(this.salario);
				})
				.fail(function( jqXHR, textStatus, errorThrown ) {
					//console.log('Err: '+JSON.stringify(jqXHR));
					//$('#response').html(event.responseText);
				})
				.always(function( data, textStatus, jqXHR ) {
					if (jqXHR === 'Forbidden')
						toastr['error']('Error en la conexión con el servidor. Presione F5.', 'Error');
					
					if (typeof jqXHR.responseJSON === 'undefined')
						toastr['error']('NetworkError: 500 Internal Server Error.', 'Error');

				});
			}

		});
		//Fin Bloque 1
		//==================================================================================	
		
	</script>
@endpush