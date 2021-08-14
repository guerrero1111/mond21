<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php 
        /*print_r(  $this->session->userdata('pregunta1').'<br/>'  );
        print_r(  $this->session->userdata('pregunta2').'<br/>'  );
        print_r(  $this->session->userdata('pregunta3').'<br/>'  );
        print_r(  $this->session->userdata('pregunta4').'<br/>'  );
         print_r(  $pregunta1->id  );

        die;*/
    
 ?>

<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>




<div class="container mecanica">
<br><br><br>
<div class="col-md-12 text-center">
    <h1>Selecciona cada una de las 5 cartas que están aquí debajo una a la vez, para poder responder las 5 preguntas.
Desplázate por la pantalla para seleccionarlas</h1>
</div>
<br><br><br><br>
<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center oscultar">
</div>
<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center">
	<div id="card1"> 
	  <div class="front"> 
        <?php $destino =  ( substr_count($this->session->userdata('tarjeta_participante'),'1+')>=1) ? '' : 'data-target="#lightbox"'; 
            $imagen = ( substr_count($this->session->userdata('tarjeta_participante'),'1+')>=1) ? 'card11.jpg' : 'card1.jpg';
        ?>
	  	<a href="#" class="" data-toggle="modal" <?php echo $destino; ?> >
	    	<img src="<?php echo base_url()?>img/<?php echo $imagen; ?>">
	    </a>
	  </div> 
	  <div class="back">
    	   <img src="<?php echo base_url()?>img/card11.jpg">
	  </div> 
	</div>		
</div>

<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center">
	<div id="card2"> 
	  <div class="front"> 
	  	        <?php $destino =  ( substr_count($this->session->userdata('tarjeta_participante'),'2+')>=1) ? '' : 'data-target="#lightbox2"'; 
                $imagen = ( substr_count($this->session->userdata('tarjeta_participante'),'2+')>=1) ? 'card22.jpg' : 'card2.jpg';
        ?>
        <a href="#" class="" data-toggle="modal" <?php echo $destino; ?> >
	    	<img src="<?php echo base_url()?>img/<?php echo $imagen; ?>">
	    </a>
	  </div> 
	  <div class="back">
	    <img src="<?php echo base_url()?>img/card22.jpg">
	  </div> 
	</div>		
</div>

<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center">
	<div id="card3"> 
	  <div class="front">
	  	<?php $destino =  ( substr_count($this->session->userdata('tarjeta_participante'),'3+')>=1) ? '' : 'data-target="#lightbox3"'; 
        $imagen = ( substr_count($this->session->userdata('tarjeta_participante'),'3+')>=1) ? 'card33.jpg' : 'card3.jpg';
        ?>
        <a href="#" class="" data-toggle="modal" <?php echo $destino; ?> >
	    	<img src="<?php echo base_url()?>img/<?php echo $imagen; ?>">
	    </a>
	  </div> 
	  <div class="back">
	    <img src="<?php echo base_url()?>img/card33.jpg">
	  </div> 
	</div>		
</div>

<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center">
	<div id="card4"> 
	  <div class="front"> 
	  	<?php $destino =  ( substr_count($this->session->userdata('tarjeta_participante'),'4+')>=1) ? '' : 'data-target="#lightbox4"'; 
        $imagen = ( substr_count($this->session->userdata('tarjeta_participante'),'4+')>=1) ? 'card44.jpg' : 'card4.jpg';
        ?>
        <a href="#" class="" data-toggle="modal" <?php echo $destino; ?> >
	    	<img src="<?php echo base_url()?>img/<?php echo $imagen; ?>">
	    </a>
	  </div> 
	  <div class="back">
	    <img src="<?php echo base_url()?>img/card44.jpg">
	  </div> 
	</div>		
</div>

<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center">
    <div id="card5"> 
      <div class="front"> 
        <?php $destino =  ( substr_count($this->session->userdata('tarjeta_participante'),'5+')>=1) ? '' : 'data-target="#lightbox5"'; 
        $imagen = ( substr_count($this->session->userdata('tarjeta_participante'),'5+')>=1) ? 'card55.jpg' : 'card5.jpg';
        ?>
        <a href="#" class="" data-toggle="modal" <?php echo $destino; ?> >
            <img src="<?php echo base_url()?>img/<?php echo $imagen; ?>">
        </a>
      </div> 
      <div class="back">
        <img src="<?php echo base_url()?>img/card55.jpg">
      </div> 
    </div>      
</div>
<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center oscultar">
</div>




