<script type="text/javascript">
$(function () {

	//Token para envío de peticiones por ajax a los controladores de Laravel
	var crsfToken = $('meta[name="csrf-token"]').attr('content');
	var sala = getUrlParameter('sala');
	//var equipo = getUrlParameter('equipo');
	var equipo = null;

	//Se obtienen los días de la semana seleccionados y se almacena en la variable global 'diasSemSelected'
	//Dropdown con lista de dias de la semana [lunes-sabado]
	var diasSemSelected = ["lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
	$('#chkdias').multiselect({
		//maxHeight: 400,
		//dropUp: true,
		numberDisplayed: 8,
		//buttonWidth: '300px',
		nonSelectedText: 'Ninguno',
		onChange: function(option, checked, select) {
			diasem = $(option).val();
			if(checked)
				diasSemSelected.push(diasem);
			else
				diasSemSelected = $(diasSemSelected).not([diasem]).get();

			console.log(diasSemSelected);
		}
	});
	$('#chkdias').multiselect('selectAll', false);
	$('#chkdias').multiselect('updateButtonText');
	/*$("#chkdias").on('change', function(){
		diasSemSelected = $(this).find('option:selected').map(function(){
							return $(this).val();
						}).get();
		console.log(diasSemSelected);
	});*/

	//Inicialización de inputs tipo DataPicker
	var optionsDtPicker = {
		locale: 'es',
		stepping: 30,
		sideBySide: true, // Muestra la hora yla fecha juntas
		useCurrent: false,  //Important! See issue #1075. Requerido para minDate
		minDate: moment(), //-1 Permite seleccionar el dia actual
		defaultDate: moment().add(30,'minutes'), //-1 Permite seleccionar el dia actual
		daysOfWeekDisabled: [0],//Deshabilita el día domingo
		//enabledHours: (Array)[7,8,9,10,11,12,13,14,15,16,17,18,19,20,21],
		//disabledHours: (Array)[0,1,2,3,4,5,6,22,23], //Deshabilita las horas en las cuales no hay servicio de reserva
		//disabledDates: getFestivos(), //No funciona porque el arreglo debe ser objMoment o mm/dd/yyyy
		icons: {
			time: "fa fa-clock-o",
			date: "fa fa-calendar",
			up: "fa fa-arrow-up",
			down: "fa fa-arrow-down",
			previous: 'fa fa-chevron-left',
			next: 'fa fa-chevron-right',
			today: 'glyphicon glyphicon-screenshot',
			clear: 'fa fa-trash',
			close: 'fa fa-times'
		},
		tooltips: {
			//today: 'Go to today',
			//clear: 'Clear selection',
			//close: 'Close the picker',
			selectMonth: 'Seleccione Mes',
			prevMonth: 'Mes Anterior',
			nextMonth: 'Mes Siguiente',
			selectYear: 'Seleccione Año',
			prevYear: 'Año Anterior',
			nextYear: 'Año Siguiente',
			selectDecade: 'Seleccione Década',
			prevDecade: 'Década Anterior',
			nextDecade: 'Década Siguiente',
			prevCentury: 'Siglo Anterior',
			nextCentury: 'Siglo Siguiente'
		}
	};

	$('#fechaInicio').datetimepicker(optionsDtPicker);
	$('#fechaInicio').data("DateTimePicker").options({
		format: 'YYYY-MM-DD HH:mm'
	});
	$('#fechaInicio').data("DateTimePicker").disabledHours([0,1,2,3,4,5,6,22,23]);

	$('#fechaHasta').datetimepicker(optionsDtPicker);
	$('#fechaHasta').data("DateTimePicker").options({
		format: 'YYYY-MM-DD'
	});
	$('#fechaHasta').data("DateTimePicker").clear();

    $("#fechaInicio").on("dp.change", function (e) {
        $('#fechaHasta').data("DateTimePicker")
        	.minDate(e.date)
        	.clear();
    });

    $("#fechaHasta").on("dp.change", function (e) {
    });


	//
	//Al cambiar valor de radios 'tipoRepeticion', se habilitan los form requeridos según el tipo de repetición. 
	var tipoRepetChecked;
	$("input[name=tipoRepeticion]").click(function(){

		tipoRepetChecked = $(this).filter(':checked').val();

		switch(tipoRepetChecked){
			//case 'semana': //si el R.B es el de reservar semanalmente, se muestran todos los checkbox
			//	$('.checkbox').show();
			//	break;
			case 'hasta': //Reserva diaria hasta la fecha seleccionada.
				$('.reservaPorDias').addClass('hide');
				$('.reservaHastaFecha').removeClass('hide');
				break;
			case 'pordias': //Reserva para los días de la semana seleccionados hasta la fecha seleccionada.
				$('.reservaHastaFecha').addClass('hide');
				$('.reservaPorDias').removeClass('hide');
				break;
			default: //Reseva sin repetición
				$('#fechaHasta').val('');
				$('.reservaHastaFecha').addClass('hide');
				$('.reservaPorDias').addClass('hide');
		}
	});

/***** FIN Funciones y eventos para llenar dropdown/combobox *****/


/***** Funciones para reservar *****/
	//$('#btn-reservar').on('click', function() {
	$('#msgModalProcessing').on('shown.bs.modal', function() {

		tipoRepetChecked = $("input[name=tipoRepeticion]").filter(':checked').val();

		switch(tipoRepetChecked){
			case 'hasta': //Reserva diaria hasta la fecha seleccionada.
				reservaHastaFecha();
				break;
			/*case 'pordias': //Reserva para los días de la semana seleccionados hasta la fecha seleccionada.
				reservaPorDias();
				break;*/
			case 'ninguna':
				reservaHastaFecha();
				break;
		}
		//$('#msgModalProcessing').modal('handleUpdate')
		//window.setTimeout(function(){ location.reload(); }, 1000);
	});



	function reservaHastaFecha() {

		/***** COPIADO DESDE  reservaSinRepeticion ******/

		var titulo = 'RS.R';
		var todoeldia = false;

		//Obteniendo valores del formulario
		var fechaini = $('#fechaInicio').data("DateTimePicker").date();
		var fechainicio = moment(fechaini, 'YYYY-MM-DD HH:mm').format('YYYY-MM-DD HH:mm');
		var nhoras = $('#nHoras').val();

		//se le adiciona el numero de horas
		var fechafin = moment(fechaini).add(nhoras, 'hours');
		var fechafinal = moment(fechafin,'YYYY-MM-DD HH:mm').format('YYYY-MM-DD HH:mm');

		var nomfranja	= $("#RESE_FRANJA option:selected" ).text();
		var nomfacultad = $("#RESE_FACULTAD option:selected" ).text();
		var nomprograma = $("#RESE_PROGRAMA option:selected" ).text();
		var nomgrupo 	= $("#RESE_GRUPO option:selected" ).text();
		var nommateria  = $("#RESE_MATERIA option:selected" ).text();

		var periodo = 	$("#RESE_PERIODO").val();
		var franja = 	$("#RESE_FRANJA").val();
		var facultad = 	$("#RESE_FACULTAD").val();
		var programa = 	$("#RESE_PROGRAMA").val();
		var grupo = 	$("#RESE_GRUPO").val();
		var materia = 	$("#RESE_MATERIA").val(); 
		var docente = 	$("#RESE_MATERIA").val();
		
		var titulo = nomfranja + ' ' + nomprograma + ' ' + nomgrupo + ' ' + nommateria;
		/***** FIN  COPIADO DESDE  reservaSinRepeticion ******/

		//variable para almacenar el valor de la fecha de inicio formateada a YYYY-MM-DD de la
		//reserva que se pretende realizar
		var fini = $('#fechaInicio').data("DateTimePicker").date();
		fini = moment(fini, 'YYYY-MM-DD HH:mm').format('YYYY-MM-DD');

		var fechahasta = $('#fechaHasta').data("DateTimePicker").date();
		if(fechahasta == null || fechahasta.format('YYYY-MM-DD') == fini){
			fechahasta = moment(fini).add(nhoras, 'hours').format('YYYY-MM-DD HH:ss');;
		} else {
			fechahasta = moment(fechahasta, 'YYYY-MM-DD HH:mm').format('YYYY-MM-DD');
		}

		if(fini > fechahasta){
			$.msgBox({
				title:"Error",
				content:"¡Fecha inicial no puede ser mayor a la fecha final! ",
				type:"error"
			});
			$('#msgModalProcessing').modal('hide');
			return;
		}

		var arrReservas = [];
		var cont = 0;

		//trae todas las reservas del fullcalendar 
		var reservasTodas = $('#calendar').fullCalendar('clientEvents');
		//console.log(JSON.stringify(reservasTodas));
		var puedeHacerReservas = true;

		var arrFestivos = getFestivos();

		//Si la reserva es sin repetición, no se debe repetir el while
		var repetir = true;
		while( (fini < fechahasta) && puedeHacerReservas && repetir){
			if(tipoRepetChecked == 'ninguna')
				repetir = false;

			if(cont!=0){
				fechainicio = moment(fechainicio).add(1, 'days');
				fechainicio = moment(fechainicio,'YYYY-MM-DD HH:mm').format('YYYY-MM-DD HH:mm');
				fechafinal = moment(fechafinal).add(1, 'days');
				fechafinal = moment(fechafinal,'YYYY-MM-DD HH:mm').format('YYYY-MM-DD HH:mm');
				fini = moment(fini).add(1, 'days');
			}
			cont++;
			fini = moment(fini,'YYYY-MM-DD HH:mm').format('YYYY-MM-DD');

			var diasemana =  moment(fechainicio, 'YYYY-MM-DD HH:mm').format('dddd');
			var msgError;
			//console.log(fini+' es festivo? ' + ($.inArray( fini , arrFestivos)>=0))
			//Si la fecha no está en arrFestivos y si el dia está seleccionado...
			if( 
				( $.inArray( fini , arrFestivos) < 0 ) && ( $.inArray(diasemana, diasSemSelected) >= 0 )
				){
				//Se adiciona la fecha al arreglo de reservas
				arrReservas.push({
					'RESE_TITULO': titulo,
					'RESE_FECHAINI': fechainicio,
					'RESE_FECHAFIN': fechafinal, 
					'RESE_TODOELDIA': todoeldia,
					'SALA_ID': sala,
					'RESE_PERIODO' : periodo,
			        'RESE_CODFRANJA' : franja,
			        'RESE_NOMFRANJA' : nomfranja,
			        'RESE_CODFACULTAD' : facultad,
			        'RESE_NOMFACULTAD' : nomfacultad,
			        'RESE_CODPROGRAMA' : programa,
			        'RESE_NOMPROGRAMA' : nomprograma,
			        'RESE_CODGRUPO' : grupo,
			        'RESE_NOMGRUPO' : nomgrupo,
			        'RESE_CODMATERIA' : materia,
			        'RESE_NOMMATERIA' : nommateria,
			        'RESE_DOCENTE' : docente
				});

				//Validaciones de cruce de fechas en reservas existentes
				//Si existen reservas previas, se debe validar que no tenga cruces
				if(reservasTodas.length > 0){
					for(k in reservasTodas){

						//objeto tipo date para almacenar el valor de la fecha inicial de la reserva del arreglo
						var fechairan = new Date();
						fechairan = moment(reservasTodas[k].start, 'YYYY-MM-DD HH:mm').format('YYYY-MM-DD HH:mm');

						//objeto tipo date para almacenar el valor de la fecha final de la reserva que esta en bd
						var ffinalran = new Date();
						ffinalran = moment(reservasTodas[k].end, 'YYYY-MM-DD HH:mm').format('YYYY-MM-DD HH:mm');

						//variable para almacenar el valor de la fecha de inicio formateada a YYYY-MM-DD de la
						//reserva que se pretende realizar
						var fecInicioValidaran = moment(fechainicio, 'YYYY-MM-DD HH:mm').format('YYYY-MM-DD');
 
						//objeto tipo date para almacenar el valor de la fecha inicial de la reserva que se pretende realizar
						var finicioreservaran = new Date();
						finicioreservaran = moment(reservasTodas[k].start, 'YYYY-MM-DD HH:mm').format('YYYY-MM-DD');

						//si la fecha de inicio de base de datos (formato YYYY-MM-DD) es igual a la fecha de inicio
						//de reserva que se pretende realizar, se validan las demas condiciones. Es decir que no va
						//revisar todas las reservas sino unicamente las reservas del día en que se pretende realizar
						//la nueva reserva
						if(fecInicioValidaran == finicioreservaran){
							puedeHacerReservas = validarReservaLibre(fechairan,ffinalran, fechainicio,fechafinal);
						}

						if(!puedeHacerReservas){
							msgError = 'Algunas se traslapan en el horario!';
							repetir = false;
							break;
						}
					}//For validar reservas existentes
				}
			} else {//If Festivos
				msgError = 'Es un festivo.';
			}
		}//aqui cierra el while

		console.log('puedeHacerReservas='+puedeHacerReservas);
		if(puedeHacerReservas && arrReservas.length>0){
			$.ajax({
				url: 'guardarReservas',
				data: {
					reservas : arrReservas,
				},
				//dataType: 'json',
				type: "POST",
				headers: {
					"X-CSRF-TOKEN": crsfToken
				},
				success: function(events) {
					$('#calendar').fullCalendar('refetchEvents');
					$.msgBox({
						title:"Éxito",
						content:"¡Su reserva se ha realizado satisfactoriamente!",
						type:"success"
					});

					$('#modalcrearres').modal('toggle');

					console.log("Events guardarReservas"+JSON.stringify(events));
				},
				error: function(json){
					$('#errorAjax').append(json.responseText);
					$.msgBox({
						title:"Error",
						content:"¡No se puede realizar la reserva!. Verifique los datos estén completos.",
						type:"error"
					});
					$('#msgModalProcessing').modal('hide');
				},
			});
		} else {
			$.msgBox({
				title:"Error",
				content:"¡No se puede realizar reservas. "+msgError,
				type:"error"
			});
			$('#msgModalProcessing').modal('hide');
		}
	};

/***** HELPERS - Funciones de apoyo *****/
	
	//Valida que una fecha de reserva nueva no se "traslape" con una reserva existente
	// Para mas información, visite el archivo reservas/testvalidacion.blade.php
	function validarReservaLibre(fIniExis, fFinExis, fIniNew, fFinNew){
		var esvalida = false;

		if(( (fIniNew >= fIniExis) &&
			  (fIniNew >= fFinExis) &&
			  (fFinNew >= fFinExis) 
			) || (
			  (fIniNew < fIniExis) &&
			  (fIniNew < fFinExis) &&
			  (fFinNew <= fIniExis)
				))
			esvalida = true;
		
		return esvalida;
	}
			
	//Obtener el valor de un parametro enviado por GET
	function getUrlParameter(sParam) {
		var sPageURL = decodeURIComponent(window.location.search.substring(1)),
		sURLVariables = sPageURL.split('&'),
		sParameterName,
		i;

		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : sParameterName[1];
			}
		}
	};

	//Obtener array de festivos por Ajax
	function getFestivos() {
		var arrFestivos = [];
		$.ajax({
			url: 'getFestivos',
			async: false,
			dataType: 'json',
			type: 'POST',
			headers: {
				"X-CSRF-TOKEN": crsfToken
			},
			success: function(festivos) {
				for(var i = 0; i < festivos.length; i++){
					var ffest = moment(festivos[i].FEST_FECHA, 'YYYY-MM-DD').format('YYYY-MM-DD');
					arrFestivos[i] = ffest;
				}
			},
			error: function(json){
				console.log("Error al consultar festivos");
				$('#errorAjax').append(json.responseText);
			}        
		});
		//console.log("Festivos:" + arrFestivos);
		return arrFestivos;
	}

	/* initialize the external events
	-----------------------------------------------------------------*/
	function ini_events(ele) {
		ele.each(function () {
			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
			var eventObject = {
				title: $.trim($(this).text()) // use the element's text as the event title
			};

			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);

			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 1070,
				revert: true, // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});
		});
	}

	ini_events($('#external-events div.external-event'));
	/* initialize the calendar
	-----------------------------------------------------------------*/
	//Date for the calendar events (dummy data)
	//while(reload==false){
	$('#calendar').fullCalendar({
		//theme: true,
		displayEventTime: false,
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,listMonth,agendaWeek,listWeek,agendaDay'
		},
		buttonText: {
			today: 'hoy',
			month: 'mes',
			listMonth: 'lista x mes',
			week: 'semana',
			listWeek: 'lista x semana',
			day: 'dia',
		},
		events: {
			url:"../cargaEventos" + sala
		},
		eventRender: function(event, element) { 
			var startt = moment(event.start).format('HH:mm');
			var endd = moment(event.end).format('HH:mm');
			element.find('.fc-title').append( startt + "-" + endd + " | Grupo: " + event.RESE_CODGRUPO + "");
		},
		eventAfterAllRender: function( view ) {
			$('#msgModalProcessing').modal('hide');
		},
		eventMouseover: function(calEvent, jsEvent) { 
			var tooltip = '<div class="tooltipevent" style="width:400px;height:150px;background:#f9ec54;position:absolute;z-index:10001;">'+
				"<b>Sede:</b>"+calEvent.SEDE_DESCRIPCION +" <br>"+
				"<b>Facultad:</b>"+calEvent.RESE_NOMFACULTAD +" <br>"+
				"<b>Programa:</b>"+calEvent.RESE_NOMPROGRAMA +" <br>"+
				"<b>Grupo:</b>"+calEvent.RESE_NOMGRUPO +" <br>"+
				"<b>Materia:</b>"+calEvent.RESE_NOMMATERIA +" <br>"+
				"<b>Franja:</b>"+ calEvent.RESE_NOMFRANJA +" <br>" +
				"<b>Estado:</b>"+ calEvent.ESTA_DESCRIPCION +" <br>" +
				'</div>'; var $tool = $(tooltip).appendTo('body');
		$(this).mouseover(function(e) {
		    $(this).css('z-index', 10000);
		            $tool.fadeIn('500');
		            $tool.fadeTo('10', 1.9);
		}).mousemove(function(e) {
		    $tool.css('top', e.pageY + 10);
		    $tool.css('left', e.pageX + 20);
		});
		},
		eventMouseout: function(calEvent, jsEvent) {
		$(this).css('z-index', 8);
		$('.tooltipevent').remove();
		},
		eventClick: function(calEvent, jsEvent, view) {
			//Visualizar Popup con los detalles de la reserva
			var start = moment(calEvent.start).format('YYYY-MM-DD HH:mm:ss');
			var end = moment(calEvent.end).format('YYYY-MM-DD HH:mm:ss');

			$('#divmodal').empty();
			$('#divmodal').append("<p><b>Sede: </b> "+calEvent.SEDE_DESCRIPCION+ "<b> Facultad: </b> "+calEvent.RESE_NOMFACULTAD +  "</p>");
			$('#divmodal').append("<p><b>Programa: </b> "+calEvent.RESE_NOMPROGRAMA+ "<b> Grupo: </b> "+calEvent.RESE_NOMGRUPO + "</p>");
			$('#divmodal').append("<p><b>Franja: </b> "+calEvent.RESE_NOMFRANJA+ "</p>");
			$('#divmodal').append("<p><b>Espacio/Sala: </b> "+calEvent.SALA_DESCRIPCION+ "</p>");
			$('#divmodal').append("<p><b>Fecha de Inicio: </b> " + start + "<b> Fecha Fin: </b> " + end +"</p>");
			$('#divmodal').append("<p><b>Estado:</b> " +calEvent.ESTA_DESCRIPCION+ "</p>");
			$('#divmodal').append("<p><b>Total reservas:</b> " +calEvent.count_reservas+ "</p>");
			$('#divmodal').append("<p><b>Creado por:</b> <span class='RESE_CREADOPOR'>" +calEvent.RESE_CREADOPOR+ "</span></p>");
			$('#divmodal').append("<p><b>Autorización:</b> <span class='AUTO_ID'>" +calEvent.AUTO_ID+ "</span></p>");
			$('#modalReserva').modal('show');
			// change the border color just for fun
			$(this).css('border-color', 'red');
			//console.log(calEvent);
		},
		editable: false,
		droppable: false, // this allows things to be dropped onto the calendar !!!
		drop: function (date, allDay) { // this function is called when something is dropped
			// retrieve the dropped element's stored Event Object
			var originalEventObject = $(this).data('eventObject');
			// we need to copy it, so that multiple events don't have a reference to the same object
			var copiedEventObject = $.extend({}, originalEventObject);
			allDay=false;
			// assign it the date that was reported
			copiedEventObject.start = date;
			copiedEventObject.end = date;
			copiedEventObject.allDay = allDay;
			copiedEventObject.backgroundColor = $(this).css("background-color");
			copiedEventObject.borderColor = $(this).css("border-color");

			// render the event on the calendar
			//$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
			// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
			// is the "remove after drop" checkbox checked?
			if ($('#drop-remove').is(':checked')) {
				// if so, remove the element from the "Draggable Events" list
				$(this).remove();
			}

			//Guardamos el evento creado en base de datos
			var title=copiedEventObject.title;
			var start=copiedEventObject.start.format("YYYY-MM-DD HH:mm");
			var end=copiedEventObject.end.format("YYYY-MM-DD HH:mm");
			var back=copiedEventObject.backgroundColor;

			var fechaInicioStr = $('#fechaInicio').data("DateTimePicker").date();
			var fechaIni = moment(fechaInicioStr).format("YYYY-MM-DD HH:mm:ss");

			var fechaFinStr = $('#fechaFin').data("DateTimePicker").date();
			var fechaFin = moment(fechaFinStr).format("YYYY-MM-DD HH:mm:ss");
		
			$.ajax({
				url: 'guardaEventos',
				data: 'title='+ title+'&start='+ fechaIni+'&allday='+allDay+'&background='+back+
				'&end='+fechaFin,
				type: "POST",
				headers: {
				"X-CSRF-TOKEN": crsfToken
				},
				success: function(events) {
					console.log('Evento creado');
					$('#calendar').fullCalendar('refetchEvents');
				},
				error: function(json){
					console.log("Error al crear evento");
					$('#errorAjax').append(json.responseText);
				}
			});
		}
	});

});
</script>