<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "https://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Has recibido una alerta de Promos Casa Ley</title>
</head>
<body style="background:#e9e9e9">
<?php 
	if (!isset($retorno)) {
      	$retorno ="registro_ticket";
    }
 ?> 

	<table border="0" cellspacing="0" cellpadding="0" style="margin:30px auto; background-color:white; padding:0px; max-width:580px; width:100%">
	  
	  <tr>
	  </tr>
	  <tr>
	   	 <td scope="row" style="text-align:center">
	   	 	
	    	
	    	<p style="font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:28px; text-transform: uppercase; color:#000000">Tus datos de acceso para la promoción promoción Llevate un buen sabor:</p>
	    	<p style="color:#000000 !important;width:100%;text-align:center;font-size:22px;">Usuario: </p></br>
	    	<p style="color:#000000 !important;width:100%;text-align:center;font-size:22px;"><?php echo $nick; ?></p></br>
	    	<p style="color:#000000 !important;width:100%;text-align:center;font-size:22px;">Contraseña:</p></br>
	    	<p style="color:#000000 !important;width:100%;text-align:center;font-size:22px;"><?php echo $contrasena; ?></p></br>
	    	</p></br>
	    	</p>
	   	 </td>
	  </tr>
	  <tr>
	   	<!--<img src="https://www.vamonosaespanaconcalimax.com/img/mailf.png"> -->
	  </tr>
	  
	</table>
	

</body>
</html>

