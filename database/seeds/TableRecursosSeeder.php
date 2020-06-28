<?php

use Illuminate\Database\Seeder;

class TableRecursosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->command->info('--- Creación de Recursos de prueba');


//Sistemas Operativos



$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'WINDOWS 10';
$recurso->RECU_VERSION =  '10 64 Bits';
$recurso->RECU_OBSERVACIONES =  'SO WINDOWS 10 64 BITS ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,2,3,8,13,14,15,16,18,20,21,22,23], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'WINDOWS 7';
$recurso->RECU_VERSION =  '7 64 Bits';
$recurso->RECU_OBSERVACIONES =  'SO WINDOWS 7 64 BITS ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([6,7,9,11,12,24,25], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'LINUX';
$recurso->RECU_VERSION =  'MINT';
$recurso->RECU_OBSERVACIONES =  'SO LINUX 64 BITS ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([7], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'MAC SIERRA';
$recurso->RECU_VERSION =  'HIGH SIERRA';
$recurso->RECU_OBSERVACIONES =  'SO MAC HIGH SIERRA ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([10,19], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'MAC MOJAVE';
$recurso->RECU_VERSION =  '10.14.5';
$recurso->RECU_OBSERVACIONES =  'SO macOS Mojave version 10.14.5 ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([26], false);


       //SALA 301 - Sede CENTRAL

       $recurso = new \reservas\Recurso;
       $recurso->RECU_DESCRIPCION = 'SOLIDWORK';
       $recurso->RECU_VERSION =  '1';
       $recurso->RECU_OBSERVACIONES =  'SOLIDWORK';
       $recurso->RECU_CREADOPOR =  'USER_PRUEBA';
       $recurso->save();
       $recurso->salas()->sync([1,12], false);

       $recurso = new \reservas\Recurso;
       $recurso->RECU_DESCRIPCION = 'PLUS 80W';
       $recurso->RECU_VERSION =  '1';
       $recurso->RECU_OBSERVACIONES =  'PLUS 80W';
       $recurso->RECU_CREADOPOR =  'USER_PRUEBA';
       $recurso->save();
       $recurso->salas()->sync([1], false);

      $recurso = new \reservas\Recurso;
      $recurso->RECU_DESCRIPCION = 'UNITY';
      $recurso->RECU_VERSION =  '1';
      $recurso->RECU_OBSERVACIONES =  'UNITY';
      $recurso->RECU_CREADOPOR =  'USER_PRUEBA';
      $recurso->save();
      $recurso->salas()->sync([1], false);

    $recurso = new \reservas\Recurso;
    $recurso->RECU_DESCRIPCION = 'ANDROID SDK';
    $recurso->RECU_VERSION =  '1';
    $recurso->RECU_OBSERVACIONES =  'ANDROID SDK';
    $recurso->RECU_CREADOPOR =  'USER_PRUEBA';
    $recurso->save();
    $recurso->salas()->sync([1], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'SOAPVI';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'SOAPVI';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'SQL SERVER 2008 ';
$recurso->RECU_VERSION =  '2008';
$recurso->RECU_OBSERVACIONES =  'SQL SERVER 2008 ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'SQL SERVER 2019 ';
$recurso->RECU_VERSION =  '2019';
$recurso->RECU_OBSERVACIONES =  'SQL SERVER 2019 ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'VISUAL STUDIO 2005';
$recurso->RECU_VERSION =  '2005';
$recurso->RECU_OBSERVACIONES =  'VISUAL STUDIO 2005';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'VISUAL STUDIO 2019';
$recurso->RECU_VERSION =  '2019';
$recurso->RECU_OBSERVACIONES =  'VISUAL STUDIO 2019';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'CGUNO';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'CGUNO';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'NOTEPAD ++';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'NOTEPAD ++';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,20,21,22,23], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'CISCO PACKET TRACER';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'CISCO PACKET TRACER';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,2,8,12,3,11,9,6,16,22,24], false);


$recurso->salas()->sync([1], false);
$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'VUIRTUAL BOX';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'VUIRTUAL BOX';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,2], false);



//RECURSOS SALAS 2 DE LA SEDE CENTRAL
$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'GLASSFFISH';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'SERVIDOR DE APLICACIONES GLASSFFISH';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([2,12], false);