<!--imagen 1 -->
<div id="lightbox" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="container preguntas" style="padding:80px">
        <div class="col-sm-7 col-md-7 text-center contenedorpregu">
        	<span class="titulopop">
                <?php echo $pregunta1->pregunta; ?>
        	</span>
        	<ul class="listapop">
                <li>A) <?php echo $pregunta1->a; ?></li>
                <li>B) <?php echo $pregunta1->b; ?></li>
                <li>C) <?php echo $pregunta1->c; ?></li>

        	</ul>
        	<div class="col-md-4 col-sm-4 col-xs-4 text-center">
                <button class="btn_respuesta" fig="1" resp="a"><img src="<?php echo base_url()?>img/btn1.png"></button>
        	</div>
        	<div class="col-md-4 col-sm-4 col-xs-4 text-center">
        		<button class="btn_respuesta" fig="1" resp="b"><img src="<?php echo base_url()?>img/btn2.png"></button>
        	</div>
        	<div class="col-md-4 col-sm-4 col-xs-4 text-center">
                <button class="btn_respuesta" fig="1" resp="c"><img src="<?php echo base_url()?>img/btn3.png"></button>
        	</div>
        	<div class="col-md-12 text-center relojcontent">
	        	<span class="reloj"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="r1"></span></span>
	        </div>
        </div>
        <div class="col-sm-5 col-md-5">
        	<img src="<?php echo base_url()?>img/card11.jpg" class="cartelm">
        </div>

    </div> 
</div>

<div id="lightbox2" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="container preguntas" style="padding:80px">
        <div class="col-sm-7 col-md-7 text-center contenedorpregu">
        	<span class="titulopop">
                <?php echo $pregunta2->pregunta; ?>
            </span>
            <ul class="listapop">
                <li>A) <?php echo $pregunta2->a; ?></li>
                <li>B) <?php echo $pregunta2->b; ?></li>
                <li>C) <?php echo $pregunta2->c; ?></li>

            </ul>
        	
            <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                <button class="btn_respuesta" fig="2" resp="a"><img src="<?php echo base_url()?>img/btn1.png"></button>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                <button class="btn_respuesta" fig="2" resp="b"><img src="<?php echo base_url()?>img/btn2.png"></button>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                <button class="btn_respuesta" fig="2" resp="c"><img src="<?php echo base_url()?>img/btn3.png"></button>
            </div>

        	<div class="col-md-12 text-center relojcontent">
	        	<span class="reloj"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="r1"></span></span>
	        </div>
        </div>
        <div class="col-sm-5 col-md-5">
        	<img src="<?php echo base_url()?>img/card22.jpg" class="cartelm">
        </div>

    </div> 
</div>

<div id="lightbox3" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="container preguntas" style="padding:80px">
        <div class="col-sm-7 col-md-7 text-center contenedorpregu">
        	<span class="titulopop">
                <?php echo $pregunta3->pregunta; ?>
            </span>
            <ul class="listapop">
                <li>A) <?php echo $pregunta3->a; ?></li>
                <li>B) <?php echo $pregunta3->b; ?></li>
                <li>C) <?php echo $pregunta3->c; ?></li>

            </ul>

            <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                <button class="btn_respuesta" fig="3" resp="a"><img src="<?php echo base_url()?>img/btn1.png"></button>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                <button class="btn_respuesta" fig="3" resp="b"><img src="<?php echo base_url()?>img/btn2.png"></button>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                <button class="btn_respuesta" fig="3" resp="c"><img src="<?php echo base_url()?>img/btn3.png"></button>
            </div>

        	<div class="col-md-12 text-center relojcontent">
	        	<span class="reloj"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="r1"></span></span>
	        </div>
        </div>
        <div class="col-sm-5 col-md-5">
        	<img src="<?php echo base_url()?>img/card33.jpg" class="cartelm">
        </div>

    </div> 
</div>

<div id="lightbox4" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="container preguntas" style="padding:80px">
        <div class="col-sm-7 col-md-7 text-center contenedorpregu">
        	<span class="titulopop">
                <?php echo $pregunta4->pregunta; ?>
            </span>
            <ul class="listapop">
                <li>A) <?php echo $pregunta4->a; ?></li>
                <li>B) <?php echo $pregunta4->b; ?></li>
                <li>C) <?php echo $pregunta4->c; ?></li>

            </ul>
        	
            <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                <button class="btn_respuesta" fig="4" resp="a"><img src="<?php echo base_url()?>img/btn1.png"></button>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                <button class="btn_respuesta" fig="4" resp="b"><img src="<?php echo base_url()?>img/btn2.png"></button>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                <button class="btn_respuesta" fig="4" resp="c"><img src="<?php echo base_url()?>img/btn3.png"></button>
            </div>

        	<div class="col-md-12 text-center relojcontent">
	        	<span class="reloj"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="r1"></span></span>
	        </div>
        </div>
        <div class="col-sm-5 col-md-5">
        	<img src="<?php echo base_url()?>img/card44.jpg" class="cartelm">
        </div>

    </div> 
</div>

