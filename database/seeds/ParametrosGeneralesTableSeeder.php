<?php

use Illuminate\Database\Seeder;
use reservas\ParametroGeneral;

class ParametrosGeneralesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->command->info('---Seeder ParametrosGenerales');

       	$parametrogeneral = new ParametroGeneral;
	    $parametrogeneral->PAGE_DESCRIPCION = 'FRANJA_INICIAL_DISPONIBILIDAD';
	    $parametrogeneral->PAGE_VALOR = '08:00:00';
	    $parametrogeneral->PAGE_OBSERVACIONES = 'HORA INICIAL EN LA CUAL SE ENCUENTRA CON DISPONIBILIDAD UNA SALA';
	    $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
	    $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'FRANJA_FINAL_DISPONIBILIDAD';
        $parametrogeneral->PAGE_VALOR = '21:30:00';
        $parametrogeneral->PAGE_OBSERVACIONES = 'HORA FINAL EN LA CUAL SE ENCUENTRA CON DISPONIBILIDAD UNA SALA';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'FRANJA_ENTRE_HORARIOS';
        $parametrogeneral->PAGE_VALOR = '30';
        $parametrogeneral->PAGE_OBSERVACIONES = 'CANTIDAD DE MINUTOS PARA FIJAR LA SEPARACIÓN ENTRE FRANJAS Y CONSIDERAR COMO PERIODO DE AGENDAMIENTO';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'PERIODO_ACADEMICO';
        $parametrogeneral->PAGE_VALOR = '2019-02';
        $parametrogeneral->PAGE_OBSERVACIONES = 'DEFINCIÓN DEL PERIODO ACÁDEMICO ACTIVO EN LA INSTITUCIÓN';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'USER_WS_UNIAJC_RESERVAS';
        $parametrogeneral->PAGE_VALOR = 'RESERVAS_SALAS';
        $parametrogeneral->PAGE_OBSERVACIONES = 'NOMBRE DE USUARIO EMPLEADO PARA AUTENTICARSE EN EL WEBSERVICE OFERTADO POR EL ERP DE LA UNIVERSIDAD';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'PASSWORD_WS_UNIAJC_RESERVAS';
        $parametrogeneral->PAGE_VALOR = 'SmartCampus2019*';
        $parametrogeneral->PAGE_OBSERVACIONES = 'CONTRASEÑA DE USUARIO PARA AUTENTICARSE EN EL WEBSERVICE OFERTADO POR EL ERP DE LA UNIVERSIDAD';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'WSDL_ACADEMUSOFT_RESERVAS';
        $parametrogeneral->PAGE_VALOR = 'http://smartdev.uniajc.edu.co:8888/wse_facultad_v1-0.0.1/ws/facultad.wsdl';
        $parametrogeneral->PAGE_OBSERVACIONES = 'WSDL DEFINIDO PARA LA INTEGRACIÓN CON ACADEMUSOFT POR MEDIO DE SOAP';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'XML_DATA_ACADEMUSOFT_FACULTADES';
        $parametrogeneral->PAGE_VALOR = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:web="http://uniajc.edu.co/facultad/web-service"><soap:Header><wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
        <wsse:UsernameToken wsu:Id="UsernameToken-A2E995896AEE7431C0155321199835425"> <wsse:Username>RESERVAS_SALAS</wsse:Username>
        <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">SmartCampus2019*</wsse:Password>
        </wsse:UsernameToken> </wsse:Security> </soap:Header> <soap:Body> <web:GetAllFacultadesRequest/> </soap:Body> </soap:Envelope>';
        $parametrogeneral->PAGE_OBSERVACIONES = 'XML DATA DEFINIDO PARA LA INTEGRACIÓN CON ACADEMUSOFT DE ACADEMUSOFT';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'KEYS_VALUES_POSVAL_FACULTADES';
        $parametrogeneral->PAGE_VALOR = '6, value, codigo, nombre';
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE DEFINE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA CLAVE DADA PARA EL ARREGLO DE RETORNO, VALOR DE LA CALVE DADA PARA EL RETORNO DEL ARREGLO';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'XML_DATA_ACADEMUSOFT_PROGRAMAS';
        $parametrogeneral->PAGE_VALOR = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:web="http://uniajc.edu.co/facultad/web-service">
           <soap:Header><wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                 xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                <wsse:UsernameToken wsu:Id="UsernameToken-A2E995896AEE7431C0155321199835425">
                <wsse:Username>RESERVAS_SALAS</wsse:Username>
                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">SmartCampus2019*</wsse:Password>
                </wsse:UsernameToken>
                </wsse:Security>
           </soap:Header>
           <soap:Body>
              <web:GetCarrerasRequest>
                 <web:codigoFacultad>CODIGO_FACULTAD</web:codigoFacultad>
              </web:GetCarrerasRequest>
           </soap:Body>
        </soap:Envelope>';
        $parametrogeneral->PAGE_OBSERVACIONES = 'XML DATA DEFINIDO PARA TRAER LOS PROGRAMAS DE UNA FACULTAD EN ESPECIFICO';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'KEYS_VALUES_POSVAL_PROGRAMAS';
        $parametrogeneral->PAGE_VALOR = '6, value, codigo, nombre';
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE DEFINE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA CLAVE DADA PARA EL ARREGLO DE RETORNO, VALOR DE LA CALVE DADA PARA EL RETORNO DEL ARREGLO';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'XML_DATA_ACADEMUSOFT_GRUPOS';
                $parametrogeneral->PAGE_VALOR = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:web="http://uniajc.edu.co/facultad/web-service">
           <soap:Header><wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                 xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                <wsse:UsernameToken wsu:Id="UsernameToken-A2E995896AEE7431C0155321199835425">
                <wsse:Username>RESERVAS_SALAS</wsse:Username>
                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">SmartCampus2019*</wsse:Password>
                </wsse:UsernameToken>
                </wsse:Security>
           </soap:Header>
           <soap:Body>
              <web:GetGruposMateriasFranjProgRequest>
                 <web:periodo>CODIGO_PERIODO</web:periodo>
                 <web:codigoprograma>CODIGO_PROGRAMA</web:codigoprograma>
                 <web:franja>CODIGO_FRANJA</web:franja>
              </web:GetGruposMateriasFranjProgRequest>
           </soap:Body>
        </soap:Envelope>';
        $parametrogeneral->PAGE_OBSERVACIONES = 'XML DATA DEFINIDO PARA TRAER LOS GRUPOS DE UN PROGRAMA EN ESPECIFICO';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'KEYS_VALUES_POSVAL_GRUPOS';
        $parametrogeneral->PAGE_VALOR = '6, value, codGrupo, grupo';
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE DEFINE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA CLAVE DADA PARA EL ARREGLO DE RETORNO, VALOR DE LA CALVE DADA PARA EL RETORNO DEL ARREGLO';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'XML_DATA_ACADEMUSOFT_MATERIAS';
        $parametrogeneral->PAGE_VALOR = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:web="http://uniajc.edu.co/facultad/web-service">
           <soap:Header><wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                 xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                <wsse:UsernameToken wsu:Id="UsernameToken-A2E995896AEE7431C0155321199835425">
                <wsse:Username>RESERVAS_SALAS</wsse:Username>
                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">SmartCampus2019*</wsse:Password>
                </wsse:UsernameToken>
                </wsse:Security>
           </soap:Header>
           <soap:Body>
              <web:GetMateriasxGrupoRequest>
                 <web:periodo>CODIGO_PERIODO</web:periodo>
                 <web:grupo>CODIGO_GRUPO</web:grupo>
              </web:GetMateriasxGrupoRequest>
           </soap:Body>
        </soap:Envelope>';
        $parametrogeneral->PAGE_OBSERVACIONES = 'XML DATA DEFINIDO PARA TRAER LAS MATERIAS DE UN GRUPO EN ESPECIFICO';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'KEYS_VALUES_POSVAL_MATERIAS';
        $parametrogeneral->PAGE_VALOR = '6, value, codMateria, nombreMateria';
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE DEFINE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA CLAVE DADA PARA EL ARREGLO DE RETORNO, VALOR DE LA CALVE DADA PARA EL RETORNO DEL ARREGLO';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'XML_DATA_ACADEMUSOFT_FRANJAS';
                $parametrogeneral->PAGE_VALOR = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:web="http://uniajc.edu.co/facultad/web-service">
          <soap:Header><wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                 xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                <wsse:UsernameToken wsu:Id="UsernameToken-A2E995896AEE7431C0155321199835425">
                <wsse:Username>RESERVAS_SALAS</wsse:Username>
                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">SmartCampus2019*</wsse:Password>
                </wsse:UsernameToken>
                </wsse:Security>
           </soap:Header>
           <soap:Body>
              <web:GetFranjasRequest/>
           </soap:Body>
        </soap:Envelope>';
        $parametrogeneral->PAGE_OBSERVACIONES = 'XML DATA DEFINIDO PARA TRAER LAS FRANJAS HORARIAS EXISTENTES';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'KEYS_VALUES_POSVAL_FRANJAS';
        $parametrogeneral->PAGE_VALOR = '6, value, codigo, nombre';
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE DEFINE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA CLAVE DADA PARA EL ARREGLO DE RETORNO, VALOR DE LA CALVE DADA PARA EL RETORNO DEL ARREGLO';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'ROLES_OPERATIVOS_ACADEMUSOFT';
        $parametrogeneral->PAGE_VALOR = 'DOCENTE';
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE DEFINE LOS ROLES DIFERENTES DE ADMINISTRADOR, QUE PUEDEN INGRESAR AL SOFTWARE DE RESERVAS PARA REALIZAR TRANSACCIONES SOBRE LOS SERVICIOS OFERTADOS';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'ROLES_ADMINISTRADORES_ACADEMUSOFT';
        $parametrogeneral->PAGE_VALOR = 'ADMIN_ACADEMICO';
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE DEFINE LOS ROLES DE ADMINISTRADOR, QUE PUEDEN INGRESAR AL SOFTWARE DE RESERVAS PARA REALIZAR TODA LA GESTIÓN Y ADMINISTRACIÓN SOBRE LOS SERVICIOS OFERTADOS';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'ROLES_ESTUDIANTES_ACADEMUSOFT';
        $parametrogeneral->PAGE_VALOR = 'ESTUDIANTE';
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE DEFINE LOS ROLES DE ESTUDIANTES, QUE EN ALGUN MOMENTO PUEDEN INGRESAR AL SOFTWARE DE RESERVAS PARA HACER USO DE LOS SERVICIOS OFERTADOS POR EL SISTEMA';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'ID_USUARIO_ADMINISTRADOR';
        $parametrogeneral->PAGE_VALOR = '1';
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE INDICA EL ID DEL USUARIO CON EL QUE SERÁ LOGUEADO UN ADMINISTRADOR';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'ID_USUARIO_OPERATIVO';
        $parametrogeneral->PAGE_VALOR = '3';
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE INDICA EL ID DEL USUARIO CON EL QUE SERÁ LOGUEADO UN USUARIO DIFERENTE DE ADMINISTRADOR';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'ID_USUARIO_ESTUDIANTE';
        $parametrogeneral->PAGE_VALOR = '4';
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE INDICA EL ID DEL USUARIO CON EL QUE SERÁ LOGUEADO UN ESTUDIANTE';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'ESTADOS_USERSACADEMUSOFT_VALIDOS';
        $parametrogeneral->PAGE_VALOR = 'Usuario Activo';
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE INDICA LOS ESTADOS DE USUARIOS DISPONIBLES PARA ACCEDER AL SISTEMA DE RESERVAS, ESTOS SON RETORNADOS POR ACADEMUSOFT';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'MENSAJE_USUARIO_INACTIVO_SMARTCAMPUS';
        $parametrogeneral->PAGE_VALOR = 'El usuario no esta activo en Smart Campus';
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE DEFINE EL MENSAJE DE RETORNO DESDE EL ACADEMUSOFT PARA DETERMINAR SI UN USUARIO NO SE ENCUENTRA ACTIVO';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'MENSAJE_RECOVERYPASSWORD_CONFIRMACION';
        $parametrogeneral->PAGE_VALOR = 'La contraseña ha sido restaurada al(os) correo(s) que el usuario tiene configurado en el sistema !!!';
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE DEFINE EL MENSAJE DE RETORNO DESDE EL ACADEMUSOFT PARA CONFIRMAR LA RESTAURACIÓN DE CONTRASEÑA QUE SE ENVÍA AL EMAIL';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'MENSAJE_CHANGEPASSWORD_CONFIRMACION';
        $parametrogeneral->PAGE_VALOR = 'La clave se actualizo correctamente';
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE DEFINE EL MENSAJE DE RETORNO DESDE EL ACADEMUSOFT PARA CONFIRMAR EL CAMBIO DE CONTRASEÑA';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();


        //=======================================================================================

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'WSDL_ACADEMUSOFT_AUTENTICACION';
        $parametrogeneral->PAGE_VALOR = 'http://smartdev.uniajc.edu.co:8888/WSULogin-0.0.1-SNAPSHOT/ws/login.wsdl';
        $parametrogeneral->PAGE_OBSERVACIONES = 'WSDL DEFINIDO PARA LA INTEGRACIÓN CON ACADEMUSOFT POR MEDIO DE SOAP PARA LA AUTENTICACIÓN';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'XML_DATA_ACADEMUSOFT_AUTENTICACION';
        $parametrogeneral->PAGE_VALOR = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:wsul="http://smartcampus.uniajc.edu.co/service/WSULogin">
            <soap:Header>
                <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                    <wsse:UsernameToken wsu:Id="UsernameToken-A2E995896AEE7431C0155321199835425">
                        <wsse:Username>RESERVAS_SALAS</wsse:Username>
                        <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">SmartCampus2019*</wsse:Password>
                    </wsse:UsernameToken>
                </wsse:Security>
            </soap:Header>
            <soap:Body>
                <wsul:AuthenticateUserRequest>
                    <wsul:user>USER_ACADEMUSOFT</wsul:user>
                    <wsul:password>PASSWORD_ACADEMUSOFT</wsul:password>
                </wsul:AuthenticateUserRequest>
            </soap:Body>
        </soap:Envelope>';
        $parametrogeneral->PAGE_OBSERVACIONES = 'XML DATA DEFINIDO PARA LA INTEGRACIÓN CON ACADEMUSOFT DE ACADEMUSOFT EN LA PARTE DE AUTENTICACIÓN';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'KEYS_VALUES_POSVAL_AUTENTICACION';
        $parametrogeneral->PAGE_VALOR = '6, value, login, nombre';
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE DEFINE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA CLAVE DADA PARA EL ARREGLO DE RETORNO, VALOR DE LA CALVE DADA PARA EL RETORNO DEL ARREGLO PARA EL WS DE AUTENTICACIÓN';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'XML_DATA_ACADEMUSOFT_VALIDARUSUARIO';
                $parametrogeneral->PAGE_VALOR = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:wsul="http://smartcampus.uniajc.edu.co/service/WSULogin">
           <soap:Header>
                        <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                            <wsse:UsernameToken wsu:Id="UsernameToken-A2E995896AEE7431C0155321199835425">
                                <wsse:Username>RESERVAS_SALAS</wsse:Username>
                                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">SmartCampus2019*</wsse:Password>
                            </wsse:UsernameToken>
                        </wsse:Security>
                    </soap:Header>
           <soap:Body>
              <wsul:ValidateUserRequest>
                 <wsul:usuario>USER_ACADEMUSOFT</wsul:usuario>
              </wsul:ValidateUserRequest>
           </soap:Body>
        </soap:Envelope>';
        $parametrogeneral->PAGE_OBSERVACIONES = 'XML DATA DEFINIDO PARA VALIDAR EL ESTADO DEL USUARIO DE ACADEMUSOFT, ESTE DEVUELVE COMO RESPUESTA ACTIVO O INACTIVO';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'KEYS_VALUES_POSVAL_VALIDARUSUARIO';
        $parametrogeneral->PAGE_VALOR = '6, value, noaplica, noaplica';;
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE DEFINE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA CLAVE DADA PARA EL ARREGLO DE RETORNO, VALOR DE LA CALVE DADA PARA EL RETORNO DEL ARREGLO';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'XML_DATA_ACADEMUSOFT_RECOVERYPASSWORD';
        $parametrogeneral->PAGE_VALOR = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:wsul="http://smartcampus.uniajc.edu.co/service/WSULogin">
           <soap:Header>
                <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                    <wsse:UsernameToken wsu:Id="UsernameToken-A2E995896AEE7431C0155321199835425">
                        <wsse:Username>RESERVAS_SALAS</wsse:Username>
                        <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">SmartCampus2019*</wsse:Password>
                    </wsse:UsernameToken>
                </wsse:Security>
            </soap:Header>
           <soap:Body>
              <wsul:RecoveryAccessRequest>
                 <wsul:usuario>USER_ACADEMUSOFT</wsul:usuario>
              </wsul:RecoveryAccessRequest>
           </soap:Body>
        </soap:Envelope>';
        $parametrogeneral->PAGE_OBSERVACIONES = 'XML DATA DEFINIDO PARA RECUPERAR LA CONTRASEÑA DE SMARTCAMPUS';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'KEYS_VALUES_POSVAL_RECOVERYPASSWORD';
        $parametrogeneral->PAGE_VALOR = '6, value, noaplica, noaplica';;
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE DEFINE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA CLAVE DADA PARA EL ARREGLO DE RETORNO, VALOR DE LA CALVE DADA PARA EL RETORNO DEL ARREGLO';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'XML_DATA_ACADEMUSOFT_CAMBIARCONTRASENA';
        $parametrogeneral->PAGE_VALOR = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:wsul="http://smartcampus.uniajc.edu.co/service/WSULogin">
           <soap:Header>
                <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                    <wsse:UsernameToken wsu:Id="UsernameToken-A2E995896AEE7431C0155321199835425">
                        <wsse:Username>RESERVAS_SALAS</wsse:Username>
                        <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">SmartCampus2019*</wsse:Password>
                    </wsse:UsernameToken>
                </wsse:Security>
            </soap:Header>
           <soap:Body>
              <wsul:ChangePasswordRequest>
                 <wsul:usuario>USER_ACADEMUSOFT</wsul:usuario>
                 <wsul:nuevaClave>PASSWORD_ACADEMUSOFT_OLD</wsul:nuevaClave>
                 <wsul:claveAnterior>PASSWORD_ACADEMUSOFT_NEW</wsul:claveAnterior>
              </wsul:ChangePasswordRequest>
           </soap:Body>
        </soap:Envelope>';
        $parametrogeneral->PAGE_OBSERVACIONES = 'XML DATA DEFINIDO PARA EL CAMBIO DE CONTRASEÑA EN EL SISTEMA ACADEMUSOFT. A ESTE SE LE PASA EL USUARIO, LA CONTRASEÑA VIEJA Y LA CONTRASEÑA NUEVA';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

        $parametrogeneral = new ParametroGeneral;
        $parametrogeneral->PAGE_DESCRIPCION = 'KEYS_VALUES_POSVAL_CAMBIARCONTRASENA';
        $parametrogeneral->PAGE_VALOR = '6, value, noaplica, noaplica';;
        $parametrogeneral->PAGE_OBSERVACIONES = 'PARAMETRO QUE DEFINE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA POSICIÓN DE RETORNO DEL XMLDATA, NOMBRE DE LA CLAVE DADA PARA EL ARREGLO DE RETORNO, VALOR DE LA CALVE DADA PARA EL RETORNO DEL ARREGLO';
        $parametrogeneral->PAGE_CREADOPOR = 'SYSTEM';
        $parametrogeneral->save();

    }
}
