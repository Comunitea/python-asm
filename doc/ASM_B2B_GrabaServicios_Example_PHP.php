<?php
        $uidCliente="6BAB7A53-3B6D-4D5A-9450-702D2FAC0B11";
        $URL= "http://www.asmred.com/websrvs/b2b.asmx?wsdl";

        $envio = array();
        $envio["fecha"] = "16/10/2013";
        $envio["servicio"] = "1";
        $envio["horario"] = "3";
        $envio["bultos"] = "1";
        $envio["peso"] = "1";
        $envio["importe"] = "0";
        $envio["nombreOrg"] = "nombre origen";
        $envio["direccionOrg"] = "direccion origen";
        $envio["poblacionOrg"] = "poblacion origen";
        $envio["codPaisOrg"] = "ES";
        $envio["cpOrg"] = "08100";
        $envio["nombreDst"] = "nombre destino";
        $envio["direccionDst"] = "direccion destino";
        $envio["poblacionDst"] = "poblacion destino";
        $envio["codPaisDst"] = "ES";
        $envio["cpDst"] = "28004";
        $envio["tfnoDst"] = "935936688";
        $envio["emailDst"] = "prueba@prueba.com";
        $envio["observaciones"] = "pruebas observaciones";
        $envio["RefC"] = "1234561002";

        $XML=
'<?xml version="1.0" encoding="utf-8"?>
<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
  <soap12:Body>
    <GrabaServicios  xmlns="http://www.asmred.com/">
      <docIn>
<Servicios uidcliente="' . $uidCliente . '" xmlns="http://www.asmred.com/">
  <Envio>
    <Fecha>' . $envio["fecha"] . '</Fecha>
    <Servicio>' . $envio["servicio"] . '</Servicio>
    <Horario>' . $envio["horario"] . '</Horario>
    <Bultos>' . $envio["bultos"] . '</Bultos>
    <Peso>' . $envio["peso"] . '</Peso>
    <Importes>
        <Reembolso>'. $envio["importe"] .'</Reembolso>
    </Importes>
    <Remite>
      <Nombre>' . $envio["nombreOrg"] . '</Nombre>
      <Direccion>' . $envio["direccionOrg"] . '</Direccion>
      <Poblacion>' . $envio["poblacionOrg"] . '</Poblacion>
      <Pais>' . $envio["codPaisOrg"] . '</Pais>
      <CP>' . $envio["cpOrg"] . '</CP>
    </Remite>
    <Destinatario>
      <Nombre>' . $envio["nombreDst"] . '</Nombre>
      <Direccion>' . $envio["direccionDst"] . '</Direccion>
      <Poblacion>' . $envio["poblacionDst"] . '</Poblacion>
      <Pais>' . $envio["codPaisDst"]. '</Pais>
      <CP>' . $envio["cpDst"] . '</CP>
      <Telefono>' . $envio["tfnoDst"] . '</Telefono>
      <Email>' . $envio["emailDst"] . '</Email>
      <Observaciones>' . $envio["observaciones"] . '</Observaciones>
    </Destinatario>
    <Referencias>
      <Referencia tipo="C">' . $envio["RefC"] . '</Referencia>
    </Referencias>
  </Envio>
</Servicios></docIn>
    </GrabaServicios>
  </soap12:Body>
</soap12:Envelope>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, TRUE);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
        curl_setopt($ch, CURLOPT_URL, $URL );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $XML );
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml; charset=UTF-8"));

        //echo 'xml: ' . $XML . '<br><br>';

        $postResult = curl_exec($ch);
        curl_close($ch);
        //echo 'postResult: ' . $postResult . '<br><br>';


        $xml = simplexml_load_string($postResult, NULL, NULL, "http://http://www.w3.org/2003/05/soap-envelope");
        $xml->registerXPathNamespace('asm', 'http://www.asmred.com/');
        $arr = $xml->xpath("//asm:GrabaServiciosResponse/asm:GrabaServiciosResult");
        $ret = $arr[0]->xpath("//Servicios/Envio");

        $return = $ret[0]->xpath("//Servicios/Envio/Resultado/@return");
        echo 'Return: ' . $return[0] . '<br/><br/>';

        $cb = $ret[0]->xpath("//Servicios/Envio/@codbarras");
        echo 'Codigo barras: ' . $cb[0]["codbarras"];
        $uid = $ret[0]->xpath("//Servicios/Envio/@uid");
        echo '<br/>uid: ' . $uid[0]["uid"];
        
?>