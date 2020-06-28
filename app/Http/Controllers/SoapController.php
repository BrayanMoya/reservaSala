<?php

namespace reservas\Http\Controllers;

use reservas\Http\Requests;
use Illuminate\Http\Request;

class SoapController extends Controller 
{

	/**
	* @var SoapWrapper
	*/
	public $wsdlreservas;
	public $wsdlautenticacion;

	/**
	* SoapController constructor.
	*
	* @param SoapWrapper $soapWrapper
	*/
	public function __construct()
	{
		$this->wsdlreservas 		= getGlobalParameter('WSDL_ACADEMUSOFT_RESERVAS', 'Error');
		$this->wsdlautenticacion 	= getGlobalParameter('WSDL_ACADEMUSOFT_AUTENTICACION', 'Error');
	}

	public function getFacultadesWs(){
		$xmlstring	= getGlobalParameter('XML_DATA_ACADEMUSOFT_FACULTADES', 'Error');
		$parameters = getGlobalParameterToArrayNormal('KEYS_VALUES_POSVAL_FACULTADES', '0');
		return $this->executeWsToArray($this->wsdlreservas, $xmlstring, $parameters[0], $parameters[1], $parameters[2], $parameters[3]);

	}

	public function getProgramasWs(){

		$facultad = request()->get('id');

		if(isset($facultad)){
			$xmlstring	= getGlobalParameter('XML_DATA_ACADEMUSOFT_PROGRAMAS', 'Error');
			$xmlstring  = str_replace("CODIGO_FACULTAD", $facultad, $xmlstring);
			$parameters = getGlobalParameterToArrayNormal('KEYS_VALUES_POSVAL_PROGRAMAS', '0');
			$arrData	= $this->executeWsToArray($this->wsdlreservas, $xmlstring, $parameters[0], $parameters[1], $parameters[2], $parameters[3], true);

			return response()->json($arrData);
		}
		
	}

	public function getFranjasWs(){
		$xmlstring	= getGlobalParameter('XML_DATA_ACADEMUSOFT_FRANJAS', 'Error');
		$parameters = getGlobalParameterToArrayNormal('KEYS_VALUES_POSVAL_FRANJAS', '0');
		return $this->executeWsToArray($this->wsdlreservas, $xmlstring, $parameters[0], $parameters[1], $parameters[2], $parameters[3]);

	}

	public function getGruposWs(){

		$programa = request()->get('id');
		$franja  = request()->get('aux');
		$periodo  = request()->get('aux2');

		if(isset($programa)){
			$xmlstring	= getGlobalParameter('XML_DATA_ACADEMUSOFT_GRUPOS', 'Error');
			$xmlstring  = str_replace("CODIGO_PROGRAMA", $programa, $xmlstring);
			$xmlstring  = str_replace("CODIGO_FRANJA", $franja, $xmlstring);
			$xmlstring  = str_replace("CODIGO_PERIODO", $periodo, $xmlstring);
			$parameters = getGlobalParameterToArrayNormal('KEYS_VALUES_POSVAL_GRUPOS', '0');
			$arrData	= $this->executeWsToArray($this->wsdlreservas, $xmlstring, $parameters[0], $parameters[1], $parameters[2], $parameters[3], true);

			return response()->json($arrData);
		}
		
	}

	public function getSemestresWs(){

		$grupo = request()->get('id');
		$periodo  = request()->get('aux');

		if(isset($grupo)){
			$xmlstring	= getGlobalParameter('XML_DATA_ACADEMUSOFT_MATERIAS', 'Error');
			$xmlstring  = str_replace("CODIGO_GRUPO", $grupo, $xmlstring);
			$xmlstring  = str_replace("CODIGO_PERIODO", $periodo, $xmlstring);
			$parameters = getGlobalParameterToArrayNormal('KEYS_VALUES_POSVAL_MATERIAS', '0');
			$arrData	= $this->executeWsToArray($this->wsdlreservas, $xmlstring, $parameters[0], $parameters[1], $parameters[2], $parameters[3], true);
			
			return response()->json($arrData);
		}
		
	}

	public function getMateriasWs(){

		$grupo = request()->get('id');
		$periodo  = request()->get('aux');

		if(isset($grupo)){
			$xmlstring	= getGlobalParameter('XML_DATA_ACADEMUSOFT_MATERIAS', 'Error');
			$xmlstring  = str_replace("CODIGO_GRUPO", $grupo, $xmlstring);
			$xmlstring  = str_replace("CODIGO_PERIODO", $periodo, $xmlstring);
			$parameters = getGlobalParameterToArrayNormal('KEYS_VALUES_POSVAL_MATERIAS', '0');
			$arrData	= $this->executeWsToArray($this->wsdlreservas, $xmlstring, $parameters[0], $parameters[1], $parameters[2], $parameters[3], true);

			return response()->json($arrData);
		}
		
	}

