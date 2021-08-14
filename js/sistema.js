jQuery(document).ready(function($) {

 

 

	var opts = {
		lines: 13, 
		length: 20, 
		width: 10, 
		radius: 30, 
		corners: 1, 
		rotate: 0, 
		direction: 1, 
		color: '#E8192C',
		speed: 1, 
		trail: 60,
		shadow: false,
		hwaccel: false,
		className: 'spinner',
		zIndex: 2e9, 
		top: '50%', // Top position relative to parent
		left: '50%' // Left position relative to parent		
	};


	/////////////////validaciones///////////////////////////

	var hash_url = window.location.pathname;


  	jQuery("#ticket").inputmask("9999 9999 9999 9999 9999 999", {
            placeholder: " ",
            clearMaskOnLostFocus: true
    });


  	jQuery("#folio").inputmask("99999999", {
            placeholder: " ",
            clearMaskOnLostFocus: true
    });
 	jQuery("#folio2").inputmask("9999999", {
            placeholder: " ",
            clearMaskOnLostFocus: true
    });

 	jQuery("#tipo").on('change',function(){
	    if( jQuery(this).val()==="folio"){    
		    jQuery("#foliocon2").hide();
		    jQuery("#foliocon").show();
		    jQuery("#folio2").prop( "disabled", true ); 
		    jQuery("#folio").prop( "disabled", false );
		    jQuery("#folio").val("");
	    }
	    else{
		    jQuery("#foliocon").hide();
		    jQuery("#folio").prop( "disabled", true );
		    jQuery("#folio2").prop( "disabled", false );
		    jQuery("#folio2").val("");
		    jQuery("#foliocon2").show();
	    }
	});


	jQuery(".navigacion").change(function()	{
	    document.location.href = jQuery(this).val();
	});

   	var target = document.getElementById('foo');


		jQuery("#fecha_nac").dateDropdowns({
					submitFieldName: 'fecha_nac', //Especificar el "atributo name" para el campo que esta oculto
					submitFormat: "dd-mm-yyyy", //Especificar el formato que la fecha tendra para enviar
					displayFormat:"dmy", //orden en que deben ser prestados los campos desplegables. "dia, mes, año"
					//initialDayMonthYearValues:['Día', 'Mes', 'Año'],
					yearLabel: 'Año', //Identifica el menú desplegable "Año"
					monthLabel: 'Mes', //Identifica el menú desplegable "Mes"
					dayLabel: 'Día', //Identifica el menú desplegable "Día"
					monthLongValues: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
					monthShortValues: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
					daySuffixes: false,  //que no tengan sufijo
					//minAge:18, //edad minima
					//maxAge:150, //edad maxima
					minYear: 1900,
					maxYear: 2001,

				});

	jQuery('.input-group.date.compra').datepicker({
		//startView: 2,
		
		format: "mm/dd/yy",
		startDate: "08/2/2021", //"-2d" MES - DIA - ANO
		endDate: "+0d", 
	    language: "es",
	    autoclose: true,
	    todayHighlight: true

	});



	////////////////////////////////////////////

//new ok si oculta la modal del facebook, o la ignora, entonces va directo al registro de ticket

jQuery("body").on('hide.bs.modal','#modalMessage_preg',function(e){	
	$catalogo = jQuery(this).attr('direccion'); //e.target.name;
	window.location.href = '/llevateunbuensabor/'+$catalogo;						    
	//window.location.href = '/llevateunbuensabor/registrar_facebook/0';
});	

//cuando se oculta la ventana modal de felicidades se redirige al  "record"  (facebook)
jQuery("body").on('hide.bs.modal','#modalMessage3',function(e){    
    $catalogo = jQuery(this).attr('direccion'); //e.target.name;
    window.location.href = '/llevateunbuensabor/'+$catalogo;                           
});



    //creacion de usuarios 
	jQuery('body').on('submit','#form_reg_participantes', function (e) {	

		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);

		jQuery(this).ajaxSubmit({
			dataType : 'json',
			success: function(data){
				
				if(data.exito != true){
					console.log(data);	
					spinner.stop();
					jQuery('#foo').css('display','none');
					
					jQuery('#msg_nombre').html(data.nombre);
					jQuery('#msg_apellidos').html(data.apellidos);
					jQuery('#msg_email').html(data.email);
					jQuery('#msg_fecha_nac').html(data.fecha_nac);	

					jQuery('#msg_calle').html(data.calle);
					jQuery('#msg_numero').html(data.numero);
					jQuery('#msg_colonia').html(data.colonia);
					jQuery('#msg_municipio').html(data.municipio);
					jQuery('#msg_cp').html(data.cp);	

					jQuery('#msg_ciudad').html(data.ciudad);
					//jQuery('#msg_estado').html(data.estado);
					jQuery('#msg_celular').html(data.celular);					
					jQuery('#msg_telefono').html(data.telefono);
 				    jQuery('#msg_estado').html(data.id_estado_compra);  
					jQuery('#msg_nick').html(data.nick);
					
					
					jQuery('#msg_pass_1').html(data.pass_1);
					jQuery('#msg_pass_2').html(data.pass_2);					

					
					
					jQuery('#msg_coleccion_id_aviso').html(data.coleccion_id_aviso);					
					jQuery('#msg_coleccion_id_base').html(data.coleccion_id_base);					
									
					jQuery('#msg_general').html("Algunos datos no son correctos, por favor revisa la información");
				

				}else{
						//$catalogo = e.target.name;
						spinner.stop();
						jQuery('#foo').css('display','none');
						window.location.href = '/llevateunbuensabor/'+data.redireccion;    //$catalogo;						

						/*
						//new ok 
						var url = "/llevateunbuensabor/proc_modal_instrucciones";
						//alert(url);
						jQuery('#modalInstrucciones').modal({
							  show:'true',
							remote:url,
						}); 									        	
						*/


				}
			} 
		});
		return false;
	});	




  //logueo y recuperar contraseña
	jQuery("#form_logueo_participante").submit(function(e){
		jQuery('#foo').css('display','block');

		var spinner = new Spinner(opts).spin(target);

		jQuery(this).ajaxSubmit({
			dataType : 'json',
			success: function(data){
				
				if(data.exito != true){
					spinner.stop();
					jQuery('#foo').css('display','none');

		
					jQuery('#msg_email').html(data.nick);
					jQuery('#msg_contrasena').html(data.contrasena);
  				    jQuery('#msg_general').html(data.general);
				

					
				}else{
						//$catalogo = e.target.name;
						spinner.stop();
						jQuery('#foo').css('display','none');
						window.location.href = '/llevateunbuensabor/'+data.redireccion;    //$catalogo;				

						//new ok 
						//alert(data.jugo);
						/*
						if (data.jugo!= true) {
								var url = "/llevateunbuensabor/proc_modal_instrucciones";
								//alert(url);
								jQuery('#modalInstrucciones').modal({
									  show:'true',
									remote:url,
								}); 	
						} else {
							window.location.href = '/llevateunbuensabor/';    
						}
						*/
				}
			} 
		});
		return false;
	});




//////////////////////////////////////////////////////////
/////////////////////registro de ticket/////////////////////////////////////
//////////////////////////////////////////////////////////

//gestion de usuarios (crear, editar y eliminar )
	jQuery('body').on('submit','#form_registro_ticket', function (e) {	


		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);

		jQuery(this).ajaxSubmit({
			dataType : 'json',
			success: function(data){
				if(data != true){
					
					spinner.stop();
					jQuery('#foo').css('display','none');
					
					jQuery('#msg_monto').html(data.monto);
					jQuery('#msg_ticket').html(data.ticket);
					jQuery('#msg_compra').html(data.compra);
					jQuery('#msg_ciudad_compra').html(data.id_ciudad_compra);
					
					jQuery('.msg_folio').html(data.folio);
  				    jQuery('#msg_general').html(data.general);
					jQuery('.btnregistro').css('pointer-events','auto');


				}else{


						spinner.stop();
						jQuery('#foo').css('display','none');
						jQuery('.btnregistro').css('pointer-events','auto');

						var url = "/llevateunbuensabor/proc_modal_instrucciones";	
						

						jQuery('#modalMessage').modal({
						  	show:'true',
							remote:url,
						}); 	

						/*
						$catalogo = e.target.name;
						spinner.stop();
						jQuery('#foo').css('display','none');
						window.location.href = '/llevateunbuensabor/'+$catalogo;				
						*/

				}
			} 
		});
		return false;
	});	

