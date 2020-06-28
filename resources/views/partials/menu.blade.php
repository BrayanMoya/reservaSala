<!-- Menú -->
<nav role="navigation" class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">

		<!-- Brand y toggle se agrupan para una mejor visualización en dispositivos móviles -->
		<div class="navbar-header">
			<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
				<span class="sr-only">Menú</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="{{ URL::to('home') }}" class="pull-left">
				<img src="{{ asset('assets/img/LOGO UNIAJC.png') }}" height="50" style="padding-top:5px; padding-left:5px; padding-bottom:5px;" alt="Sin imagen disponible">
			</a>
		</div>

		<!-- Recopila los vínculos de navegación, formularios y otros contenidos para cambiar -->
		<div id="navbarCollapse" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">

			@unless (Auth::guest())
				<li ><a href="{{ URL::to('home') }}"><em class="fa fa-home" aria-hidden="true"></em> Inicio</a></li>

            	@if (in_array(Auth::user()->rol->ROLE_ROL , ['audit','admin']))

            	<li class="dropdown">

						<ul class="nav navbar-nav">
							<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<em class="fa fa-check-square" aria-hidden="true"></em> Maestros del Sistema
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">

							<li><a href="{{ url('/tipoestados') }}"><em class="fa fa-bullseye"></em> Tipos de Estados</a></li>

							<li><a href="{{ url('/estados') }}"><em class="fa fa-circle"></em> Estados </a></li>

							<li>
								<a href="{{ url('/festivos') }}">
									<em class="fa fa-sun-o"></em> Festivos
								</a>
							</li>

						</ul>
					</li>
						</ul>
				</li>

            	<li class="dropdown">

						<ul class="nav navbar-nav">
							<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<em class="fa fa-sitemap" aria-hidden="true"></em> Gestión Administrativa
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">

							<li>
								<a href="{{ url('/sedes') }}">
									<em class="fa fa-building"></em> Sedes
								</a>
							</li>
							<li>
								<a href="{{ url('/salas') }}">
									<em class="fa fa-building-o"></em> Salas
								</a>
							</li>

							<li>
								<a href="{{ url('/equipos') }}">
									<em class="fa fa-desktop"></em> Equipos
								</a>
							</li>


							<li>
								<a href="{{ url('/recursos') }}">
									<em class="fa fa-gavel"></em> Recursos
								</a>
							</li>

						</ul>
					</li>
						</ul>
				</li>

				<li class="dropdown">

						<ul class="nav navbar-nav">
							<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<em class="fa fa-cogs" aria-hidden="true"></em> Admon. del Sistema
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">

							<li>
								<a href="{{ url('/usuarios') }}">
									<em class="fa fa-btn fa-users"></em> Usuarios Locales
								</a>
							</li>

							<li>
								<a href="{{ url('/parametrosgenerales') }}">
									<em class="fa fa-cog"></em> Parámetros Generales
								</a>
							</li>

						</ul>
					</li>
						</ul>
				</li>

				<!-- Menu de Reservas-->
				<li class="dropdown">
						<ul class="nav navbar-nav">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								<em class="fa fa-calendar" aria-hidden="true"></em> Reservas
									<span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="{{ url('home') }}"><em class="fa fa-calendar"></em> Reservar</a></li>
									<li><a href="{{ url('/autorizarReservas') }}"><em class="fa fa-calendar-check-o"></em> Autorizar</a></li>
								</ul>
							</li>
						</ul>
				</li>
				<!-- FIN Menu de Reservas-->

				<!-- Menu de Consultas-->
				<li class="dropdown">
						<ul class="nav navbar-nav">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								<em class="fa fa-search" aria-hidden="true"></em> Consultas
									<span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="{{ url('/consultaPrestamos') }}"><em class="fa fa-laptop"></em> Prestamos</a></li>

									<li><a href="{{ url('/consultaReservas') }}"><em class="fa fa-list-ol"></em> Listado de Reservas</a></li>

									<li><a href="{{ url('/consultaSalasDispo') }}"><em class="fa fa-check-square-o"></em> Salas Disponibles</a></li>

									<!--
									<li><a href="{{ url('/calreservas') }}"><em class="fa fa-calendar-o"></em> Calendario de Reservas</a></li>
									-->
								</ul>



							</li>
						</ul>
				</li>
				<!-- FIN Menu de Consultas-->

				@elseif (in_array(Auth::user()->rol->ROLE_ROL , ['user','estudiante','docente']))
					<li>
						<a href="{{ url('/consultaSalasDispo') }}">
							<em class="fa fa-check-square-o" aria-hidden="true"></em> Salas Disponibles
						</a>
					</li>
					<li>
						<a href="{{ url('/autorizarReservas') }}">
							<em class="fa fa-list" aria-hidden="true"></em> Mis Reservas
						</a>
					</li>
				@endif
			@endunless
			</ul>

			<!-- Lado derecho del Navbar. -->
			<ul class="nav navbar-nav navbar-right">
				<!-- Ayuda -->
					<li><a href="{{ url('/help') }}">
						<em class="fa fa-life-ring" aria-hidden="true"></em> Ayuda
					</a></li>
				<!-- Autenticación. -->
				@if (Auth::guest())
					<li><a href="{{ url('/login') }}">
						<em class="fa fa-sign-in" aria-hidden="true"></em> Login
					</a></li>
				@else
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<em class="fa fa-user" aria-hidden="true"></em>   @if(session('useracademusoft'))
                                {{ session('useracademusoft') }}
                                - {{ session('primernombreacademusoft') . ' ' . session('primerapellidoacademusoft') }}
                            @else
                                {{ Auth::user()->username }}
                                {{ Auth::user()->rol->ROLE_ROL }}
                            @endif
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a href="{{ url('/password/reset') }}">
									<em class="fa fa-btn fa-key"></em> Cambiar contraseña
								</a>
							</li>

							<li>
								<a href="{{ url('/logout') }}">
									<em class="fa fa-btn fa-sign-out"></em> Logout
								</a>
							</li>
						</ul>
					</li>
				@endif
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<!-- Fin Menú -->
