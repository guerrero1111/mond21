<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>
<style>
.logoderecha{
    display: none;
}
body {
   background-image: url(img/fondo.jpg) !important;
  
    
  
    margin-top: 0px !important;
}
.otrologo{
    display: none;
}
.logosfoo{
    display: none;
}

.navbar-brand{
	
}
.infohome{
    background-color: #f9d000;
    padding: 30px;
    border-radius: 20px;
    border:6px solid #0d216a;
    color: #0d216a;
    font-size: 20px;
    line-height: 1.6;
}
.imgdos{
    width: 73%;
}
.sinizquierdo.imgcuatro{
        margin-top: 59px !important;
}
.imgdos{
    margin: 0px auto;
    display: inline-block;
}
.imgtres{
       width: 29%;
    margin: 0px auto;
    display: block;
}
.conthome12 [class*="col-"] {
    float: none;
    display: table-cell;
    vertical-align: bottom; 
    
}
footer{
    margin-top: 30px !important;
}
.imgcuatros{
    width: 70%;
    margin: 0px auto;
}
footer{}
@media only screen and (max-width : 650px) {
body{
      background-size: 269% !important;
      padding-bottom: 60px !important;
      
    }
    
    .dashome .contenedor2 .imgtres{
       
       margin: 0px auto !important;
    
}
.conthome12 [class*="col-"] {
    float: left;
    display: inline-block;
    
    
}
    
 }   
</style>
 <?php 
     if ($this->session->userdata('session_participante') == true) { 
        $retorno ="registro_ticket";
    } else {
        $retorno ="registro_usuario";
    }


 $attr = array('class' => 'form-horizontal', 'id'=>'form_registrar_ticket','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
 echo form_open('/validar_registrar_ticket', $attr);
?>  

        <div class="container dashome" style="margin-bottom: 29px;">
            <?php
 



    #$date occurs in the future

?>  
            <div class="col-md-12">
                        




<?php
if ($GLOBALS['open']==1) {
    #$date occurs in the future
?>  
   <!--  <div class="ganar col-md-push-3 col-lg-push-3 col-lg-6 col-md-6 col-sm-12 col-xs-12 contenedor2" >
        <div class="col-md-6 col-md-6">
            <img src="<?php echo base_url()?>img/home1.png" class="img-responsive sinizquierdo homeizquierda1" style="">
        </div>
        <div class="col-md-6 col-md-6">
            <img src="<?php echo base_url()?>img/home2.png" class="img-responsive sinizquierdo homeizquierda1 imgcuatro" style="">
        </div>
        <div class="col-md-12 col-md-12 text-center">

            <img src="<?php echo base_url()?>img/hometexto.png" class="img-responsive sinizquierdo homeizquierda1 imguno" style="">
            <a href="<?php echo base_url(); ?>ingresar_usuario" class="">
            <img src="<?php echo base_url()?>img/homebtnregistrar.png" class="img-responsive sinizquierdo homeizquierda1 imgdos" style="">
        </a>
        <a href="<?php echo base_url(); ?>recuperar_participante" class="">
            <img src="<?php echo base_url()?>img/homerecuperar.png" class="img-responsive sinizquierdo homeizquierda1 imgtres" style="">
        </a>
        </div>
        
    </div> -->

    <div class="ganar col-lg-12 col-md-12 col-sm-12 col-xs-12 contenedor2 conthome12" style="display: table;">
        <div class="col-md-7 col-xs-12 text-center">
            <img src="<?php echo base_url()?>img/home1.png" class="img-responsive sinizquierdo homeizquierda1 " style="">
             <a href="<?php echo base_url(); ?>ingresar_usuario" class="">
                <img src="<?php echo base_url()?>img/home2.png" class="img-responsive sinizquierdo homeizquierda1 imgtres" style="">
            </a>
            <a href="<?php echo base_url(); ?>recuperar_participante" class="" style="text-decoration: underline;">
                OLVIDE MI CONTRASEÑA
            </a>
            <img src="<?php echo base_url()?>img/home3.png" class="img-responsive sinizquierdo homeizquierda1 " style="">
        </div>
        <div class="col-md-5 col-xs-12 text-center">
            <img src="<?php echo base_url()?>img/home4.png" class="img-responsive sinizquierdo homeizquierda1 " style="">
        </div>
        
    </div>

 <?php

} else {

?>  


 <div class="ganar col-lg-12 col-md-12 col-sm-12 col-xs-12 contenedor2 conthome12" style="display: table;">
        <div class="col-md-3 col-md-3 text-center">
            <img src="<?php echo base_url()?>img/homeizquierda.png" class="img-responsive sinizquierdo homeizquierda1 " style="">
        </div>
        <div class="col-md-6 col-md-6 text-center">
            <img src="<?php echo base_url()?>img/logogrande.png" class="img-responsive sinizquierdo homeizquierda1" style="">
            
            
                <img src="<?php echo base_url()?>img/cerrado.png" class="img-responsive sinizquierdo homeizquierda1 imgtres" style="">
            
            <a href="<?php echo base_url(); ?>recuperar_participante" class="">
                <img src="<?php echo base_url()?>img/homerecuperar.png" class="img-responsive sinizquierdo homeizquierda1 imgtres" style="">
            </a>
            <img src="<?php echo base_url()?>img/registrohomemensaje2.png" class="img-responsive sinizquierdo homeizquierda1 imgcuatros" style="">
        </div>
        <div class="col-md-3 col-md-3 text-center">
            <img src="<?php echo base_url()?>img/homederecha.png" class="img-responsive sinizquierdo homeizquierda1 " style="">
        </div>
    </div>



<?php
    
}
    
?>  



                          
        </div>



<?php echo form_close(); ?>



<?php $this->load->view( 'footer' ); ?>



<div class="modal fade bs-example-modal-lg" id="modalMessage"  ventana="redi_ticket" valor="<?php echo $retorno; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>



<script type="text/javascript">
ya=0;
function tickets(){
$(".slider").slick({
        dots: false,
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 5500,
        responsive: [
            {
                breakpoint:768,
                settings: {
                    dots: false,
                    infinite: false,
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    arrows: true,
                    autoplay: true,
                    autoplaySpeed: 5500,
                }
            },
            {
                breakpoint:481,
                settings: {
                    dots: false,
                    infinite: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true,
                    autoplay: true,
                    autoplaySpeed: 5500,
                }
            },
            {
                breakpoint:361,
                settings: {
                    dots: false,
                    infinite: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true,
                    autoplay: true,
                    autoplaySpeed: 5500,
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