//cuando se oculta la ventana de instrucciones 
jQuery("body").on('hide.bs.modal','#modalMessage[ventana="redi_ticket"]',function(e){	
			$catalogo = jQuery(this).attr('valor'); //$catalogo="registro_ticket"
			window.location.href = '/llevateunbuensabor/'+$catalogo;						    


});


/////////////////////////////////////////////////////////////////////////////////
///////////////////////////////JUEGO//////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////


         //$(document).bind("contextmenu",function(e){ return false; });

//caso en que cierren la modal_preg
// console.log(localStorage.getItem('modal_preg'));

// if ((localStorage.getItem('modal_preg'))) {
		
// 		localStorage.setItem('modal_preg', true);
//         var url = "/llevateunbuensabor/proc_modal_pregunta";
//         jQuery('#modalMessage_preg').modal({
//               show:'true',
//             remote:url,
//         }); 	

// }	


         //cada vez que vira una carta
        jQuery('body').on('click','.card[valor="n"]', function (e) {               
          jQuery(this).attr('valor','s');
          jQuery(this).off('.flip'); //no flipear          
          jQuery.ajax({ //guardar en la cookie el conteo
                    url : '/llevateunbuensabor/respuesta_tarjeta',
                    data : { 
                        posicion: $(this).attr('posicion'),  //posicion dentro de la matriz
                        numero: $(this).attr('numero'),  //numeros que tocan de 1..90(maximo de tarjetas)
                        cara: $(this).attr('cara'),     //cara 1..5 (tipos de tarjetas)
                        tiempo   :  $('span.reloj:visible > span.r1').text(),  //tiempo en que se viro esta tarjeta 
                        //cara: $('span.reloj:visible > span.r1').html(), //'0:09', //$(this).attr('resp'),
                    },
                    type : 'POST',
                    dataType : 'json',
                    success : function(data) {  
                        //localStorage.setItem('fondo',  'nada' );
                        //localStorage.setItem('tiempo_fondo', '00:00:00');
                          

                        if (data.redireccion==0) {
										localStorage.clear();
										localStorage.setItem('modal_preg', true);
		                                var url = "/llevateunbuensabor/proc_modal_facebook";
		                                jQuery('#modalMessage_preg').modal({
		                                      show:'true',
		                                    remote:url,
		                                }); 

                        }  else if (data.redireccion!=8888) {
									clearInterval(interval);  //limpiar el intervalo
							        localStorage.clear(); //quitar las variables del localStorage													    		
							    		//comenzar un nuevo juego 
									var url = "/llevateunbuensabor/proc_modal_reintentar";
									jQuery('#modalMessage2[ventana="redi_reintentar"]').modal({
									  	show:'true',
										remote:url,
									}); 
						}
					                     

                          
                          return false;

                    }

            }); 


        });

        jQuery(".card[valor='n']").flip(); 

        //da click en Jugar Ahora(para comenzar con el conteo de tiempo)
        jQuery("body").one('click','#btn_tiempo,.tablero',function(e){  

            if ( !(localStorage.getItem('tiempo_fondo'))) {
            	localStorage.setItem('tiempo_fondo', '0:10' );  	
            } else {
            	localStorage.setItem('tiempo_fondo', localStorage.getItem('tiempo_fondo') );  	
            }
            
            jQuery.ajax({ //guardar en la cookie el conteo
				url : '/llevateunbuensabor/tiempoinicial',	
			});
            
            $('span.reloj:visible > span.r1').html(localStorage.getItem('tiempo_fondo'));

                      if ((localStorage.getItem('tiempo_fondo'))) {
                                jQuery('button#btn_tiempo').css('display','none');                               
                                jQuery('.reloj').css('display','block');
                                  //$('.tablero').css('pointer-events','auto');

                                  
                                  jQuery('.moneda').css('opacity',1);

                                  
                                  //$(document).bind("contextmenu",function(e){ return true; }); 

                              //var timer2 = localStorage.getItem('tiempo_fondo');      
                            
                              var interval = setInterval(function() {
                                var timer = localStorage.getItem('tiempo_fondo').split(':');
                                console.log(localStorage.getItem('tiempo_fondo'));
                                //return false;

                                  var minutes = parseInt(timer[0], 10);
                                  var seconds = parseInt(timer[1], 10);
                                  --seconds;
                                  minutes = (seconds < 0) ? --minutes : minutes;
                                  if (minutes < 0) clearInterval(interval);
                                  seconds = (seconds < 0) ? 59 : seconds;
                                  seconds = (seconds < 10) ? '0' + seconds : seconds;
                                  //minutes = (minutes < 10) ?  minutes : minutes;


                                //minutes = (minutes < 10) ?  minutes : minutes;
                                  if (localStorage.getItem('tiempo_fondo').substring(0, 1) !="-"){
                                      $('.countdown').html(minutes + ':' + seconds);
                                  } else {
                                      $('.countdown').html('0:00');
                                  } 
                                  timer2 = minutes + ':' + seconds;
                                  localStorage.setItem('tiempo_fondo', minutes + ':' + seconds);



                                  if (localStorage.getItem('tiempo_fondo').substring(0, 1) =="-"){
                                      $('.countdown').html('0:00');
                                       $('.tablero').css({pointerEvents: "none"});
                                  } 

                                  if (minutes == 0 && seconds == 0) {

                                  		jQuery.ajax({ //guardar en la cookie el conteo
											            url : '/llevateunbuensabor/tiempofinal',	
											    });


                                       $('.tablero').css({pointerEvents: "none"});
                                             jQuery.ajax({ //guardar en la cookie el conteo
                                                    url : '/llevateunbuensabor/tiempo_juego',
                                                    data : { 
                                                        tiempo   :  $('span.reloj:visible > span.r1').text(),
                                                    },
                                                    type : 'POST',
                                                    dataType : 'json',
                                                    success : function(data) {  
                                                         if (data.redireccion==0) {
																		clearInterval(interval);  //limpiar el intervalo
														         		localStorage.clear(); //quitar las variables del localStorage
														         		localStorage.setItem('modal_preg', true);
										                                var url = "/llevateunbuensabor/proc_modal_facebook";
										                                jQuery('#modalMessage_preg').modal({
										                                      show:'true',
										                                    remote:url,
										                                }); 

									                        }  else if (data.redireccion!=8888) {
																		clearInterval(interval);  //limpiar el intervalo
																        localStorage.clear(); //quitar las variables del localStorage													    		
																        //comenzar un nuevo juego 
																		var url = "/llevateunbuensabor/proc_modal_reintentar";
																		jQuery('#modalMessage2[ventana="redi_reintentar"]').modal({
																		  	show:'true',
																			remote:url,
																		}); 
															} 

                                                                         
                                                          return false;

                                                    }

                                            }); 

                                  }
                               
                               
                            }, 1000);
 					}  // if ((localStorage.getItem('tiempo_fondo'))) {

         }); //jQuery("body").on('click','#btn_tiempo',function(e){  


    


        //si es la primera vez entonces
        if ((localStorage.getItem('tiempo_fondo'))) {
		          //var timer2 = localStorage.getItem('tiempo_fondo'); 
		          jQuery('#btn_tiempo').css('display','none');
		          jQuery('.reloj').css('display','block');
		          //$('.tablero').css('pointer-events','auto');  
		          jQuery('.moneda').css('opacity',1);
		          //$(document).bind("contextmenu",function(e){ return true; });   
		        
		        
		          var interval = setInterval(function() {
		            var timer = localStorage.getItem('tiempo_fondo').split(':');
		            //console.log(localStorage.getItem('tiempo_fondo'));
		            //return false;

		              var minutes = parseInt(timer[0], 10);
		              var seconds = parseInt(timer[1], 10);
		              --seconds;
		              minutes = (seconds < 0) ? --minutes : minutes;
		              if (minutes < 0) clearInterval(interval);
		              seconds = (seconds < 0) ? 59 : seconds;
		              seconds = (seconds < 10) ? '0' + seconds : seconds;
		              //minutes = (minutes < 10) ?  minutes : minutes;


		            //minutes = (minutes < 10) ?  minutes : minutes;
		              if (localStorage.getItem('tiempo_fondo').substring(0, 1) !="-"){
		                  $('.countdown').html(minutes + ':' + seconds);
		              } else {
		                  $('.countdown').html('0:00');
		              } 
		              timer2 = minutes + ':' + seconds;
		              localStorage.setItem('tiempo_fondo', minutes + ':' + seconds);



		              if (localStorage.getItem('tiempo_fondo').substring(0, 1) =="-"){
		                  $('.countdown').html('0:00');
		              } 

		              if (minutes == 0 && seconds == 0) {
		                   
		              			jQuery.ajax({ //guardar en la cookie el conteo
									url : '/llevateunbuensabor/tiempofinal',	
								}); 


		                         jQuery.ajax({ //guardar en la cookie el conteo
		                                url : '/llevateunbuensabor/tiempo_juego',
		                                data : { 
		                                    tiempo   :  $('span.reloj:visible > span.r1').text(),
		                                },
		                                type : 'POST',
		                                dataType : 'json',
		                                success : function(data) {  
                                                         if (data.redireccion==0) {
																		clearInterval(interval);  //limpiar el intervalo
														         		localStorage.clear(); //quitar las variables del localStorage
														         		localStorage.setItem('modal_preg', true);
										                                var url = "/llevateunbuensabor/proc_modal_facebook";
										                                jQuery('#modalMessage_preg').modal({
										                                      show:'true',
										                                    remote:url,
										                                }); 

									                        }  else if (data.redireccion!=8888) {
																		clearInterval(interval);  //limpiar el intervalo
																        localStorage.clear(); //quitar las variables del localStorage													    		
																    		//comenzar un nuevo juego 
																		var url = "/llevateunbuensabor/proc_modal_reintentar";
																		jQuery('#modalMessage2[ventana="redi_reintentar"]').modal({
																		  	show:'true',
																			remote:url,
																		}); 
															}

                                                                         
                                                          return false;

                                         }

		                        }); 

		              }
		           
		           
		        }, 1000);


 			} //if ((localStorage.getItem('tiempo_fondo'))) {
                                          



