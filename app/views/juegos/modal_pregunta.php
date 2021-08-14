<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
 	if (!isset($retorno)) {
      	$retorno ="registro_ticket";
    }
 $hidden = array('nada'=>'nada'); 

 ?>


<div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>    -->    
</div>
 <div class="modal-body">

            <div class="acumulaste">

                  <?php

                                    $suma_detalle = 0;
                                    if (($acumulado)) {  
                                                        foreach ($acumulado as $key => $value) {
                                                            $suma_detalle = 
                                                                        ((int)$value->cant1)*$this->session->userdata('ip1') +
                                                                        ((int)$value->cant2)*$this->session->userdata('ip2') +
                                                                        ((int)$value->cant3)*$this->session->userdata('ip3') +
                                                                        ((int)$value->cant4)*$this->session->userdata('ip4') +
                                                                        ((int)$value->cant5)*$this->session->userdata('ip5');
                                                            echo        '<h2 class="inst  text-center">¡ACUMULASTE <span style="color:#c2d6e4 !important;">'.$suma_detalle.' </span> PUNTOS!</h2>';                                        
                                                          }
                                }                                        
                              ?>
               
                    <h2 class="inst2  text-center">
                        RESPONDE CORRECTAMENTE PARA DUPLICAR TUS PUNTOS
                    </h2>  
            </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 instru">
           
            <h2 class="inst text-center"><?php echo $pregunta->pregunta; ?></h2>
            <span class="pregunta">
                  
                  
            </span>
            <ul class="opcionesrespuesta2">
                <li>A) <?php echo $pregunta->a; ?></li> 
                <li>B) <?php echo $pregunta->b; ?></li>
            </ul>
            <div class="cont">
            <div class="col-md-6 text-center">
                <button class="btn_respuesta2" fig="1" resp="a">A)</button>
            </div>
            <div class="col-md-6 text-center">
                <button class="btn_respuesta2" fig="1" resp="b">B)</button>
            </div>
            
        </div>
        </div>
<div class="modal-footer">

</div>
