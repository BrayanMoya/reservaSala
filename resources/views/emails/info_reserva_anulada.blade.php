@extends('emails/layout')
@section('title', '- Reserva Anulada')

@section('tituloMensaje')
  <td class="alert alert-warning" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #0f6aca; margin: 0; padding: 20px;" align="center" bgcolor="#0f6aca" valign="top">
    {{ 'Reserva en '.$autorizacion->reservas->first()->sala->SALA_DESCRIPCION.'' }}
  </td>
@endsection

@section('mensaje')

      <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">

       <tr>
          <td colspan="2" style="padding-top:7px;padding-left:25px;height:25px;color:#005da5;font-weight:bolder;font-size:18px;font-family:Helvetica,Arial,sans-serif">DATOS DE LA ORDEN </td>
       </tr>
       <tr>
          <td colspan="2" style="padding-left:25px;padding-right:25px;height:40px"><b>Estimado usuario</b>,
             gracias por usar el servicio de Reserva Salas de Uniajc®. Los datos de su reservación realizada están indicados a continuación.
          </td>
       </tr>
       <tr>
          <td valign="top" style="width:300px">
             <table width="299" border="0">
                <tbody>
                   <tr>
                      <td style="letter-spacing:.5px;padding-top:5px;padding-left:28px;color:#005ea5;font-weight:bolder;font-size:14px;font-family:Helvetica,Arial,sans-serif;height:23px;background-color:#e5eef6">Número de reservación:</td>
                   </tr>
                   <tr>
                      <td style="padding-bottom:10px;padding-left:28px;padding-right:5px;padding-top:5px;font-size:14px">{{ $autorizacion->reservas->first()->RESE_ID }}</td>
                   </tr>
                   <tr>
                      <td style="letter-spacing:.5px;padding-top:5px;padding-left:28px;color:#005ea5;font-weight:bolder;font-size:14px;font-family:Helvetica,Arial,sans-serif;height:23px;background-color:#e5eef6">Sede:</td>
                   </tr>
                   <tr>
                      <td style="padding-bottom:10px;padding-left:28px;padding-right:5px;padding-top:5px;font-size:14px">{{ $autorizacion->reservas->first()->sala->sede->SEDE_DESCRIPCION }}</td>
                   </tr>
                   <tr>
                      <td style="letter-spacing:.5px;padding-top:5px;padding-left:28px;color:#005ea5;font-weight:bolder;font-size:14px;font-family:Helvetica,Arial,sans-serif;height:23px;background-color:#e5eef6">Sala:</td>
                   </tr>
                   <tr>
                      <td style="padding-bottom:10px;padding-left:28px;padding-right:5px;padding-top:5px;font-size:14px">{{ $autorizacion->reservas->first()->sala->SALA_DESCRIPCION }}</td>
                   </tr>
                   <tr>
                      <td style="letter-spacing:.5px;padding-top:5px;padding-left:28px;color:#005ea5;font-weight:bolder;font-size:14px;font-family:Helvetica,Arial,sans-serif;height:23px;background-color:#e5eef6" ><span class="il">Fecha y Hora Inicio</span>:</td>
                   </tr>
                   <tr>
                      <td style="padding-bottom:10px;padding-left:28px;padding-right:5px;padding-top:5px;font-size:14px" class="fecha">{{ date_format(new DateTime($autorizacion->reservas->first()->RESE_FECHAINI), Config::get('view.formatDateTime')) }}</td>
                   </tr>
                   <tr>
                      <td style="letter-spacing:.5px;padding-top:5px;padding-left:28px;color:#005ea5;font-weight:bolder;font-size:14px;font-family:Helvetica,Arial,sans-serif;height:23px;background-color:#e5eef6">Fecha y Hora Fin:</td>
                   </tr>
                   <tr>
                      <td style="padding-bottom:10px;padding-left:28px;padding-right:5px;padding-top:5px;font-size:14px" class="fecha">{{ date_format(new DateTime($autorizacion->reservas->first()->RESE_FECHAFIN), Config::get('view.formatDateTime')) }}</td>
                   </tr>
                   <tr>
                      <td style="letter-spacing:.5px;padding-top:5px;padding-left:28px;color:#005ea5;font-weight:bolder;font-size:14px;font-family:Helvetica,Arial,sans-serif;height:23px;background-color:#e5eef6">Estado:</td>
                   </tr>
                   <tr>
                      <td style="padding-bottom:10px;padding-left:28px;padding-right:5px;padding-top:5px;font-size:14px;background-color:#fdff71">{{ $autorizacion->reservas->first()->autorizaciones-> first()->estado->ESTA_DESCRIPCION }}</td>
                   </tr>
                </tbody>
             </table>
          </td>
          <td align="right" valign="top" style="width:300px">
             <table width="299" border="0">
                <tbody>
                   <tr>
                      <td style="letter-spacing:.5px;padding-top:5px;padding-left:28px;color:#005ea5;font-weight:bolder;font-size:14px;font-family:Helvetica,Arial,sans-serif;height:23px;background-color:#e5eef6">Descripción:</td>
                   </tr>
                   <tr>
                      <td style="line-height:14pt;padding-bottom:10px;padding-left:28px;padding-right:5px;padding-top:5px;font-size:14px">{{ $autorizacion->reservas->first()->RESE_TITULO }} </td>
                   </tr>
                   <tr>
                      <td style="letter-spacing:.5px;padding-top:5px;padding-left:28px;color:#005ea5;font-weight:bolder;font-size:14px;font-family:Helvetica,Arial,sans-serif;height:23px;background-color:#e5eef6">Comentarios:</td>
                   </tr>
                   <tr>
                      <td style="line-height:14pt;padding-bottom:10px;padding-left:28px;padding-right:5px;padding-top:5px;font-size:14px">{{ $autorizacion->AUTO_OBSERVACIONES }} </td>
                   </tr>
                </tbody>
             </table>
          </td>
       </tr>

       <tr>
          <td colspan="2" style="font-weight:bolder;font-size:18px;padding-left:28px;height:27px;background-color:#e5eff6">NOTAS DEL SERVICIO</td>
       </tr>
       <tr>
          <td colspan="2" style="padding-left:28px;padding-right:28px;background-color:#e5eff6;font-size:10px">
             <ul>
                <li>Está completamente prohibido el ingreso y consumo de comidas y bebidas en las salas y cubículos.</li>
                <li>Si al momento de ocupar un equipo o espacio asignado, éste presenta alguna anomalía, daño o irregularidad, se debe avisar al
                  monitor inmediatamente, de lo contrario será responsabilidad del usuario.
                </li>
                <li>Se prohíbe navegar en páginas de pornografía, snurf, descargar música y videos o jugar.</li>
                <li>Sólo se podrá escuchar música o sonidos multimedia haciendo uso de audífonos.</li>
                <li>La información y datos que se encuentren en los equipos de cómputo debe ser respetada por los demás usuarios y no hacer uso indebido de ella con ningún fin.</li>
             </ul>
          </td>
       </tr>

  </table>

@endsection