///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
                                          
     //si cancela el facebook  entonces va a record, pero esta quizas no va a funcionar porq no se debe cancelar
    jQuery("body").on('hide.bs.modal','#modalMessage_face[ventana="facebook"]',function(e){  
        localStorage.clear();  //quitar las variables del localStorage
        $catalogo = jQuery(this).attr('valor'); //e.target.name;
        window.location.href = '/llevateunbuensabor/'+$catalogo;                           
        
    }); 




  //este btn aparece en la ventana de respuesta modal_instrucciones
       jQuery('body').on('click','.btn_respuesta2', function (e) {  
              e.preventDefault();
                jQuery.ajax({ //guardar en la cookie el conteo
                        url : '/llevateunbuensabor/respuesta_juego',
                        data : { 
                              // figura: jQuery('div.front[activo="activo"]').attr('valor'), //$(this).attr('fig'),
                            respuesta: jQuery(this).attr('resp'),
                            
                        },
                        type : 'POST',
                        dataType : 'json',
                        success : function(data) {  
                             
                              localStorage.setItem('virada',  0 );
                              		//clearInterval(interval);  //limpiar el intervalo
							   localStorage.clear(); //quitar las variables del localStorage													    		

                               //levantar la modal de felicidades
                                var url = "/llevateunbuensabor/proc_modal_facebook";  
                                jQuery('#modalMessage_face').modal({
                                    show:'true',
                                    remote:url,
                                });
                              return false;
                             

                        }

                }); 
                
        });


  



		////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
	
        jQuery('.icheck1').each(function() {
            var checkboxClass = jQuery(this).attr('data-checkbox') ? jQuery(this).attr('data-checkbox') : 'icheckbox_minimal-grey';
            var radioClass = jQuery(this).attr('data-radio') ? jQuery(this).attr('data-radio') : 'iradio_minimal-grey';

            if (checkboxClass.indexOf('_line') > -1 || radioClass.indexOf('_line') > -1) {
                jQuery(this).iCheck({
                    checkboxClass: checkboxClass,
                    radioClass: radioClass,
                    insert: '<div class="icheck_line-icon"></div>' + jQuery(this).attr("data-label")
                });
            } else {
                jQuery(this).iCheck({
                    checkboxClass: checkboxClass,
                    radioClass: radioClass
                });
            }
        });

	
	

	//new ok si oculta la modal del facebook, o la ignora, entonces va directo al registro de ticket