<div id="lightbox5" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="container preguntas" style="padding:80px">
        <div class="col-sm-7 col-md-7 text-center contenedorpregu">
            <span class="titulopop">
                <?php echo $pregunta5->pregunta; ?>
            </span>
            <ul class="listapop">
                <li>A) <?php echo $pregunta5->a; ?></li>
                <li>B) <?php echo $pregunta5->b; ?></li>
                <li>C) <?php echo $pregunta5->c; ?></li>

            </ul>
            
            <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                <button class="btn_respuesta" fig="5" resp="a"><img src="<?php echo base_url()?>img/btn1.png"></button>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                <button class="btn_respuesta" fig="5" resp="b"><img src="<?php echo base_url()?>img/btn2.png"></button>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                <button class="btn_respuesta" fig="5" resp="c"><img src="<?php echo base_url()?>img/btn3.png"></button>
            </div>

            <div class="col-md-12 text-center relojcontent">
                <span class="reloj"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="r1"></span></span>
            </div>
        </div>
        <div class="col-sm-5 col-md-5">
            <img src="<?php echo base_url()?>img/card55.jpg" class="cartelm">
        </div>

    </div> 
</div>

</div>
<script>

//https://nnattawat.github.io/flip/
    jQuery(document).ready(function($) {
        //si es la primera vez entonces
        if (!(localStorage.getItem('fondo'))) {
            localStorage.setItem('fondo',  'nada' );
        }
        
        if (!(localStorage.getItem('tiempo_fondo'))) {
            
            localStorage.setItem('tiempo_fondo', '00:00:00' );
            $('span.r1').html(localStorage.getItem('tiempo_fondo'));
        }

        jQuery("#card1,#card2,#card3,#card4,#card5").flip({
           trigger: 'manual'
        });
        
        
        jQuery(localStorage.getItem('fondo')).trigger('click');
       
        //cdo de click para abrir fondo
        //alert('aa');
        jQuery('body').on('click','a[data-toggle="modal"]', function (e) {   
            localStorage.setItem('tiempo_fondo', '00:00:00' );
             $('span.r1').html(localStorage.getItem('tiempo_fondo'));
            //$('span.r1').html('00:00:00');
            //alert('aa');
            //console.log("---"+localStorage.getItem('tiempo_fondo'));
            //$('span.r1').html(localStorage.getItem('tiempo_fondo'));
            //localStorage.setItem('tiempo_fondo',  '' );
            localStorage.setItem('fondo', ('#'+$(this).parent().parent().attr('id')+' [data-target="'+$(this).attr('data-target')+'"]'));

            
        });            


        jQuery('body').on('click','#card1 [data-target="#lightbox"]', function (e) {               
          jQuery("#card1").flip(true);          //jQuery("#card").off('flip'); //no flipear
        });
        jQuery('body').on('click','#card2 [data-target="#lightbox2"]', function (e) {       
        
          jQuery('#card2').flip(true);
        });
        jQuery('body').on('click','#card3 [data-target="#lightbox3"]', function (e) {               
          jQuery("#card3").flip(true);
        });
        jQuery('body').on('click','#card4 [data-target="#lightbox4"]', function (e) {               
          jQuery("#card4").flip(true);
        });
        jQuery('body').on('click','#card5 [data-target="#lightbox5"]', function (e) {               
          jQuery("#card5").flip(true);
        });




        jQuery('body').on('click','.btn_respuesta', function (e) {               
             //jQuery("#card4").flip(true);
             //console.log( $(this).attr('fig') );
             //console.log( $(this).attr('resp') );
             
            jQuery.ajax({ //guardar en la cookie el conteo
                    url : '/respuesta_tarjeta',
                    data : { 
                           figura: $(this).attr('fig'),
                        respuesta: $(this).attr('resp'),
                        tiempo: $('span.r1').html(), //'0:09', //$(this).attr('resp'),
                    },
                    type : 'POST',
                    dataType : 'json',
                    success : function(data) {  
                        //localStorage.setItem('fondo',  'nada' );
                        //localStorage.setItem('tiempo_fondo', '00:00:00');
                        localStorage.clear();

                          window.location.href = '/'+data.redireccion;        
                          //console.log(data);
                          return false;

                    }

            }); 
        });





        var interval = setInterval(function() {
           $('span.r1').html(localStorage.getItem('tiempo_fondo'));
            var timer = $('span.r1').html();

            timer = timer.split(':');
            var hours = parseInt(timer[0], 10);
            var minutes = parseInt(timer[1], 10);
            var seconds = parseInt(timer[2], 10);
            seconds += 1;
            if (seconds > 59) {
                minutes += 1;
                seconds = 00;
                if (minutes > 59) {
                    hours += 1;
                    minutes = 00;
                }
            }
            if (hours < 10 && hours.length != 2) hours = '0' + hours;
            if (minutes < 10 && minutes.length != 2) minutes = '0' + minutes;
            if (seconds < 10 && seconds.length != 2) seconds = '0' + seconds;
            $('span.r1').html(hours + ':' + minutes + ':' + seconds);
            localStorage.setItem('tiempo_fondo',  hours + ':' + minutes + ':' + seconds );

            //console.log(localStorage.getItem('tiempo_fondo'));

            if (hours == 0 && minutes == 0 && seconds == 0)
                clearInterval(interval);
        }, 1000);


    });
</script>

<?php $this->load->view( 'footer' ); ?>