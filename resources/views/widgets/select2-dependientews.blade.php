@parent
@section('scripts')
	{!! Html::script('assets/js/select2/select2-dependientews.js') !!}
	<script type='text/javascript'>
		$(document).ready(function(){
			if( $('#{{$selectHijo}}').val() == '' || $('#{{$selectHijo}}').val() == null)
				$('#{{$selectHijo}}').prop('disabled', true);

			fillDropDownAjax(
				'{{$selectPadre}}',
				$('#{{$selectHijo}}'),
				'{!!URL::to($url)!!}',
				'{{isset($idBusqueda)?$idBusqueda:$selectHijo}}',
				'{{$nombreBusqueda}}',
				'{{isset($msgModel)?$msgModel:'datos'}}',
				'{{isset($keyName)?$keyName:''}}',
				'{{isset($keyValue)?$keyValue:''}}',
				'{{isset($auxValue)?$auxValue:''}}',
				'{{isset($auxValue2)?$auxValue2:''}}',
			)
		});
	</script>
@parent
@endsection