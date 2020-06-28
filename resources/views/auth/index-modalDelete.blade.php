<!-- Mensaje Modal para confirmar borrado de registro-->
<div class="modal fade" id="pregModalDelete" role="dialog" tabindex="-1" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">¿Borrar registro <span class="USER_ID"></span>?</h4>
			</div>

			<div class="modal-body">
				<p>
					<em class="fa fa-exclamation-triangle"></em> ¿Desea borrar el usuario <span class="username"></span>?
				</p>
			</div>

			<div class="modal-footer">
				<form id="frmDeleteUser" method="POST" action="" accept-charset="UTF-8" class="frmModal pull-right">

					<button type="button" class="btn btn-xs btn-default" data-dismiss="modal">
						<em class="fa fa-times" aria-hidden="true"></em> NO
					</button>

					{{ Form::token() }}
					{{ Form::hidden('_method', 'DELETE') }}
					{{ Form::button('<em class="fa fa-trash" aria-hidden="true"></em> SI ',[
						'class'=>'btn btn-xs btn-danger',
						'type'=>'submit',
						'data-toggle'=>'modal',
						'data-backdrop'=>'static',
						'data-target'=>'#msgModalDeleting',
					]) }}
				</form>
			</div>
		</div>
	</div>
</div><!-- Fin de Mensaje Modal confirmar borrado de registro.-->


<!-- Mensaje Modal al borrar registro. Bloquea la pantalla mientras se procesa la solicitud -->
<div class="modal fade" id="msgModalDeleting" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body">
				<h4>
					<em class="fa fa-cog fa-spin fa-3x fa-fw" style="vertical-align: middle;"></em> Borrando usuario...
				</h4>
			</div>
		</div>

	</div>
</div><!-- Fin de Mensaje Modal al borrar registro.-->