/*
	jQuery("body").on('hide.bs.modal','#modalMessage[ventana="facebook"]',function(e){	
		$catalogo = jQuery(this).attr('valor'); //e.target.name;
		window.location.href = '/llevateunbuensabor/'+$catalogo;						    
		
	});	*/




	//reintentar el juego
	jQuery("body").on('hide.bs.modal','#modalMessage2[ventana="redi_reintentar"]',function(e){	
		localStorage.clear();
		location.reload();
	});

 	

	jQuery('body').on('submit','#form_registrar_ticket', function (e) {	


		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);

		jQuery(this).ajaxSubmit({
			dataType : 'json',
			success: function(data){
				if(data != true){

					
					spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#msg_general').html(data.general);
					/*
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);*/
				}else{
					
						$catalogo = e.target.name;
						spinner.stop();
						jQuery('#foo').css('display','none');
						window.location.href = '/llevateunbuensabor/'+$catalogo;				
				}
			} 
		});
		return false;
	});	


	
// 	var getBrowserInfo = function() {
//     var ua= navigator.userAgent, tem, 
//     M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
//     if(/trident/i.test(M[1])){
//         tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
//         return 'IE '+(tem[1] || '');
//     }
//     // versiones
//     if(M[1]=== 'Chrome'){
//         tem= ua.match(/\b(OPR|Edge)\/(\d+)/);
//         if(tem!= null) return tem.slice(1).join(' ').replace('OPR', 'Opera');
//     }
//     M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
//     if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
    
    
//     return M.join(' ');
// };