	public function getAutenticacionWs($user, $password){

			$xmlstring	= getGlobalParameter('XML_DATA_ACADEMUSOFT_AUTENTICACION', 'Error');
			$xmlstring  = str_replace("USER_ACADEMUSOFT", $user, $xmlstring);
			$xmlstring  = str_replace("PASSWORD_ACADEMUSOFT", $password, $xmlstring);
			$parameters = getGlobalParameterToArrayNormal('KEYS_VALUES_POSVAL_AUTENTICACION', '0');
			return $this->executeWsToArray($this->wsdlautenticacion, $xmlstring, $parameters[0], $parameters[1], $parameters[2], $parameters[3], true);

	}

	public function getValidacionUsuarionWs($user){

			$xmlstring	= getGlobalParameter('XML_DATA_ACADEMUSOFT_VALIDARUSUARIO', 'Error');
			$xmlstring  = str_replace("USER_ACADEMUSOFT", $user, $xmlstring);
			$parameters = getGlobalParameterToArrayNormal('KEYS_VALUES_POSVAL_VALIDARUSUARIO', '0');
			return $this->executeWsToArray($this->wsdlautenticacion, $xmlstring, $parameters[0], $parameters[1], $parameters[2], $parameters[3], true, true);
		
	}

	public function getRecuperarContrasenaWs($user){

			$xmlstring	= getGlobalParameter('XML_DATA_ACADEMUSOFT_RECOVERYPASSWORD', 'Error');
			$xmlstring  = str_replace("USER_ACADEMUSOFT", $user, $xmlstring);
			$parameters = getGlobalParameterToArrayNormal('KEYS_VALUES_POSVAL_RECOVERYPASSWORD', '0');
			return $this->executeWsToArray($this->wsdlautenticacion, $xmlstring, $parameters[0], $parameters[1], $parameters[2], $parameters[3], true, true);
		
	}

	public function getCambiarContrasenaWs($user, $passwordold, $passwordnew){

			$xmlstring	= getGlobalParameter('XML_DATA_ACADEMUSOFT_CAMBIARCONTRASENA', 'Error');
			$xmlstring  = str_replace("USER_ACADEMUSOFT", $user, $xmlstring);
			$xmlstring  = str_replace("PASSWORD_ACADEMUSOFT_OLD", $passwordold, $xmlstring);
			$xmlstring  = str_replace("PASSWORD_ACADEMUSOFT_NEW", $passwordnew, $xmlstring);
			$parameters = getGlobalParameterToArrayNormal('KEYS_VALUES_POSVAL_CAMBIARCONTRASENA', '0');
			return $this->executeWsToArray($this->wsdlautenticacion, $xmlstring, $parameters[0], $parameters[1], $parameters[2], $parameters[3], true);
		
	}

	public function executeWsToArray($wsdlurl, $xmlstring, $position, $value, $keyname, $keyvalue, $json=null, $onecolumn=false){

		try{

			$wsdl_url= $wsdlurl;
			$xmlData= $xmlstring;
			$ch = curl_init($wsdl_url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/soap+xml;charset=utf-8'));
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "$xmlData");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = utf8_encode(curl_exec($ch));
			$output = utf8_decode($output);
			curl_close($ch);

			$p = xml_parser_create();
			xml_parse_into_struct($p, $output, $vals, $index);
			xml_parser_free($p);

			$string = $vals[$position][$value];
			$data = preg_replace('/\\\"/',"\"", $string); 

			//si la respuesta solo contiene un valor de interes, se devuelve un arreglo con los datos obtenidos
			if($onecolumn)
				return array($string);
			
			$assocJson = json_decode($data, true);
			$assocArray = utf8_converter($assocJson);
			$arreglo = [];

			if(!$json){
				foreach ($assocArray as $value) {
				$arreglo[$value[$keyname]] = $value[$keyvalue];
				}

				return $arreglo;
			}
			
			return $assocJson;
			

		} catch(Exception $e){
			flash_alert( 'Error conectando a la base de datos de Academusoft ('.$e->getMessage().')', 'danger' );
			
		}

	}

	public function index()
	{

	}

}