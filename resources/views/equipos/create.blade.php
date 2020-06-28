@extends('layout')
@include('select2')
@section('title', '/ Crear Equipo')
@section('scripts')
    
     <script>

      $(function () {


      	/*para posicionar un combobox lo unico que hay que hacer es que el selector (select) tenga
      	un id y referirce a el de la forma en que esta abajo de este comentario. Entonces le decimos
      	que el select con id ESTA_ID se seleccione la opción que trae el campo ESTA_ID en el registro
      	de equipo

      	

      	*/	

	 	$( "#SEDE_ID" ).change(function() {
		  	
 		var opcion = $("#SEDE_ID").val();
	 		crsfToken = document.getElementsByName("_token")[0].value;

			$.ajax({
	             url: '../consultaSalas',
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
	           }        
        	});


		});

	  });

	  function habilitar(id) {
	  	//alert(id);
    if (id != "") {    
			document.getElementById("SALA_ID").disabled=false;
       
    }else {
    	//$("#SALA_ID").append('<option value="">Seleccione una sede..</option>');
    		//document.getElementById("SALA_ID").value="Seleccione una sede..";

    		document.getElementById("SALA_ID").disabled=true;    		
    	}
	}
    </script>
@parent
@endsection
@section('content')

	<h1 class="page-header">Nuevo Equipo</h1>

	@include('partials/errors')
	
		{{ Form::open(array('url' => 'equipos', 'class' => 'form-vertical')) }}

	  	<div class="form-group">
			{{ Form::label('EQUI_DESCRIPCION', 'Descripción') }} 
			{{ Form::text('EQUI_DESCRIPCION', old('EQUI_DESCRIPCION'), array('class' => 'form-control', 'max' => '300', 'required')) }}
		</div>

		<div class="form-group">
			{{ Form::label('EQUI_OBSERVACIONES', 'Observaciones') }} 
			{{ Form::textarea('EQUI_OBSERVACIONES', old('EQUI_OBSERVACIONES'), array('class' => 'form-control', 'max' => '300', 'required')) }}
		</div>

		<div class="form-group">
			@include('widgets.forms.input', ['type'=>'select', 'column'=>3, 'name'=>'SEDE_ID', 'label'=>'Sede', 'data'=>$arrSedes])
		</div>

		<div class="form-group">
			@include('widgets.forms.input', ['type'=>'select', 'column'=>3, 'name'=>'SALA_ID', 'label'=>'Sala', 'data'=>$arrSalas, 'options'=>['required']])
		</div>

		<div class="form-group">
			@include('widgets.forms.input', ['type'=>'select', 'column'=>2, 'name'=>'ESTA_ID', 'label'=>'Estado', 'data'=>$arrEstados, 'options'=>['required']])
		</div>

		<br><br><br><br>
		<!-- Botones -->
		<div class="text-right">
			{{ Form::button('<i class="fa fa-exclamation" aria-hidden="true"></i> Reset', array('class'=>'btn btn-warning', 'type'=>'reset')) }}
			<a class="btn btn-warning" role="button" href="{{ URL::to('equipos') }}">
				<i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
			</a>
			{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', array('class'=>'btn btn-primary', 'type'=>'submit')) }}
		</div>

		
		{{ Form::close() }}
@endsection
