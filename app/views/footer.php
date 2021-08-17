<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
		</div>

	
	</div>

<footer>
	
	
	<div class="row blanco blanco123">
	<div class="container" style="margin-top: 4px !important;">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 copy text-left blanco">
				<p class="vigencia1">Vigencia de la promoción: 15 de Agosto al 15 de septiembre de 2021. Para mayor información consulta Bases, términos y condiciones. </p>
						
			</div>			
		</div>
	
</footer>

<script>
window.oncontextmenu = function() {
return false;

} </script>
	<!-- SCRIPTS -->
	<?php  echo link_tag('css/estilos.css');  ?>

	<script src="<?php echo base_url(); ?>/js/bootstrap-3.3.1/dist/js/bootstrap.min.js"></script>
	 

	<!-- componente fecha simple -->
	<?php echo link_tag('css/bootstrap-datepicker.css'); ?>
	
	<!-- componente rango fecha -->
	<?php echo link_tag('css/daterangepicker-bs3.css'); ?>
	
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.form.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/spin.min.js"></script>

	<!-- componente fecha simple -->
	<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script>

	<!-- componente rango fecha -->
	<script type="text/javascript" src="<?php echo base_url(); ?>js/moment.js"></script>		
	<script type="text/javascript" src="<?php echo base_url(); ?>js/daterangepicker.js"></script>		




	<!-- componente fecha simple -->
	<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js"></script>
	
	
	<script src="<?php echo base_url(); ?>js/base64/jquery.base64.js" type="text/javascript"></script>
	
	
	<!--para conversion a base64.encode y base64.decode 
	<script src="<?php echo base_url(); ?>js/base64/jquery.base64.min.js" type="text/javascript"></script>
	
	<script src="<?php echo base_url(); ?>js/base64/jquery.base64_actualizado.js" type="text/javascript"></script>
	-->
	
	<!-- Juego -->	
	<script type="text/javascript" src="<?php echo base_url(); ?>js/juego/jquery.slotmachine.js"></script>

	<!-- mask -->	
  <script src="<?php echo base_url(); ?>js/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
  <!--
  <script src="<?php echo base_url(); ?>js/assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>js/assets/pages/scripts/form-input-mask.min.js" type="text/javascript"></script>
  -->



  <!-- checkbox -->	
  <script src="<?php echo base_url(); ?>js/assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
  <!-- <script src="<?php echo base_url(); ?>js/assets/global/scripts/app.min.js" type="text/javascript"></script>
  -->	


 	 <!-- Mostrar ticket de muestra  -->
		<script type="text/javascript" src="<?php echo base_url(); ?>js/slick.js"></script>

  <!-- Fecha Dropdowns  -->

	<script src="<?php echo base_url(); ?>js/fechaDropdowns/jquery.date-dropdowns.js"></script>

  <!-- Juego de flipear tarjetas -->
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.flip.js"></script>

  <!-- nuestro js principal -->

	<script type="text/javascript" src="<?php echo base_url(); ?>js/sistema.js"></script>

	<script type="text/javascript">
ya=0;
function tickets(){
$(".slider").slick({
        dots: false,
        infinite: true,
        slidesToShow:9,
        slidesToScroll: 1,
        arrows: false,
        autoplay: true,
  		autoplaySpeed: 1500,
        responsive: [
        	{
        		breakpoint:768,
        		settings: {
        			dots: false,
			        infinite: true,
			        slidesToShow: 6,
			        slidesToScroll: 1,
			        arrows: false,
			        autoplay: true,
  					autoplaySpeed: 1500,
        		}
        	},
        	{
        		breakpoint:481,
        		settings: {
        			dots: false,
			        infinite: true,
			        slidesToShow: 2,
			        slidesToScroll: 1,
			        arrows: false,
			        autoplay: true,
  					autoplaySpeed: 1500,
        		}
        	},
        	{
        		breakpoint:361,
        		settings: {
        			dots: false,
			        infinite: true,
			        slidesToShow: 2,
			        slidesToScroll: 1,
			        arrows: false,
			        autoplay: true,
  					autoplaySpeed: 1500,
        		}
        	}
        ]
      });
ya=1;
}
function cerrar(){	
	$('.ventana-ejemplos').animate({'opacity':0}, 1000, function(){
		$('.ventana-ejemplos').css({'z-index':'-100'});
	});
}
function abrir() {
	$('.ventana-ejemplos').css({'z-index':'1000'});
	$('.ventana-ejemplos').animate({'opacity':1}, 1000, function(){
		if (ya == 0) {
			tickets();
		};		
	});
}

$('a.ver-ticket').click(function() {
	abrir();
});

$('.ventana-ejemplos .close').click(function() {
	cerrar();
});

$(document).ready(function() {
	tickets();
});

</script>

</body>
</html>