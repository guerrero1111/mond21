<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es_MX">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $this->session->userdata('c2'); ?></title>
	<link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>img/.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109883560-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-109883560-1');
</script>


<script>
  // (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  // (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  // m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  // })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  // ga('create', 'UA-106161455-1', 'auto');
  // ga('send', 'pageview');

</script>

	
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


		<?php echo link_tag('js/assets/global/plugins/icheck/skins/all.css'); ?>
		


	
</head>
<body>
	<div class="container-fluid1">
		<div id="foo"></div>
		
		<div class="row-fluid1" id="wrapper1">
			<div class="alert" id="messages"></div>

    <!-- Inicia Formulario -->
