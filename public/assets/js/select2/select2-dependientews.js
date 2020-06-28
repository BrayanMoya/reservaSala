function fillDropDownAjax($selectPadre, $selectHijo, $url, $idBusqueda, $nombreBusqueda, $msgModel, $keyName, $keyValue, $auxValue, $auxValue2, $concatenado, $campoconcat){
	$(document).on('change','#'+$selectPadre,function(){

		$selectHijo.empty().prop('disabled', true);
		var opt='';
		var aux=$('#'+$auxValue).val();
		var aux2=$('#'+$auxValue2).val();
		var padre_id = $(this).val();
		if (padre_id !== null){//El select padre se encuentra sin datos seleccionados.
			$.ajax({
				type: 'get',
				url:  $url,
				data: { id : padre_id, 'aux' : aux, 'aux2' : aux2, },
				success: function(data){;

					if (data.length==0) {
						var msg = 'No se encontraron '+$msgModel;
						toastr['warning'](msg+' para la opción seleccionada.', 'Datos No Encontrados');
						$selectHijo.next().find('input').attr('placeholder',msg);
					} else {
						//opt += '<option value="0" selected disabled>'+placeholder+'</option>';
						if($keyName.length>0 && $keyValue.length>0){
							$.each(data, function( index, value ) {
								if($concatenado==0){
									opt += '<option value="'+data[index][$keyName]+'">'+data[index][$keyValue]+'</option>';
								}else{
									opt += '<option value="'+data[index][$keyName]+'">'+data[index][$keyValue]+ ' ' + $concatenado + ' ' + data[index][$campoconcat] + '</option>';
								}
								
							});
						}else{
							$.each(data, function( index, value ) {
								opt += '<option value="'+data[index]['codigo']+'">'+data[index]['nombre']+'</option>';
							});
						}

						
						$selectHijo.append(opt);
						$selectHijo.prop('disabled', false);
						$selectHijo.val([]).trigger('change');
					}
				},
				error: function( jqXHR, textStatus, errorThrown ){
					var msgErr;
					if (errorThrown === 'Unauthorized')
						msgErr = 'Sesión ha caducado. Presione F5 e inicie sesión.';
					else if (errorThrown === 'Forbidden')
						msgErr = 'Error en la conexión con el servidor. Presione F5.';
					else
						msgErr = 'No hay datos disponibles para las listas dependientes';

					toastr['error'](msgErr, 'Error');
				}
			});
		}
	});
}
