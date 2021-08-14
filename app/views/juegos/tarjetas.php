<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>
<style type="text/css">
  h1{
    font-size: 33px !important;
  }
  .container{
    margin-top: 0px !important;
  }
</style>
 <?php 
 
    if (!isset($retorno)) {
        $retorno ='record/'.$this->session->userdata('id_participante');
        //$retorno =""; //registro_ticket
        //UPDATE `calimax_participantes` SET tarjeta='', tiempo_juego='' WHERE 1
        //http://juman.dev.com/record/9d6a4b86-ddd4-11e7-b76f-a81e846a651f
        //http://juman.dev.com/record/9d6a4b86-ddd4-11e7-b76f-a81e846a651f
    }
 ?>   


  <input type="hidden" id="jgo" name="jgo" value="<?php echo $jgo; ?>">

<div class="container mecanica juegop">


<div class="container text-center">

  
  <div class="col-md-12">
  <h1>Gira la mayor cantidad de fichas antes de que se agote el tiempo para acumular puntos</h1>
  </div>
     
</div>
<!-- <div class="row ocultando">
  <button class="btn btn-danger" name="btn_tiempo" id="btn_tiempo">JUGAR AHORA</button> 
  <span class="reloj"  style="display: none;text-align: center;"><i class="fa fa-clock-o" aria-hidden="true"></i><span class="r1 countdown"></span></span>
</div> -->

<div class="row contenedorjuego">
        <!-- <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 tablero" style="pointer-events: none;">   -->
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style=""> 
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-center centroboton">
                 <button class="btn btn-danger ocultandono" name="btn_tiempo" id="btn_tiempo">JUGAR AHORA</button> 
                <span class="reloj"  style="display: none;"><i class="fa fa-clock-o" aria-hidden="true"></i><span class="r1 countdown"></span></span>
     
          </div>
    </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tablero" style="">  

       
           <?php for ($i = 1; $i <= count($cara); $i++) {

            ?>
                 <div class="col-xs-3 col-sm-2 col-md-1 moneda" style="opacity: 0.5;">

                  <div class="card<?php echo ( in_array( $i, $tarj_marcada )==1   ) ? 's': ''; ?>" valor="<?php echo ( in_array( $i, $tarj_marcada )==1   ) ? 's': 'n'; ?>" posicion="<?php echo $i; ?>" numero="<?php echo $misdatos[$i-1]; ?>" cara="<?php echo $cara[$i-1]; ?>" > 

                          <div class="front" style="padding-bottom: 20px;"> 
                            <?php 

                                //$imagen = (  in_array( $i, $tarj_marcada )>=1) ? 'card'.$cara[$i-1].'.png' : (((($i % 3) ==0) ? 'esfera1.png' : (((($i % 2) ==0) ? 'esfera2.png' : 'esfera3.png' )) )) ;
                                
  $imagen = (substr_count($tarjeta,$i.'+')>=1) ? 
  'card'.$cara[$i-1].'.png' : 
    (( 
    (($i % 5) ==0) ? 'ficha1.png' : 
    ((
    (($i % 4) ==0) ? 'ficha2.png' : 
    ((
    (($i % 3) ==0) ? 'ficha3.png' : 
    ((
    (($i % 2) ==0) ? 'ficha4.png' : 'ficha5.png' 
    )) 
    )))))) ;

                                
                                //$imagen = ( substr_count($tarjeta,$i.'+')>=1) ? 'card'.$cara[$i-1].'.png' : 'ficha.png';
                                

                            ?>
                                <img  src="<?php echo base_url()?>img/fichas/<?php echo $imagen; ?>">
                                
                          </div> 
                          <div class="back" style="padding-bottom: 20px; display: <?php echo ( substr_count($tarjeta,$i.'+')>=1) ? 'none': ''; ?>;">
                                
                                <img src="<?php echo base_url().'img/fichas/card'.$cara[$i-1].'.png'; ?>">
                                
                               
                          </div> 
                    </div>      
                </div>
            <?php } ?>

    </div> 
     
</div>

</div>


<?php $this->load->view( 'footer' ); ?>

<div class="modal fade bs-example-modal-lg" data-backdrop="static" data-keyboard="false" id="modalMessage_preg" ventana="pregunta" direccion="<?php echo 'record/'.$this->session->userdata('id_participante');?>" valor="<?php echo $retorno; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" data-backdrop="static" data-keyboard="false" id="modalMessage2" ventana="redi_reintentar" valor="<?php echo $retorno; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
        <div class="modal-content modal-instrucciones"></div>
    </div>
</div>


<div class="modal fade bs-example-modal-lg" data-backdrop="static" data-keyboard="false" id="modalMessage_face" ventana="facebook" valor="<?php echo $retorno; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>