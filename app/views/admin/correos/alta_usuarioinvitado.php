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

	<table border="0" cellspacing="0" cellpadding="0" style="margin:30px auto; background-color:#000000; padding:0px; max-width:580px; width:100%">
	  
	  <tr>
	  	<a href="<?php echo base_url(); ?>nuevo_invitado/<?php echo $id_jefe; ?>" name="boton" style="">
		   <img src="<?php echo base_url(); ?>img/invitado.jpg" alt="imagenesdemail">
		</a>
		<a href="<?php echo base_url(); ?>nuevo_invitado/<?php echo $id_jefe; ?>" style="background:#ebbb34; font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:18px; color:#122145; padding:10px; border:none; text-decoration:none; text-align: center;">
				Si no puedes visualizar la imagen puedes hacer clic aquí para registrarte
			</a>
	  </tr>
	  <!-- <tr>
	   	 <td scope="row" style="text-align:center">
	   	 	
	    	<p style="font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:14px; text-transform: uppercase; color:#ef0711">
	    	<p style="color:#ffffff;width:100%;text-align:center;font-size:28px;">El usuario: </p></br>
	    	<p style="color:#FFC107;width:100%;text-align:center;font-size:28px;"><?php echo $email; ?></p></br>
	    	<p style="color:#ffffff;width:100%;text-align:center;font-size:28px;">Te ha invitado a unirte a su equipo para:</p></br>
	    	<p style="color:#FFC107;width:100%;text-align:center;font-size:28px;">UNIRME AL JUEGO</p></br>
	    	</p>
	   	 </td>
	  </tr> -->
	  <tr>
	   	
	  </tr>
	<!--   <tr style="background-color:#122145;">
	    <td scope="row" style="border-top:5px solid #ebbb34; padding: 15px;">
	    	<p style="font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:14px; color:#5e6d81">		
			Si requieres ayuda o tienes alguna duda contáctanos:
			</p>
			<p style="font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:14px; color:#5e6d81">			
					Correo electrónico: <b><?php echo $this->session->userdata('c1'); ?> </b><br/>
									
			</p>
			<br/>


			
	    </td>
	  </tr>	  --> 
	  
	  <p>			
			<a href="<?php echo base_url(); ?>nuevo_invitado/<?php echo $id_jefe; ?>" name="boton" style="background:#ebbb34; font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:18px; color:#122145; padding:10px; border:none; text-decoration:none;">
				IR AL JUEGO
			</a>
			</p>

	</table>
	

</body>
</html>




