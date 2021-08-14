<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es_MX">
<head>
	<meta charset="utf-8">
	<noscript> <meta http-equiv = "refresh" content = "0; url = https://www.promoscasaley.com.mx/llevateunbuensabor/antitrampa" /> </noscript>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $this->session->userdata('c2'); ?></title>
	<link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>img/.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <meta property="og:url" content="https://www.promoscasaley.com.mx/llevateunbuensabor/" />
	<meta property="fb:app_id" content="2003835493171756" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Vigencia de la promoción: 15 de Agosto al 15 de septiembre de 2021." />	
	<meta property="og:image:alt" content="image"/>
	<meta property="og:description" content="Llévate un buen sabor de boca"/>
	<meta property="og:image" content="https://www.promoscasaley.com.mx/llevateunbuensabor/img/img_facebook.jpg" />

	
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <?php echo link_tag('css/reset.css'); ?>
    <?php echo link_tag('css/estilo.css'); ?>

	<link rel="stylesheet" href="<?php echo base_url(); ?>js/bootstrap-3.3.1/dist/css/bootstrap.min.css">
	<?php echo link_tag('css/sistema.css'); ?>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/slick.css">
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/slick-theme.css">
  	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  	

 	<!-- componente fecha simple -->
     <?php echo link_tag('css/bootstrap-datepicker.css'); ?>    

		<!-- Estilos del juego-->		
		<?php echo link_tag('js/juego/estilo_juego.css'); ?>
		<?php echo link_tag('js/juego/jquery.slotmachine.css'); ?>

		<?php
		$now = date('Y/m/d H:i:s');

		$tz = 'America/Mazatlan';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		//$today_formatted = strtotime ( '+5 minute' , $today_formatted); 
		//$today->modify('-6 minute');
		$today_formatted = $today->format('Y/m/d H:i:s');
		//echo "<span style='color:white'>".$today_formatted."</span><br>";

		$abrir = '2019/01/15 08:57:00'; #could be (almost) any string date
		$cerrar = '2021/09/15 23:59:59'; #could be (almost) any string date
		if (($today_formatted > $abrir)&&($today_formatted < $cerrar)){
			$GLOBALS['open']=1;
		}else{
			$GLOBALS['open']=0;
		}
		echo "<span style='color:white;display:none'>".$today_formatted."</span>";
		echo "<span style='color:white;display:none'>".$abrir."</span>";
		echo "<span style='color:white;display:none'>".$cerrar."</span>";
		?>
		

		


	
</head>
<body>
	<div class="container-fluid1">
		<div id="foo"></div>
		
		<div class="row-fluid1" id="wrapper1">
			<div class="alert" id="messages"></div>

    <!-- Inicia Formulario -->
