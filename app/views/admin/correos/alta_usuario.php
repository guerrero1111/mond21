<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "https://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
</head>
<body style="background:#e9e9e9">
<?php 
	if (!isset($retorno)) {
      	$retorno ="";
    }
 ?> 

	<table border="0" cellspacing="0" cellpadding="0" style="margin:30px auto; background-color:#ffffff; padding:0px; max-width:580px; width:100%">
	  
	  <tr>
	   <!-- <img src="https://www.promoscasaley.com.mx/verano2018/img/header1.png" alt="imagenesdemail"> -->
	  </tr>
	  <tr>
	   	 <td scope="row" style="text-align:center">
	   	 	
	    	<p style="font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:14px; text-transform: uppercase; color:#ffffff">
	    	<p style="font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:28px; text-transform: uppercase; color:#000000">Gracias por registrarte a la promoción Llévate un buen sabor... Tus datos de acceso son:</p>
	    	<p style="color:#000000 !important;width:100%;text-align:center;font-size:22px;">Usuario: </p></br>
	    	<p style="color:#000000 !important;width:100%;text-align:center;font-size:22px;"><b><?php echo $nick; ?></b></p></br>
	    	<p style="color:#000000 !important;width:100%;text-align:center;font-size:22px;">Contraseña:</p></br>
	    	<p style="color:#000000 !important;width:100%;text-align:center;font-size:22px;"><b><?php echo $contrasena; ?></b></p></br>
	    	</p>
	   	 </td>
	  </tr>
	  <tr>
	   	
	  </tr>

	  
	</table>
	

</body>
</html>




