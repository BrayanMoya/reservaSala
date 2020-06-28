<div class="panel panel-{{{ isset($class) ? $class : 'default' }}}">
	@if( isset($header) )  
		<div class="panel-heading">
			<h3 class="panel-title">@yield ($as . '_panel_title')
				@if( isset($controls) )  
				<div class="panel-control pull-right">
					<a class="panelButton"><em class="fas fa-refresh"></em></a>
					<a class="panelButton"><em class="fas fa-minus"></em></a>
					<a class="panelButton"><em class="fas fa-remove"></em></a>
				</div>
				@endif
			</h3>
		</div>
	@endif
	
	<div class="panel-body">
		@yield ($as . '_panel_body')
	</div>
	@if( isset($footer))
		<div class="panel-footer">@yield ($as . '_panel_footer')</div>
	@endif
</div>