//   var ua= getBrowserInfo();
//    M= ua.match(/(operaNO|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];

//   if (M.length <=0) {
//     window.location.href = '/llevateunbuensabor/antitrampa';
//   }




         // $(window).on('blur', function(evento) {
         //     window.location.href = '/llevateunbuensabor/antitrampa';
         // });
	



//          !function() {
//   function detectDevTool(allow) {
//     if(isNaN(+allow)) allow = 100;
//     var start = +new Date(); // Validation of built-in Object tamper prevention.
    
//     debugger;	

//     var end = +new Date(); // Validates too.
//     if(isNaN(start) || isNaN(end) || end - start > allow) {
       
//        window.location.replace("https://www.promoscasaley.com.mx/llevateunbuensabor/antitrampa");
      
//     }
//   }
//   if(window.attachEvent) {
//     if (document.readyState === "complete" || document.readyState === "interactive") {
//         detectDevTool();
//       window.attachEvent('onresize', detectDevTool);
//       window.attachEvent('onmousemove', detectDevTool);
//       window.attachEvent('onfocus', detectDevTool);
//       window.attachEvent('onblur', detectDevTool);
//     } else {
//         setTimeout(argument.callee, 0);
//     }
//   } else {
//     window.addEventListener('load', detectDevTool);
//     window.addEventListener('resize', detectDevTool);
//     window.addEventListener('mousemove', detectDevTool);
//     window.addEventListener('focus', detectDevTool);
//     window.addEventListener('blur', detectDevTool);
//   }
// }();
       


          // var element = new Image;
          //   var devtoolsOpen = false;
          //   element.__defineGetter__("id", function() {
          //       devtoolsOpen = true; // This only executes when devtools is open.
                 
          //         window.location.href = '/llevateunbuensabor/antitrampa';
          //   });
          //   setInterval(function() {
          //       devtoolsOpen = false;
          //       console.log(element);
                
          //       var a= devtoolsOpen ? "dev tools esta abierto\n" : "dev tools esta cerrado\n";
          //       var b= devtoolsOpen ? 1 : 0;
          //       if (b==1) {
                   
          //           window.location.href = '/llevateunbuensabor/antitrampa';
          //       }
                
          //   }, 1000);



	


/*
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

//var Base64={_keyStr:"eTkFHqausC34vmldkSrLkMwX13kqpDg1CYOd",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}


// Define the string
var string = 'Hello World!';

// Encode the String
var encodedString = Base64.encode(string);
console.log(encodedString); // Outputs: "SGVsbG8gV29ybGQh"

// Decode the String
var decodedString = Base64.decode(encodedString);
console.log(decodedString); // Outputs: "Hello World!"

https://www.codejobs.biz/es/blog/2014/02/18/tipos-de-cifrados-en-php-md5-sha1-y-salt

https://donnierock.com/2012/08/23/libreria-para-usar-md5-y-sha-1-en-javascript/
http://jquery-manual.blogspot.mx/2014/01/criptografia-en-javascript-cryptojs.html
http://pajhome.org.uk/crypt/md5/
http://cryptojs.altervista.org/api/

*/


});	