$recurso->salas()->sync([1], false);
$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'ORACLE';
$recurso->RECU_VERSION =  '11.580';
$recurso->RECU_OBSERVACIONES =  'DB 11580. EXPRESS';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([2,7,12,14,19,20,21,22], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'MYSQL WORKBENCH';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'MYSQL WORKBENCH';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([2], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'NETBEANS';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'NETBEANS';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([2,3,6,11,8,9,10,12,13,14,15,19,20,26], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'START UML';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'START UML';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,2,8], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'SUBLIME TEXT';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'SUBLIME TEXT';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([2,6,8,14,15,19], false);


//RECURSOS SALAS 3 DE LA SEDE CENTRAL
$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' BRACKET.IO';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  ' BRACKET.IO';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([3], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'VISUAL STUDIO CODE';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'VISUAL STUDIO CODE';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([3,6,13,14,19], false);


//RECURSOS SALAS 6 DE LA SEDE CENTRAL

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'MENDELEY';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'MENDELEY';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([6], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'VISUAL STUDIO 2013';
$recurso->RECU_VERSION =  '2013';
$recurso->RECU_OBSERVACIONES =  'VISUAL STUDIO 2013';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([6], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'ANACONDA';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'ANACONDA';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([6], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'CABRI';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'CABRI';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([6], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'GIT';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'GIT';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([6,20,21], false);



//RECURSOS SALAS 7 DE LA SEDE CENTRAL

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'PROTEUS';
$recurso->RECU_VERSION =  '8';
$recurso->RECU_OBSERVACIONES =  'PROTEUS';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([7,25], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'POSTGIS';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'POSTGIS';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([7], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' PINGÜINO';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'PINGÜINO';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([7], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' MONGO DB';
$recurso->RECU_VERSION =  '4';
$recurso->RECU_OBSERVACIONES =  ' MONGO DB';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([7,20,21,22], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' CODESYS';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  ' CODESYS';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([7], false);


//RECURSOS SALAS 8 DE LA SEDE CENTRAL

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'PUTTY';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'PUTTY';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([8,16], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'MYSQL';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'MYSQL';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([8], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' ADOBE READER';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  ' ADOBE READER';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([8,3,13,14,15,16,19,20,21,22,23], false);

//RECURSOS SALAS 9 DE LA SEDE CENTRAL

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'NIMAX';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'NIMAX';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([9], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'ANDROID STUDIO';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'ANDROID STUDIO';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([2,9,8,10,26], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'HOMER';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'HOMER';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([9], false);


//RECURSOS SALAS 10 DE LA SEDE CENTRAL

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'SUIT ADOBE';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'SUIT ADOBE';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([10,19,26], false);

//RECURSOS SALAS 11 DE LA SEDE CENTRAL
$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'WIRESHARK';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'WIRESHARK';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([11,16], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'PRO MODEL';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'PRO MODEL';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([11], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'OWASP ZAP';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'OWASP ZAP';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([11], false);


//RECURSOS SALAS 12 DE LA SEDE CENTRAL
$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'APACHE TOMCAT';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'APACHE TOMCAT';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([12,20,21], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'DOLI WAP';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'DOLI WAP';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([12], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'GOTO';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'GOTO';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([12], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' QT OPEN';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  ' QT OPEN';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([12], false);

//Varios

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' AUTOCAD';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'AUTOCAD';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,12], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' POSTGRES SQL';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'DB POSTGRES SQL';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,2,7,12], false);



$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' PSEINT';
$recurso->RECU_VERSION =  '2013';
$recurso->RECU_OBSERVACIONES =  'PSEINT';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,2,7,9,12,25], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' PYTHON';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'PYTHON';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,2,7], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' SCILAB';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'SCILAB';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,9,11,12], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = '  ULTRA VPN';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  ' ULTRA VPN ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,2], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = '  SOPHOS';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  ' Sophos end point Agent ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,3,6,13,14,15,16,18,19,20,21,22,23,24,25], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = '  OFFICE 2016';
$recurso->RECU_VERSION =  '2016';
$recurso->RECU_OBSERVACIONES =  '  Office Profesional Plus 2016 ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,2,3,6,9,10,12,19,20,21,22,23,24,25], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = '  OFFICE 2013';
$recurso->RECU_VERSION =  '2013';
$recurso->RECU_OBSERVACIONES =  ' OFFICE 2013 ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([13,14,15,16,19], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = '  VLC';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  ' VLC MEDIA PLAYER';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,2,3,6,7,8,9,11,12,13,14,15,16,19,20,21,22,23,24], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = '   FIREFOX';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  ' MOZILLA FIREFOX ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,3,6,7,8,9,11,12,13,14,15,16,18,19,20,21,22], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = '   XAMPP';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  '  XAMPP ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,2,6,3,8,13,14,15,19,20], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = '   NODE JS';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  '  NODE JS ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,2,3,6,20,21], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = '   GEOGEBRA';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  '  GEOGEBRA ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([2,6,7,8,11,20,21,22], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = '   ZOTERO';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  '  ZOTERO ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([6,7], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = '   WEKA';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  '  WEKA ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([2,6,15,19], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = '   ARDUINO';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  '  ARDUINO ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([7,9,12,25], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = '   MATLAB';
$recurso->RECU_VERSION =  'R2015b';
$recurso->RECU_OBSERVACIONES =  '  MATLAB R2015b ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([9,11,20,21], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'GOOGLE CHROME';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'GOOGLE CHROME ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([1,3,7,6,7,8,9,11,12,13,14,15,16,18,19,20,21,22,25], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'VIRTUAL BOX';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'VIRTUAL BOX ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([11,6,7,20,21,22,23,26], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = 'PEAZIP';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  'PEAZIP ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([2,3,6,7,8,12,13,14,15,16,19], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = '  MICROSOFT PROYECT';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  ' MICROSOFT PROYECT ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([14], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' DOCKER';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  ' DOCKER ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([15], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' JENKINS';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  ' JENKINS ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([15], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' Atmel Studio ';
$recurso->RECU_VERSION =  '7.0';
$recurso->RECU_OBSERVACIONES =  ' Atmel Studio  ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([25], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' Exelearnig ';
$recurso->RECU_VERSION =  '1.0';
$recurso->RECU_OBSERVACIONES =  ' Exelearnig  ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([25], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' PSoC Creator ';
$recurso->RECU_VERSION =  '4.2';
$recurso->RECU_OBSERVACIONES =  ' PSoC Creator ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([25], false);


$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' PSoC Programer ';
$recurso->RECU_VERSION =  '3.2';
$recurso->RECU_OBSERVACIONES =  ' PSoC Programer ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([25], false);

$recurso = new \reservas\Recurso;
$recurso->RECU_DESCRIPCION = ' Keka ';
$recurso->RECU_VERSION =  '1';
$recurso->RECU_OBSERVACIONES =  ' Keka ';
$recurso->RECU_CREADOPOR =  'USER_PRUEBA';
$recurso->save();
$recurso->salas()->sync([26], false);




//##Sede Estacion 1



       $this->command->info('--- FIN de Creación de Recursos de prueba');

    }
}
