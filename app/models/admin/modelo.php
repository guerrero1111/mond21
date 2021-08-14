<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

  class modelo extends CI_Model{
    
    private $key_hash;
    private $timezone;

    function __construct(){
      parent::__construct();
      $this->load->database("default");
      $this->key_hash    = $_SERVER['HASH_ENCRYPT'];
      $this->timezone    = 'UM1';

        //usuarios
          $this->usuarios             = $this->db->dbprefix('usuarios');
          $this->perfiles             = $this->db->dbprefix('perfiles');

          $this->configuraciones      = $this->db->dbprefix('catalogo_configuraciones');
          
          $this->proveedores          = $this->db->dbprefix('catalogo_empresas');
          $this->historico_acceso     = $this->db->dbprefix('historico_acceso');

          $this->catalogo_estados      = $this->db->dbprefix('catalogo_estados');
          $this->catalogo_estadosregistro      = $this->db->dbprefix('catalogo_estadosregistro');
          $this->participantes      = $this->db->dbprefix('participantes');
          $this->bitacora_participante      = $this->db->dbprefix('bitacora_participante');

          $this->registro_participantes         = $this->db->dbprefix('registro_participantes');
          $this->catalogo_litraje      = $this->db->dbprefix('catalogo_litraje');

          $this->catalogo_imagenes         = $this->db->dbprefix('catalogo_imagenes');
          $this->catalogo_premios      = $this->db->dbprefix('catalogo_premios');
          $this->catalogo_regiones      = $this->db->dbprefix('catalogo_regiones');



    }



public function buscador_participantes($data){          
          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];        
          $columa_order = $data['order'][0]['column'];
          $order = $data['order'][0]['dir'];
          $id_session = $this->session->userdata('id');
          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //         
          $this->db->select("p.id", FALSE);             
          $this->db->select("AES_DECRYPT(p.nombre, '{$this->key_hash}') AS nombre", FALSE);
          $this->db->select("AES_DECRYPT(p.Apellidos, '{$this->key_hash}') AS apellidos", FALSE);
          $this->db->select("AES_DECRYPT(p.celular, '{$this->key_hash}') AS celular", FALSE);
          $this->db->select("AES_DECRYPT(p.email, '{$this->key_hash}') AS email", FALSE);
          $this->db->select("AES_DECRYPT(p.contrasena, '{$this->key_hash}') AS contrasena", FALSE);
          $this->db->select("AES_DECRYPT(p.nick, '{$this->key_hash}') AS nick", FALSE);
          $this->db->select("( CASE WHEN p.fecha_pc = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(p.fecha_pc-21780),'%d-%m-%Y %H:%i:%s') END ) AS fecha_pc", FALSE); 
          $this->db->select("p.ciudad");
          $this->db->select("sum( (AES_DECRYPT(r.redes, '{$this->key_hash}')=1)*100) AS redes", FALSE); 


          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|1;', '')) ) /3) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))   )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL))  AS  cant1", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|2;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant2", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|3;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant3", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|4;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant4", FALSE); 
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|5;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant5", FALSE);  


          $this->db->select("r.fechainicial fechainicial, r.fechafinal fechafinal");

          $this->db->from($this->participantes.' as p'); 
          $this->db->join($this->registro_participantes.' as r', 'p.id = r.id_participante','left');


              $where = "(     
                    ((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AND                      
                    (
                        (  CONCAT( AES_DECRYPT(p.nombre,'{$this->key_hash}'),' ',AES_DECRYPT(p.Apellidos,'{$this->key_hash}') ) LIKE  '%".$cadena."%' )
                        OR ( AES_DECRYPT(p.email,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                        OR ( AES_DECRYPT(p.celular,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                         OR ( p.ciudad LIKE  '%".$cadena."%' )
                         OR ( AES_DECRYPT(p.contrasena,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                       )                
                 
              )" ;    
  
          $this->db->where($where);
    
          //ordenacion
         // $this->db->order_by($columna, $order); 

          //ordenacion
          $this->db->group_by('p.id'); 

          //paginacion
          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {
                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);

                  $retorno= " ";  
                  foreach ($result->result() as $row) {

                          $suma_total = 0;
                                    // $valor1=((int)$row->cant1)*$this->session->userdata('ip1');
                                    // $valor2=((int)$row->cant2)*$this->session->userdata('ip2');
                                    // $valor3=((int)$row->cant3)*$this->session->userdata('ip3');
                                    // $valor4=((int)$row->cant4)*$this->session->userdata('ip4');
                                    // $valor5=((int)$row->cant5)*$this->session->userdata('ip5'); 
                                    $valor1= ( ((int)$row->cant1)*$this->session->userdata('ip1'));
                                    $valor2= ( ((int)$row->cant2)*$this->session->userdata('ip2'));
                                    $valor3= ( ((int)$row->cant3)*$this->session->userdata('ip3'));
                                    $valor4= ( ((int)$row->cant4)*$this->session->userdata('ip4'));
                                    $valor5= ( ((int)$row->cant5)*$this->session->userdata('ip5')); 


                                    $suma_total = 
                                    $valor1+
                                    $valor2+
                                    $valor3+
                                    $valor4+
                                    $valor5+
                                    $row->redes;                        

                               $dato[]= array(
                                      0=>$row->id,
                                      1=>$row->nombre,
                                      2=>$row->apellidos,
                                      3=>$row->email,
                                      4=>$row->celular,
                                      5=>$row->email,
                                      6=>$row->contrasena,
                                      7=>$row->nick,
                                      8=>$row->ciudad,
                                      9=>$row->fecha_pc,
                                      10=>$suma_total
                                      
                                    );
                      }



                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => $registros_filtrados,  //intval( self::total_participantes() ), 
                        "recordsFiltered" =>   $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           

      }  




  public function buscador_detalle_participantes($data){

          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];

          
           $id_session = $this->session->userdata('id');

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          
          

          $this->db->select("p.id", FALSE);           
            $this->db->select("( CASE WHEN r.fecha_pc = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(r.fecha_pc-21780),'%d-%m-%Y %H:%i:%s') END ) AS fecha_pc", FALSE); 
          $this->db->select("( CASE WHEN r.compra = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(r.compra-21780),'%d-%m-%Y %H:%i:%s') END ) AS compra", FALSE);               
            
            
            //
            $this->db->select("r.responder", FALSE);      
            $this->db->select("AES_DECRYPT(r.tiempo_juego,'{$this->key_hash}') AS tiempo", FALSE);      
            $this->db->select("( (AES_DECRYPT(r.redes, '{$this->key_hash}')=1)*100) AS redes", FALSE); 


          $this->db->select("AES_DECRYPT(r.ticket, '{$this->key_hash}') AS ticket", FALSE);
          $this->db->select("( CASE WHEN r.responder = 1 THEN 'Si' ELSE 'No' END ) AS respuesta", FALSE);  
          $this->db->select("AES_DECRYPT(r.monto, '{$this->key_hash}') AS monto", FALSE);
          //$this->db->select("0 subtotal, 0 total_redes, 0 total", false);


                                               
           $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|1;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant1", FALSE);
          
          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|2;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant2", FALSE);
          
          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|3;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant3", FALSE);

          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|4;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant4", FALSE);

          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|5;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant5", FALSE);
          
           //$this->db->select("r.imgticket imgticket");                   
                                      

          $this->db->select("r.fechainicial fechainicial, r.fechafinal fechafinal");
          $this->db->from($this->participantes.' as p'); 
          //$this->db->join($this->catalogo_estados.' as e', 'e.id = p.id_estado');
          $this->db->join($this->registro_participantes.' as r', 'p.id = r.id_participante');
          //$this->db->where("p.id", '"'.$this->session->userdata('id_participante').'"',false);  

          
          
           

          
          //filtro de busqueda
       

      



          $where = "( (p.id='".$data['id']."') ) AND  
                  (
                         ( AES_DECRYPT(r.ticket,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                         OR ( AES_DECRYPT(r.monto,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                         
                         OR ( DATE_FORMAT(FROM_UNIXTIME(r.compra),'%d-%m-%Y') LIKE  '%".$cadena."%' ) 

                   )     


           ";      

   

          $this->db->where($where);
    
          //ordenacion
          //$this->db->order_by($columna, $order); 

          //paginacion
          $this->db->limit($largo,$inicio); 

          $basede = base_url();
          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);

                  $retorno= " ";  
                  foreach ($result->result() as $row) {


                         $suma_total = 0;
                        // $valor1=((int)$row->cant1)*$this->session->userdata('ip1');
                        // $valor2=((int)$row->cant2)*$this->session->userdata('ip2');
                        // $valor3=((int)$row->cant3)*$this->session->userdata('ip3');
                        // $valor4=((int)$row->cant4)*$this->session->userdata('ip4'); 

                         $valor1= ( ((int)$row->cant1) > 5 ? 5 : ((int)$row->cant1))*$this->session->userdata('ip1');
                        $valor2= ( ((int)$row->cant2) > 10 ? 10 : ((int)$row->cant2))*$this->session->userdata('ip2');
                        $valor3= ( ((int)$row->cant3) > 20 ? 20 : ((int)$row->cant3))*$this->session->userdata('ip3');
                        $valor4= ( ((int)$row->cant4) > 55 ? 55 : ((int)$row->cant4))*$this->session->userdata('ip4');
                        $valor5= ( ((int)$row->cant5) > 1 ? 1 : ((int)$row->cant5))*$this->session->userdata('ip5'); 


                        $suma_total = 
                        $valor1+
                        $valor2+
                        $valor3+
                        $valor4+
                        $valor5;
                        




                               $dato[]= array(
                                      0=>$row->id,
                                      1=>$row->fecha_pc,
                                      2=>$row->monto,
                                      3=>$row->ticket,
                                      //4=>$row->imgticket,    
                                      //5=>$row->tiempo, //
                                      5=>$suma_total, 
                                      6=>$row->redes, //
                                      7=>$row->fecha_pc,
                                    );
                      }





                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => $registros_filtrados,
                        "recordsFiltered" =>   $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  //cuando este vacio la tabla que envie este
                //http://www.datatables.net/forums/discussion/21311/empty-ajax-response-wont-render-in-datatables-1-10
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           

      }  
      

//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
// exportar
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////


 public function exportar_participantes($data){
          
          $cadena = addslashes($data['busqueda']);
          
          
          $id_session = $this->session->userdata('id');

           $this->db->select("p.id", FALSE);                
           

          $this->db->select("AES_DECRYPT(p.nombre, '{$this->key_hash}') AS nombre", FALSE);
          $this->db->select("AES_DECRYPT(p.celular, '{$this->key_hash}') AS celular", FALSE);
          $this->db->select("AES_DECRYPT(p.Apellidos, '{$this->key_hash}') AS apellidos", FALSE);
          $this->db->select("AES_DECRYPT(p.email, '{$this->key_hash}') AS email", FALSE);
          $this->db->select("AES_DECRYPT(p.contrasena, '{$this->key_hash}') AS contrasena", FALSE);
          $this->db->select("AES_DECRYPT(p.nick, '{$this->key_hash}') AS usuario", FALSE);
          $this->db->select("( CASE WHEN p.fecha_pc = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(p.fecha_pc-21780),'%d-%m-%Y %H:%i:%s') END ) AS fecha_registro", FALSE); 
          $this->db->select("p.ciudad AS ciudad", FALSE);

          $this->db->select("AES_DECRYPT(p.calle,'{$this->key_hash}') AS direccion", FALSE );
          $this->db->select("COUNT(DISTINCT r.id_participante, r.ticket) AS TOTAL_TICKETS", FALSE);
          //$this->db->select("COUNT(r.id_participante) as 'TOTAL_PARTICIPACIONES'");        //este es para el caso en q juegue n veces

          $this->db->select("sum( (AES_DECRYPT(r.redes, '{$this->key_hash}')=1)*100) AS redes_sociales", FALSE); 
          $this->db->select(" 0 total", false);

  

          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|1;', '')) ) /3) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))   )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL))  AS  cant1", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|2;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant2", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|3;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant3", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|4;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant4", FALSE); 
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|5;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant5", FALSE);  
    
          

          $this->db->select("r.fechainicial fechainicial, r.fechafinal fechafinal");
          
          $this->db->from($this->participantes.' as p'); 
          $this->db->join($this->registro_participantes.' as r', 'p.id = r.id_participante','left');


          
          
           $where = "(     
                    ((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AND                      
                    (
                        (  CONCAT( AES_DECRYPT(p.nombre,'{$this->key_hash}'),' ',AES_DECRYPT(p.Apellidos,'{$this->key_hash}') ) LIKE  '%".$cadena."%' )
                        OR ( AES_DECRYPT(p.email,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                        OR ( AES_DECRYPT(p.celular,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                         OR ( p.ciudad LIKE  '%".$cadena."%' )
                         OR ( AES_DECRYPT(p.contrasena,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                       )                
                 
              )" ;     
   

  
          $this->db->where($where);       

          
          $this->db->group_by('p.id'); 

          $result = $this->db->get();


              if ( $result->num_rows() > 0 ) {

                        foreach ($result->result() as $row) {

                                    $suma_total = 0;
                                    // $valor1=((int)$row->cant1)*$this->session->userdata('ip1');
                                    // $valor2=((int)$row->cant2)*$this->session->userdata('ip2');
                                    // $valor3=((int)$row->cant3)*$this->session->userdata('ip3');
                                    // $valor4=((int)$row->cant4)*$this->session->userdata('ip4'); 

                                    $valor1= ( ((int)$row->cant1)*$this->session->userdata('ip1'));
                                    $valor2= ( ((int)$row->cant2)*$this->session->userdata('ip2'));
                                    $valor3= ( ((int)$row->cant3)*$this->session->userdata('ip3'));
                                    $valor4= ( ((int)$row->cant4)*$this->session->userdata('ip4'));
                                    $valor5= ( ((int)$row->cant5)*$this->session->userdata('ip5'));

                                    $suma_total = 
                                    $valor1+
                                    $valor2+
                                    $valor3+
                                    $valor4+
                                    $valor5;

                                if (($row->fechainicial ) AND ($row->fechafinal)) {
                                        $row->total =$suma_total;      
                                    } else {
                                       $row->total =0;
                                    }

                          }      
                  return $result->result();
                    
              }  else {
                  return false; 

              }

              $result->free_result();           

      } 



 public function exportar_todo($data){
          
          $cadena = addslashes($data['busqueda']);
          

          
          $id_session = $this->session->userdata('id');

           $this->db->select("p.id", FALSE);           
         
          
          $this->db->select("AES_DECRYPT(p.nombre, '{$this->key_hash}') AS nombre", FALSE);
          $this->db->select("AES_DECRYPT(p.Apellidos, '{$this->key_hash}') AS apellidos", FALSE);
          $this->db->select("AES_DECRYPT(p.celular, '{$this->key_hash}') AS celular", FALSE);
          $this->db->select("AES_DECRYPT(p.email, '{$this->key_hash}') AS email", FALSE);
          $this->db->select("AES_DECRYPT(p.contrasena, '{$this->key_hash}') AS contrasena", FALSE);
          $this->db->select("AES_DECRYPT(p.nick, '{$this->key_hash}') AS usuario", FALSE);

          $this->db->select("( CASE WHEN r.fecha_pc = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(r.fecha_pc-21780),'%d-%m-%Y %H:%i:%s') END ) AS fecha_registro_participacion", FALSE); 
           $this->db->select("( CASE WHEN r.compra = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(r.compra),'%d-%m-%Y') END ) AS Fecha_de_compra", FALSE); 

          $this->db->select("p.ciudad AS ciudad", FALSE);

          $this->db->select("AES_DECRYPT(p.calle,'{$this->key_hash}') AS direccion", FALSE );
          $this->db->select("e.nombre Ciudad_compra");
          $this->db->select("AES_DECRYPT(r.ticket, '{$this->key_hash}') AS ticket", FALSE);
          $this->db->select("AES_DECRYPT(r.folio, '{$this->key_hash}') AS folio", FALSE);
 
          $this->db->select("AES_DECRYPT(r.monto, '{$this->key_hash}') AS monto", FALSE);

          $this->db->select("( (AES_DECRYPT(r.redes, '{$this->key_hash}')=1)*100) AS redes", FALSE); 



          //$this->db->select("concat('https://promosbenavides.com.mx', '/benavides/uploads/tickets/', r.imgticket) as  imagen", false);    
          
          $this->db->select("0 total", false);


         $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|1;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant1", FALSE);
          
          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|2;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant2", FALSE);
          
          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|3;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant3", FALSE);

          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|4;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant4", FALSE);

          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|5;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant5", FALSE);


          $this->db->select("r.fechainicial fechainicial, r.fechafinal fechafinal");
          $this->db->from($this->participantes.' as p'); 
          $this->db->join($this->registro_participantes.' as r', 'p.id = r.id_participante','left');
          $this->db->join($this->catalogo_estados.' as e', 'e.id = r.id_ciudad');

          
          
            $where = "(  
                

                    (
                        (  CONCAT( AES_DECRYPT(p.nombre,'{$this->key_hash}')) LIKE  '%".$cadena."%' )
                        OR ( AES_DECRYPT(p.email,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                        OR ( AES_DECRYPT(p.celular,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                         OR ( AES_DECRYPT(p.ciudad,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                         OR ( AES_DECRYPT(p.contrasena,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                       )                
                 
              )" ;    
   

  
          $this->db->where($where);       

          
          //$this->db->group_by('p.id'); 

          $result = $this->db->get();


              if ( $result->num_rows() > 0 ) {

                        foreach ($result->result() as $row) {


                          $suma_total = 0;
                          // $valor1=((int)$row->cant1)*$this->session->userdata('ip1');
                          // $valor2=((int)$row->cant2)*$this->session->userdata('ip2');
                          // $valor3=((int)$row->cant3)*$this->session->userdata('ip3');
                          // $valor4=((int)$row->cant4)*$this->session->userdata('ip4'); 
                          $valor1= ( ((int)$row->cant1) > 5 ? 5 : ((int)$row->cant1))*$this->session->userdata('ip1');
                        $valor2= ( ((int)$row->cant2) > 10 ? 10 : ((int)$row->cant2))*$this->session->userdata('ip2');
                        $valor3= ( ((int)$row->cant3) > 20 ? 20 : ((int)$row->cant3))*$this->session->userdata('ip3');
                        $valor4= ( ((int)$row->cant4) > 55 ? 55 : ((int)$row->cant4))*$this->session->userdata('ip4');
                        $valor5= ( ((int)$row->cant5) > 1 ? 1 : ((int)$row->cant5))*$this->session->userdata('ip5'); 

                          $suma_total = 
                          $valor1+
                          $valor2+
                          $valor3+
                          $valor4+
                          $valor5;

                             if (($row->fechainicial ) AND ($row->fechafinal)) {
                                        $row->total =$suma_total;      
                                    } else {
                                       $row->total =0;
                                    }
                                


                          }      
                  return $result->result();
                    
              }  else {
                  return false; 

              }

              $result->free_result();           

      } 


//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////




        public function listado_configuraciones(){

            $this->db->select('c.id, c.configuracion, c.valor, c.activo');
            $this->db->from($this->configuraciones.' as c');
            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }     




        public function listado_usuarios_correo( $id_perfil ){

            $this->db->select($this->usuarios.'.id, nombre,  apellidos');
            $this->db->select( "AES_DECRYPT( email,'{$this->key_hash}') AS email", FALSE );
            $this->db->from($this->usuarios);
            $this->db->join($this->perfiles, $this->usuarios.'.id_perfil = '.$this->perfiles.'.id_perfil');

           // $this->db->where($this->usuarios.'.especial !=', 2);  //quitar en caso de no super-administrador
            //$this->db->where($this->usuarios.'.id_perfil', $id_perfil+1);
            //$this->db->or_where($this->usuarios.'.id_perfil', 1);  //quitar en caso de no super-administrador
            


          $where = '(
                     (
                        ('.$this->usuarios.'.especial <> 2 ) AND ('.$this->usuarios.'.especial <> 3 ) AND ('.$this->usuarios.'.id_perfil='.($id_perfil+1).')
                     ) OR ('.$this->usuarios.'.id_perfil=1)
            )';   
            


          $this->db->where($where);






            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }     



    //login
    public function check_login($data){
      $this->db->select("AES_DECRYPT(email,'{$this->key_hash}') AS email", FALSE);      
      $this->db->select("AES_DECRYPT(contrasena,'{$this->key_hash}') AS contrasena", FALSE);      
      $this->db->select($this->usuarios.'.nombre,'.$this->usuarios.'.apellidos');     
      $this->db->select($this->usuarios.'.id,'.$this->perfiles.'.id_perfil,'.$this->perfiles.'.perfil,'.$this->perfiles.'.operacion');
            $this->db->select($this->usuarios.'.especial');         

                
      $this->db->from($this->usuarios);
      $this->db->join($this->perfiles, $this->usuarios.'.id_perfil = '.$this->perfiles.'.id_perfil');
      $this->db->where('contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE);
      $this->db->where('email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);


      $login = $this->db->get();

      if ($login->num_rows() > 0)
        return $login->result();
      else 
        return FALSE;
      $login->free_result();
    }

        //anadir al historico de acceso
        public function anadir_historico_acceso($data){

            $timestamp = time();
            $ip_address = $this->input->ip_address();
            $user_agent= $this->input->user_agent();

            $this->db->set( 'email', "AES_ENCRYPT('{$data->email}','{$this->key_hash}')", FALSE );
            $this->db->set( 'id_perfil', $data->id_perfil);

            $this->db->set( 'id_usuario', $data->id);
            $this->db->set( 'fecha',  gmt_to_local( $timestamp, 'UM1', TRUE) );
            $this->db->set( 'ip_address',  $ip_address, TRUE );
            $this->db->set( 'user_agent',  $user_agent, TRUE );
            

            $this->db->insert($this->historico_acceso );

            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();

        }

       public function total_acceso($limit=-1, $offset=-1){

            $fecha = date_create(date('Y-m-j'));
            date_add($fecha, date_interval_create_from_date_string('-1 month'));
            $data['fecha_inicial'] = date_format($fecha, 'm');
            $data['fecha_final'] = $data['fecha_final'] = (date('m'));


            $this->db->from($this->historico_acceso.' As h');
            $this->db->join($this->usuarios.' As u' , 'u.id = h.id_usuario','LEFT');
            $this->db->join($this->perfiles.' As p', 'u.id_perfil = p.id_perfil','LEFT');

            if  (($data['fecha_inicial']) and ($data['fecha_final'])) {
                $this->db->where( "( CASE WHEN h.fecha = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(h.fecha),'%m') END ) = ", $data['fecha_inicial'] );
                $this->db->or_where( "( CASE WHEN h.fecha = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(h.fecha),'%m') END ) = ", $data['fecha_final'] );
            } 

              

           $unidades = $this->db->get();            
           return $unidades->num_rows();
        }

       


    
    //Recuperar contraseña    
      public function recuperar_contrasena($data){
      $this->db->select("AES_DECRYPT(u.email,'{$this->key_hash}') AS email", FALSE);            
      $this->db->select('u.nombre,u.apellidos');
      $this->db->select("AES_DECRYPT(u.telefono,'{$this->key_hash}') AS telefono", FALSE);      
      $this->db->select("AES_DECRYPT(u.contrasena,'{$this->key_hash}') AS contrasena", FALSE);
      $this->db->from($this->usuarios.' as u');
      $this->db->where('u.email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);
      $login = $this->db->get();
      if ($login->num_rows() > 0)
        return $login->result();
      else 
        return FALSE;
      $login->free_result();    
      } 

  
  
   
        public function coger_usuarios($limit=-1, $offset=-1, $uid ){

            $especial=$this->session->userdata('especial');

        $this->db->select($this->usuarios.'.id, nombre,  apellidos');
            

            $this->db->select( "AES_DECRYPT( email,'{$this->key_hash}') AS email", FALSE );
            $this->db->select( "AES_DECRYPT( telefono,'{$this->key_hash}') AS telefono", FALSE );
      $this->db->select($this->perfiles.'.id_perfil,'.$this->perfiles.'.perfil,'.$this->perfiles.'.operacion');
      $this->db->from($this->usuarios);
      $this->db->join($this->perfiles, $this->usuarios.'.id_perfil = '.$this->perfiles.'.id_perfil');
      $this->db->where( $this->usuarios.'.id !=', $uid );
            if ($especial==3) {
                $this->db->where( $this->usuarios.'.especial =3' );
            }


            if ($limit!=-1) {
                $this->db->limit($limit, $offset); 
            } 
             

      $result = $this->db->get();
      
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        

        //eliminar usuarios
        public function borrar_usuario( $uid ){
            $this->db->delete( $this->usuarios, array( 'id' => $uid ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }



        //editar  
        public function coger_catalogo_usuario( $uid ){
            $this->db->select('id, nombre, apellidos, id_perfil');
            $this->db->select( "AES_DECRYPT( email,'{$this->key_hash}') AS email", FALSE );
            $this->db->select( "AES_DECRYPT( telefono,'{$this->key_hash}') AS telefono", FALSE );
            $this->db->select( "AES_DECRYPT( contrasena,'{$this->key_hash}') AS contrasena", FALSE );
            $this->db->where('id', $uid);
            $result = $this->db->get($this->usuarios );
            if ($result->num_rows() > 0)
              return $result->row();
            else 
              return FALSE;
            $result->free_result();
        }  


    public function check_correo_existente($data){
      $this->db->select("AES_DECRYPT(email,'{$this->key_hash}') AS email", FALSE);      
      $this->db->from($this->usuarios);
      $this->db->where('email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);
      $login = $this->db->get();
      if ($login->num_rows() > 0)
        return FALSE;
      else
        return TRUE;
      $login->free_result();
    }

    public function anadir_usuario( $data ){
            $timestamp = time();

            $id_session = $this->session->userdata('id');
            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );
            $this->db->set( 'id_usuario',  $id_session );

            $this->db->set( 'id', "UUID()", FALSE);
      $this->db->set( 'nombre', $data['nombre'] );
            $this->db->set( 'apellidos', $data['apellidos'] );
            $this->db->set( 'email', "AES_ENCRYPT('{$data['email']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'telefono', "AES_ENCRYPT('{$data['telefono']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'id_perfil', $data['id_perfil']);
            

            $this->db->set( 'contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'creacion',  gmt_to_local( $timestamp, $this->timezone, TRUE) );
            $this->db->insert($this->usuarios );

            if ($this->db->affected_rows() > 0){
                return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
            
        }

    public function check_usuario_existente($data){
      
      $this->db->select("AES_DECRYPT(email,'{$this->key_hash}') AS email", FALSE);      
      $this->db->from($this->usuarios);
      $this->db->where('email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);
      $this->db->where('id !=',$data['id']);
      $login = $this->db->get();
      if ($login->num_rows() > 0)
        return FALSE;
      else
        return TRUE;
      $login->free_result();
    }        


        public function edicion_usuario( $data ){

            $timestamp = time();

            $id_session = $this->session->userdata('id');
            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );
            $this->db->set( 'id_usuario',  $id_session );

      $this->db->set( 'nombre', $data['nombre'] );
            $this->db->set( 'apellidos', $data['apellidos'] );
            $this->db->set( 'email', "AES_ENCRYPT('{$data['email']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'telefono', "AES_ENCRYPT('{$data['telefono']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'id_perfil', $data['id_perfil']);
            
            
            $this->db->set( 'contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE );
            $this->db->where('id', $data['id'] );
            $this->db->update($this->usuarios );
            if ($this->db->affected_rows() > 0) {
        return TRUE;
      }  else
         return FALSE;
        }   

//----------------**************catalogos-------------------************------------------
        public function coger_catalogo_perfiles(){
            $this->db->select( 'id_perfil, perfil, operacion' );
            $perfiles = $this->db->get($this->perfiles );
            if ($perfiles->num_rows() > 0 )
               return $perfiles->result();
            else
               return FALSE;
            $perfiles->free_result();
        }       

            


      public function buscador_usuarios($data){
          
          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];


          switch ($columa_order) {
                   case '0':
                        $columna = 'u.nombre';
                     break;
                   case '1':
                        $columna = 'p.perfil';
                     break;
                   case '2':
                        $columna = 'email';
                     break;
                     
                   
                   default:
                        $columna = 'u.nombre';
                     break;
                 }                 

                                      

          //$id_session = $this->db->escape($this->session->userdata('id'));
           $id_session = $this->session->userdata('id');

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          
          

          $this->db->select('u.id, u.nombre, u.apellidos, u.id_perfil');
          $this->db->select( "AES_DECRYPT( u.email,'{$this->key_hash}') AS email", FALSE );
          $this->db->select( "AES_DECRYPT( u.telefono,'{$this->key_hash}') AS telefono", FALSE );
          $this->db->select( "AES_DECRYPT( u.contrasena,'{$this->key_hash}') AS contrasena", FALSE );
          $this->db->select('p.perfil');

          $this->db->from($this->usuarios.' as u');
          $this->db->join($this->perfiles.' as p', 'u.id_perfil = p.id_perfil');
          $this->db->where( 'u.id !=', $id_session);
          
          //filtro de busqueda
       
          $where = '(

                      (
                        ( u.nombre LIKE  "%'.$cadena.'%" ) OR (u.apellidos LIKE  "%'.$cadena.'%") OR (p.perfil LIKE  "%'.$cadena.'%") 
                        OR (  AES_DECRYPT( u.email,"{$this->key_hash}")  LIKE  "%'.$cadena.'%") 
                        
                       )
            )';   



  
          $this->db->where($where);
    
          //ordenacion
          $this->db->order_by($columna, $order); 

          //paginacion
          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);

                  $retorno= " ";  
                  foreach ($result->result() as $row) {
                               $dato[]= array(
                                      0=>$row->id,
                                      1=>$row->perfil,
                                      2=>$row->nombre,
                                      3=>$row->apellidos,
                                      4=>$row->email,
                                      5=>$row->telefono,
                                      
                                      
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_usuarios() ), 
                        "recordsFiltered" =>   $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  //cuando este vacio la tabla que envie este
                //http://www.datatables.net/forums/discussion/21311/empty-ajax-response-wont-render-in-datatables-1-10
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           

      }  
      



        public function total_usuarios(){
            $id_session = $this->session->userdata('id');

            $especial=$this->session->userdata('especial');

            $this->db->from($this->usuarios.' as u');
            $this->db->join($this->perfiles.' as p', 'u.id_perfil = p.id_perfil');

            $this->db->where( 'u.id !=', $id_session );
                           
            
           $total = $this->db->get();            
           return $total->num_rows();
            
        }       






      public function historico_acceso($data){
          
          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];


          switch ($columa_order) {
                  case '0':
                        $columna = 'u.nombre';
                     break;
                  case '1':
                        $columna = 'p.perfil';
                     break;
                  case '2':
                        $columna = 'h.email';
                     break;
                  case '3':
                        $columna = 'h.fecha';
                     break;  
                  case '4':
                        $columna = 'h.ip_address';
                     break;  
                  case '5':
                        $columna = 'h.user_agent';
                     break;                      
                   
                   default:
                        $columna = 'u.nombre';
                     break;
                 }                 

                                      

          //$id_session = $this->db->escape($this->session->userdata('id'));
           $id_session = $this->session->userdata('id');

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          




            $this->db->select("AES_DECRYPT(h.email,'{$this->key_hash}') AS email", FALSE);            
            $this->db->select('p.id_perfil, p.perfil, p.operacion');
            $this->db->select('u.nombre,u.apellidos');         
            $this->db->select('h.ip_address, h.user_agent, h.id_usuario');
            $this->db->select("( CASE WHEN h.fecha = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(h.fecha),'%d-%m-%Y %H:%i:%s') END ) AS fecha", FALSE);  

            $this->db->from($this->historico_acceso.' As h');
            $this->db->join($this->usuarios.' As u' , 'u.id = h.id_usuario');
            $this->db->join($this->perfiles.' As p', 'u.id_perfil = p.id_perfil','LEFT');
          
          //filtro de busqueda
       
       
          $where = '(

                      (
                        ( u.nombre LIKE  "%'.$cadena.'%" ) OR (u.apellidos LIKE  "%'.$cadena.'%") OR (p.perfil LIKE  "%'.$cadena.'%") 
                        OR (  AES_DECRYPT( h.email,"{$this->key_hash}")  LIKE  "%'.$cadena.'%") 
                        OR (  DATE_FORMAT(FROM_UNIXTIME(h.fecha),"%d-%m-%Y %H:%i:%s")     LIKE  "%'.$cadena.'%") 
                        OR (h.ip_address LIKE  "%'.$cadena.'%")
                        OR (h.user_agent LIKE  "%'.$cadena.'%")
                       )
            )';   


        

  
  
          $this->db->where($where);
      

          //ordenacion
         $this->db->order_by($columna, $order); 

          //paginacion
          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

         

              if ( $result->num_rows() > 0 ) {
                
                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);
                    

                  $retorno= " ";  
                  foreach ($result->result() as $row) {
                               $dato[]= array(
                                     
                                      0=>$row->nombre,
                                      1=>$row->apellidos,
                                      2=>$row->perfil,
                                      3=>$row->email,
                                      4=>$row->fecha,
                                      5=>$row->ip_address,
                                      6=>$row->user_agent,
                                      
                                      
                                      
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_historico_acceso() ), 
                        "recordsFiltered" =>  $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  //cuando este vacio la tabla que envie este
                //http://www.datatables.net/forums/discussion/21311/empty-ajax-response-wont-render-in-datatables-1-10
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           

      }  
      



        public function total_historico_acceso(){
            $id_session = $this->session->userdata('id');

            $especial=$this->session->userdata('especial');

            $this->db->from($this->historico_acceso.' As h');
            $this->db->join($this->usuarios.' As u' , 'u.id = h.id_usuario');
            $this->db->join($this->perfiles.' As p', 'u.id_perfil = p.id_perfil','LEFT');
          

            //$this->db->where( 'u.id !=', $id_session );
                           
            
           $total = $this->db->get();            
           return $total->num_rows();
            
        }       

     



public function buscador_record_pana($data){
          $this->db->select("p.fecha_pc");   
          $this->db->select("AES_DECRYPT(r.ticket, '{$this->key_hash}') AS ticket", FALSE);
          $this->db->select("AES_DECRYPT(r.folio, '{$this->key_hash}') AS folio", FALSE);
          $this->db->select("r.responder responder", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|1;', '')) ) /3) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))   )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL))  AS  cant1", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|2;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant2", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|3;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant3", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|4;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant4", FALSE); 
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|5;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant5", FALSE);  
          $this->db->select("sum( (AES_DECRYPT(r.redes, '{$this->key_hash}')=1)*100) AS total_redes", FALSE); 
          $this->db->from($this->participantes.' as p');
          $this->db->join($this->registro_participantes.' as r', 'p.id = r.id_participante');
          $this->db->where("p.id", '"'.$this->session->userdata('id_participante').'"',false);  
          $this->db->group_by("p.id, r.ticket, r.folio");
          $result = $this->db->get();
          if ( $result->num_rows() > 0 )
            return $result->result();
          else
            return False;
          $result->free_result();
}




////////////////regiones

      public function get_catalogo_regiones(){
            $this->db->select( 'id id_region, nombre region' );
            $regiones = $this->db->get($this->catalogo_regiones );
            if ($regiones->num_rows() > 0 )
               return $regiones->result();
            else
               return FALSE;
            $regiones->free_result();
        }   

public function buscador_regiones($data){   

// var_dump($data['id_region']);

          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];        
          $columa_order = $data['order'][0]['column'];
          $order = $data['order'][0]['dir'];
          $id_session = $this->session->userdata('id');
          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //         
          $this->db->select("p.id", FALSE);             
          $this->db->select("AES_DECRYPT(p.nombre, '{$this->key_hash}') AS nombre", FALSE);
          $this->db->select("AES_DECRYPT(p.Apellidos, '{$this->key_hash}') AS apellidos", FALSE);
          $this->db->select("AES_DECRYPT(p.celular, '{$this->key_hash}') AS celular", FALSE);
          $this->db->select("AES_DECRYPT(p.email, '{$this->key_hash}') AS email", FALSE);
          $this->db->select("AES_DECRYPT(p.contrasena, '{$this->key_hash}') AS contrasena", FALSE);
          $this->db->select("AES_DECRYPT(p.nick, '{$this->key_hash}') AS nick", FALSE);
          //$this->db->select("p.fecha_mac,p.fecha_pc");
          $this->db->select("( CASE WHEN p.fecha_pc = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(p.fecha_pc-21780),'%d-%m-%Y %H:%i:%s') END ) AS fecha_pc", FALSE); 
          
          //$this->db->select("AES_DECRYPT(p.ciudad, '{$this->key_hash}') AS ciudad", FALSE);
          $this->db->select("p.ciudad ciudad", FALSE);

          $this->db->select("sum( (AES_DECRYPT(r.redes, '{$this->key_hash}')=1)*100) AS redes", FALSE); 
          $this->db->select("e.nombre estado");

          $this->db->select("et.region, et.id_region");

           $this->db->select("GROUP_CONCAT( DISTINCT (case when ((et.nombre <>'')) then 

            CONCAT ( et.nombre,'<br/>')

            else null end)   separator ' ' ) AS estado_ticket", FALSE);



          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|1;', '')) ) /3) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))   )  AS  cant1", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|2;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant2", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|3;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant3", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|4;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant4", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|5;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant5", FALSE);   
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|6;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant6", FALSE);
          
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|7;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant7", FALSE);
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|8;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant8", FALSE);
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|9;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant9", FALSE);
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|10;', '')) ) /4 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant10", FALSE);
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|11;', '')) ) /4 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant11", FALSE);

          $this->db->select("sum( (AES_DECRYPT(r.redes, '{$this->key_hash}')=1)*100) AS total_redes", FALSE); 


          $this->db->from($this->participantes.' as p'); 
          $this->db->join($this->catalogo_estadosregistro.' as e', 'e.id = p.id_estado','left');
          $this->db->join($this->registro_participantes.' as r', 'p.id = r.id_participante');
          $this->db->join($this->catalogo_estados.' as et', "et.id = r.id_ciudad");

               $region =   ($data['id_region']!=0) ? " (et.id_region=".$data['id_region']." ) AND " : " ";
               $where = "(     
                      ".$region."
                      

                    (
                        (  CONCAT( AES_DECRYPT(p.nombre,'{$this->key_hash}'),' ',AES_DECRYPT(p.Apellidos,'{$this->key_hash}') ) LIKE  '%".$cadena."%' )
                        OR ( AES_DECRYPT(p.email,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                        OR ( AES_DECRYPT(p.celular,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                         OR ( AES_DECRYPT(p.ciudad,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                         OR ( AES_DECRYPT(p.contrasena,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                       )                
                 
              )" ;    
  
          $this->db->where($where);
    
          //ordenacion
         // $this->db->order_by($columna, $order); 

          //ordenacion
          $this->db->group_by('p.id, et.id_region'); 

          //paginacion
          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {
                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);

                  $retorno= " ";  
                  foreach ($result->result() as $row) {
                        $suma_total = 0;
                        $valor1=((int)$row->cant1)*$this->session->userdata('ip1');
                        $valor2=((int)$row->cant2)*$this->session->userdata('ip2');
                        $valor3=((int)$row->cant3)*$this->session->userdata('ip3');
                        $valor4=((int)$row->cant4)*$this->session->userdata('ip4'); 
                        $valor5=((int)$row->cant5)*$this->session->userdata('ip5');    
                        $valor6=((int)$row->cant6)*$this->session->userdata('ip6');     
                        $valor7=((int)$row->cant7)*$this->session->userdata('ip7');     
                        $valor8=((int)$row->cant8)*$this->session->userdata('ip8');     
                        $valor9=((int)$row->cant9)*$this->session->userdata('ip9');
                        $valor10=((int)$row->cant10)*$this->session->userdata('ip10');   
                        $valor11=((int)$row->cant11)*$this->session->userdata('ip11');   

                        $suma_total = 
                        $valor1+
                        $valor2+
                        $valor3+
                        $valor4+
                        $valor5+
                        $valor6+
                        $valor7+
                        $valor8+
                        $valor9+
                        $valor10+
                        $valor11+
                        $row->total_redes
                        ;                        
                        

                               $dato[]= array(
                                      0=>$row->id,
                                      1=>$row->nombre,
                                      2=>$row->apellidos,
                                      3=>$row->email,
                                      4=>$row->celular,
                                      5=>$row->email,
                                      6=>$row->contrasena,
                                      7=>$row->nick,
                                      8=>$row->ciudad,
                                      9=>$row->estado,
                                      10=>$row->fecha_pc,
                                      11=>$row->estado_ticket,
                                      12=>$row->region,
                                      13=>$row->id_region,
                                      14=> $suma_total
                                      //11=>$suma_total,
                                    );
                      }



                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => $registros_filtrados,  //intval( self::total_participantes() ), 
                        "recordsFiltered" =>   $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           

      }  







 








public function buscador_listado_completo($data){
          
          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];


          /*switch ($columa_order) {
                      case '0':
                        $columna = 'fecha_pc_compra';
                     break;
                    case '1':
                        $columna = 'TICKETS_REGISTRADOS';
                     break;

                    case '2':
                        $columna = 'PUNTOS_OBTENIDOS_COMPRA';
                     break;

                    case '3':
                        $columna = 'PUNTOS_OBTENIDOS_JUEGO';
                     break;

                    case '4':
                        $columna = 'TOTAL_PUNTOS_FACEBOOK';
                     break;

                    case '5':
                        $columna = 'TOTAL_PUNTOS_ACUMULADOS';
                     break;

                       
                   case '6':
                        $columna = 'nomb';
                     break;
                  case '7':
                        $columna = 'nick';  
                     break;
                  case '8':
                        $columna = 'contrasena';  
                     break;               

                  case '9':
                        $columna = 'ticket';  //puntos
                     break;                     
                  case '10':
                        $columna = 'monto';  //puntos
                     break; 
                  case '11':
                        $columna = 'email';  
                     break;                     
                  case '12':
                        $columna = 'telefono';
                     break;      
                     case '13':
                        $columna = 'celular';
                     break;                 
                  case '14':
                        $columna = 'estado';  
                     break;                                                                                   
                   case '15':
                        $columna = 'calle';  
                     break; 
                     case '16':
                        $columna = 'ticket';  //puntos
                     break;
                     case '17':
                        $columna = 'numero';  //puntos
                     break;
                     case '18':
                        $columna = 'colonia';  //puntos
                     break;
                     case '19':
                        $columna = 'municipio';  //puntos
                     break;
                     case '20':
                        $columna = 'cp';  //puntos
                     break;
                     case '21':
                        $columna = 'ciudad';  //puntos
                     break;
                     case '22':
                        $columna = 'monto';  //puntos
                     break;
                   default:
                        $columna = 'fecha_pc_compra'; //por defecto los ṕuntos
                        $order = 'desc';
                     break;
                 }             

        */

                                      

          //$id_session = $this->db->escape($this->session->userdata('id'));
           $id_session = $this->session->userdata('id');

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          
          

          $this->db->select("p.id", FALSE);           
         

          $this->db->select("AES_DECRYPT(p.nombre, '{$this->key_hash}') AS nombre", FALSE);
          $this->db->select("AES_DECRYPT(Apellidos, '{$this->key_hash}') AS apellidos", FALSE);
          $this->db->select("( CASE WHEN p.fecha_nac = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(p.fecha_nac),'%d-%m-%Y') END ) AS fecha_nac", FALSE);  
          $this->db->select("AES_DECRYPT(p.ciudad, '{$this->key_hash}') AS ciudad", FALSE);
          $this->db->select("AES_DECRYPT(celular, '{$this->key_hash}') AS celular", FALSE);
          $this->db->select("AES_DECRYPT(email, '{$this->key_hash}') AS email", FALSE);
          $this->db->select("AES_DECRYPT(contrasena, '{$this->key_hash}') AS contrasena", FALSE);
          $this->db->select("( CASE WHEN p.fecha_pc = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(p.fecha_pc-21780),'%d-%m-%Y %H:%i:%s') END ) AS fecha_pc_compra", FALSE); 


          
          $this->db->from($this->participantes.' as p'); 
        //  $this->db->join($this->catalogo_estados.' as c', 'c.id = p.id_estado');
          
          
          
          //filtro de busqueda
            $where = "(

                      (
                        (  CONCAT( AES_DECRYPT(p.nombre,'{$this->key_hash}'),' ',AES_DECRYPT(p.apellidos,'{$this->key_hash}') ) LIKE  '%".$cadena."%' )
                        OR ( AES_DECRYPT(p.email,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                        OR ( AES_DECRYPT(p.telefono,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                        OR ( AES_DECRYPT(p.celular,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                         OR ( AES_DECRYPT(p.calle,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                         OR ( p.numero LIKE  '%".$cadena."%' ) 
                         OR ( AES_DECRYPT(p.colonia,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                         OR ( AES_DECRYPT(p.municipio,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                         OR ( AES_DECRYPT(p.cp,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                         OR ( AES_DECRYPT(p.ciudad,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                        OR ( DATE_FORMAT(FROM_UNIXTIME(p.fecha_pc),'%d-%m-%Y %H:%i:%s') LIKE  '%".$cadena."%' ) 
                       
                        
                        OR ( r.monto LIKE  '%".$cadena."%' ) 
                        OR ( AES_DECRYPT(r.ticket,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                        
                        
                        OR ( CONCAT('@',AES_DECRYPT(p.nick,'{$this->key_hash}') )LIKE  '%".$cadena."%' ) 

                        OR ( AES_DECRYPT(p.contrasena,'{$this->key_hash}') LIKE  '%".$cadena."%' )

                        
                        
                       )
            )";         

             /*$where = "(  ( AES_DECRYPT(p.tarjeta,'{$this->key_hash}') <> '' ) 
                  AND ( AES_DECRYPT(p.juego,'{$this->key_hash}') <> '' ) 
              )" ;    */

  
          //$this->db->where($where);
    
          //ordenacion
         // $this->db->order_by($columna, $order); 


          //ordenacion
          $this->db->group_by('p.id'); 

          //paginacion
          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);

                  $retorno= " ";  
                  foreach ($result->result() as $row) {

                          
                               $dato[]= array(
                                      0=>$row->id,
                                      1=>$row->nombre,
                                      2=>$row->apellidos,
                                      3=>$row->fecha_nac,
                                      4=>$row->ciudad,
                                      5=>$row->celular,
                                      6=>$row->email,
                                      7=>$row->contrasena,
                                      8=>$row->fecha_mac,
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => $registros_filtrados,  //intval( self::total_participantes() ), 
                        "recordsFiltered" =>   $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  //cuando este vacio la tabla que envie este
                //http://www.datatables.net/forums/discussion/21311/empty-ajax-response-wont-render-in-datatables-1-10
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           

      }  



//detalles del participantes

          public function listado_imagenes(){

            $this->db->select('c.id, c.nombre, c.valor, c.activo, c.puntos');
            $this->db->from($this->catalogo_imagenes.' as c');
            $this->db->where('c.activo',0);
            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }   

    






        //historico participantes

 public function bitacora_participantes($data){
          
          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];



              switch ($columa_order) {
                   case '0':
                        $columna = 'nomb';
                     break;
                   case '1':
                        $columna = 'nick';
                     break;                     
                  case '2':
                        $columna = 'correo';  
                     break;                     
                  case '3':
                        $columna = 'fecha';
                     break;                     
                  
                  case '4':
                        $columna = 'ip_address';
                     break;  
                  case '5':
                        $columna = 'user_agent';
                     break;                                                                                                       
                   
                   default:
                        $columna = 'fecha'; //por defecto los ṕuntos
                     break;
              }        









                                      

          //$id_session = $this->db->escape($this->session->userdata('id'));
           $id_session = $this->session->userdata('id');

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          



            $this->db->select("h.id", FALSE);            
            $this->db->select("AES_DECRYPT(h.email,'{$this->key_hash}') AS correo", FALSE);            
            $this->db->select("AES_DECRYPT(u.nombre,'{$this->key_hash}') AS nomb", FALSE);      
            $this->db->select("AES_DECRYPT(u.apellidos,'{$this->key_hash}') AS apellidos", FALSE);      
            $this->db->select("AES_DECRYPT(u.nick,'{$this->key_hash}') AS nick", FALSE);      
            $this->db->select('h.ip_address, h.user_agent, h.id_usuario');
            $this->db->select("( CASE WHEN h.fecha_pc = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(h.fecha_pc),'%d-%m-%Y %H:%i:%s') END ) AS fecha", FALSE);  

            $this->db->from($this->bitacora_participante.' As h');
            $this->db->join($this->participantes.' As u' , 'u.id = h.id_usuario');
          
          //filtro de busqueda
       
       

        $where = "(

                      (
                        (  CONCAT( AES_DECRYPT(u.nombre,'{$this->key_hash}'),' ',AES_DECRYPT(u.apellidos,'{$this->key_hash}') ) LIKE  '%".$cadena."%' )
                        OR ( AES_DECRYPT(h.email,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                        OR ( DATE_FORMAT(FROM_UNIXTIME(h.fecha_pc),'%d-%m-%Y %H:%i:%s') LIKE  '%".$cadena."%' ) 
                        OR (h.ip_address LIKE  '%".$cadena."%' ) 
                        OR (h.user_agent LIKE  '%".$cadena."%' ) 
                        OR ( CONCAT('@',AES_DECRYPT(u.nick,'{$this->key_hash}') )LIKE  '%".$cadena."%' ) 
                        
                       )
            )";   

       
  
          $this->db->where($where);
          
      

          //ordenacion
         $this->db->order_by($columna, $order); 

          //paginacion
          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

         

              if ( $result->num_rows() > 0 ) {
                
                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);
                    

                  $retorno= " ";  
                  foreach ($result->result() as $row) {
                               $dato[]= array(
                                     
                                      0=>$row->id,
                                      1=>$row->nomb,
                                      2=>$row->apellidos,
                                      3=>$row->nick,
                                      4=>$row->correo,
                                      5=>$row->fecha,
                                      6=>$row->ip_address,
                                      7=>$row->user_agent,
                                      
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_bitacora_participantes() ), 
                        "recordsFiltered" =>  $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  //cuando este vacio la tabla que envie este
                //http://www.datatables.net/forums/discussion/21311/empty-ajax-response-wont-render-in-datatables-1-10
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           

      }  
      



        public function total_bitacora_participantes(){
            $this->db->from($this->bitacora_participante.' As h');
            $this->db->join($this->participantes.' As u' , 'u.id = h.id_usuario');
            
           $total = $this->db->get();            
           return $total->num_rows();
            
        }               






public function exportar_regiones($data){   



          
          $cadena = addslashes($data['busqueda']);
                  
          $this->db->select("p.id", FALSE);             
          $this->db->select("AES_DECRYPT(p.nombre, '{$this->key_hash}') AS nombre", FALSE);
          $this->db->select("AES_DECRYPT(p.Apellidos, '{$this->key_hash}') AS apellidos", FALSE);
          $this->db->select("AES_DECRYPT(p.celular, '{$this->key_hash}') AS celular", FALSE);
          $this->db->select("AES_DECRYPT(p.email, '{$this->key_hash}') AS email", FALSE);
          $this->db->select("AES_DECRYPT(p.contrasena, '{$this->key_hash}') AS contrasena", FALSE);
          $this->db->select("AES_DECRYPT(p.nick, '{$this->key_hash}') AS nick", FALSE);
          //$this->db->select("p.fecha_mac,p.fecha_pc");
          $this->db->select("( CASE WHEN p.fecha_pc = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(p.fecha_pc-21780),'%d-%m-%Y %H:%i:%s') END ) AS fecha_pc", FALSE); 
          
          
          $this->db->select("p.ciudad ciudad", FALSE);
          $this->db->select("e.nombre estado");

          $this->db->select("sum( (AES_DECRYPT(r.redes, '{$this->key_hash}')=1)*100) AS redes", FALSE); 

          $this->db->select("et.region");

           $this->db->select("GROUP_CONCAT( DISTINCT (case when ((et.nombre <>'')) then 

            CONCAT ( et.nombre,'<br/>')

            else null end)   separator ' ' ) AS estado_ticket", FALSE);



          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|1;', '')) ) /3) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))   )  AS  cant1", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|2;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant2", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|3;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant3", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|4;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant4", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|5;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant5", FALSE);   
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|6;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant6", FALSE);
          
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|7;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant7", FALSE);
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|8;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant8", FALSE);
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|9;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant9", FALSE);
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|10;', '')) ) /4 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant10", FALSE);
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|11;', '')) ) /4 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant11", FALSE);

          $this->db->select("sum( (AES_DECRYPT(r.redes, '{$this->key_hash}')=1)*100) AS total_redes", FALSE); 


          $this->db->from($this->participantes.' as p'); 
          $this->db->join($this->catalogo_estadosregistro.' as e', 'e.id = p.id_estado','left');
          $this->db->join($this->registro_participantes.' as r', 'p.id = r.id_participante');
          $this->db->join($this->catalogo_estados.' as et', "et.id = r.id_ciudad");

               $region =   ($data['id_region']!=0) ? " (et.id_region=".$data['id_region']." ) AND " : " ";
               $where = "(     
                      ".$region."
                      

                    (
                        (  CONCAT( AES_DECRYPT(p.nombre,'{$this->key_hash}'),' ',AES_DECRYPT(p.Apellidos,'{$this->key_hash}') ) LIKE  '%".$cadena."%' )
                        OR ( AES_DECRYPT(p.email,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                        OR ( AES_DECRYPT(p.celular,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                         OR ( AES_DECRYPT(p.ciudad,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                         OR ( AES_DECRYPT(p.contrasena,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                       )                
                 
              )" ;    
  
          $this->db->where($where);
    
          //ordenacion
         // $this->db->order_by($columna, $order); 

          //ordenacion
          $this->db->group_by('p.id, et.id_region'); 

          //paginacion
          //$this->db->limit($largo,$inicio); 


          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {
                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);

                  $retorno= " ";  
                  foreach ($result->result() as $row) {
                        $suma_total = 0;
                        $valor1=((int)$row->cant1)*$this->session->userdata('ip1');
                        $valor2=((int)$row->cant2)*$this->session->userdata('ip2');
                        $valor3=((int)$row->cant3)*$this->session->userdata('ip3');
                        $valor4=((int)$row->cant4)*$this->session->userdata('ip4'); 
                        $valor5=((int)$row->cant5)*$this->session->userdata('ip5');    
                        $valor6=((int)$row->cant6)*$this->session->userdata('ip6');     
                        $valor7=((int)$row->cant7)*$this->session->userdata('ip7');     
                        $valor8=((int)$row->cant8)*$this->session->userdata('ip8');     
                        $valor9=((int)$row->cant9)*$this->session->userdata('ip9');
                        $valor10=((int)$row->cant10)*$this->session->userdata('ip10');   
                        $valor11=((int)$row->cant11)*$this->session->userdata('ip11');   

                        $suma_total = 
                        $valor1+
                        $valor2+
                        $valor3+
                        $valor4+
                        $valor5+
                        $valor6+
                        $valor7+
                        $valor8+
                        $valor9+
                        $valor10+
                        $valor11+
                        $row->total_redes
                        ;                        
                        
                          /*
                               $dato[]= array(
                                      0=>$row->id,
                                      1=>$row->nombre,
                                      2=>$row->apellidos,
                                      3=>$row->email,
                                      4=>$row->celular,
                                      5=>$row->email,
                                      6=>$row->contrasena,
                                      7=>$row->nick,
                                      8=>$row->ciudad,
                                      9=>$row->estado,
                                      10=>$row->fecha_pc,
                                      11=>$row->estado_ticket,
                                      12=>$row->region,
                                      13=>$row->id_region,
                                      14=> $suma_total
                                      //11=>$suma_total,
                                    );
                               */
                      
                          $row->total =$suma_total;      

                      }

                      return $result->result();

                      /*
                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => $registros_filtrados,  //intval( self::total_participantes() ), 
                        "recordsFiltered" =>   $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                      */
                    
              }   
              else {

                return false; 
                /*
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  */

              }

              $result->free_result();           

      }  



public function exportar_todo_regiones($data){   



          
          $cadena = addslashes($data['busqueda']);
                  
          $this->db->select("p.id", FALSE);             
          $this->db->select("AES_DECRYPT(p.nombre, '{$this->key_hash}') AS nombre", FALSE);
          $this->db->select("AES_DECRYPT(p.Apellidos, '{$this->key_hash}') AS apellidos", FALSE);
          $this->db->select("AES_DECRYPT(p.celular, '{$this->key_hash}') AS celular", FALSE);
          $this->db->select("AES_DECRYPT(p.email, '{$this->key_hash}') AS email", FALSE);
          $this->db->select("AES_DECRYPT(p.contrasena, '{$this->key_hash}') AS contrasena", FALSE);
          $this->db->select("AES_DECRYPT(p.nick, '{$this->key_hash}') AS nick", FALSE);
          //$this->db->select("p.fecha_mac,p.fecha_pc");
          $this->db->select("( CASE WHEN p.fecha_pc = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(p.fecha_pc-21780),'%d-%m-%Y %H:%i:%s') END ) AS fecha_pc", FALSE); 
          
          
          $this->db->select("p.ciudad ciudad", FALSE);
          $this->db->select("e.nombre estado");

          $this->db->select("sum( (AES_DECRYPT(r.redes, '{$this->key_hash}')=1)*100) AS redes", FALSE); 

          $this->db->select("et.region");

           $this->db->select("GROUP_CONCAT( DISTINCT (case when ((et.nombre <>'')) then 

            CONCAT ( et.nombre,'<br/>')

            else null end)   separator ' ' ) AS estado_ticket", FALSE);

          $this->db->select("AES_DECRYPT(r.ticket, '{$this->key_hash}') AS ticket", FALSE);
          $this->db->select("AES_DECRYPT(r.folio, '{$this->key_hash}') AS folio", FALSE);
          $this->db->select("AES_DECRYPT(r.monto, '{$this->key_hash}') AS monto", FALSE);
          $this->db->select("AES_DECRYPT(r.tiempo_juego,'{$this->key_hash}') AS tiempo_juego", FALSE);      
          $this->db->select("( CASE WHEN r.fecha_pc = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(r.fecha_pc-21780),'%d-%m-%Y %H:%i:%s') END ) AS fecha_registro_ticket", FALSE); 
          $this->db->select("( CASE WHEN r.compra = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(r.compra),'%d-%m-%Y %H:%i:%s') END ) AS fecha_compra", FALSE);     


          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|1;', '')) ) /3) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))   )  AS  cant1", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|2;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant2", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|3;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant3", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|4;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant4", FALSE);
          $this->db->select("sum( ( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|5;', '')) ) /3 ) *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant5", FALSE);   
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|6;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant6", FALSE);
          
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|7;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant7", FALSE);
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|8;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant8", FALSE);
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|9;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant9", FALSE);
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|10;', '')) ) /4 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant10", FALSE);
          $this->db->select("sum(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|11;', '')) ) /4 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  ) AS  cant11", FALSE);

          $this->db->select("sum( (AES_DECRYPT(r.redes, '{$this->key_hash}')=1)*100) AS total_redes", FALSE); 


          $this->db->from($this->participantes.' as p'); 
          $this->db->join($this->catalogo_estadosregistro.' as e', 'e.id = p.id_estado','left');
          $this->db->join($this->registro_participantes.' as r', 'p.id = r.id_participante');
          $this->db->join($this->catalogo_estados.' as et', "et.id = r.id_ciudad");

               $region =   ($data['id_region']!=0) ? " (et.id_region=".$data['id_region']." ) AND " : " ";
               $where = "(     
                      ".$region."
                      

                    (
                        (  CONCAT( AES_DECRYPT(p.nombre,'{$this->key_hash}'),' ',AES_DECRYPT(p.Apellidos,'{$this->key_hash}') ) LIKE  '%".$cadena."%' )
                        OR ( AES_DECRYPT(p.email,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                        OR ( AES_DECRYPT(p.celular,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                         OR ( AES_DECRYPT(p.ciudad,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                         OR ( AES_DECRYPT(p.contrasena,'{$this->key_hash}') LIKE  '%".$cadena."%' )
                       )                
                 
              )" ;    
  
          $this->db->where($where);
    
          //ordenacion
         // $this->db->order_by($columna, $order); 

          //ordenacion
          $this->db->group_by('p.id, r.id, r.ticket,r.folio, et.id_region'); 

          //paginacion
          //$this->db->limit($largo,$inicio); 


          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {
                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);

                  $retorno= " ";  
                  foreach ($result->result() as $row) {
                        $suma_total = 0;
                        $valor1=((int)$row->cant1)*$this->session->userdata('ip1');
                        $valor2=((int)$row->cant2)*$this->session->userdata('ip2');
                        $valor3=((int)$row->cant3)*$this->session->userdata('ip3');
                        $valor4=((int)$row->cant4)*$this->session->userdata('ip4'); 
                        $valor5=((int)$row->cant5)*$this->session->userdata('ip5');    
                        $valor6=((int)$row->cant6)*$this->session->userdata('ip6');     
                        $valor7=((int)$row->cant7)*$this->session->userdata('ip7');     
                        $valor8=((int)$row->cant8)*$this->session->userdata('ip8');     
                        $valor9=((int)$row->cant9)*$this->session->userdata('ip9');
                        $valor10=((int)$row->cant10)*$this->session->userdata('ip10');   
                        $valor11=((int)$row->cant11)*$this->session->userdata('ip11');   

                        $suma_total = 
                        $valor1+
                        $valor2+
                        $valor3+
                        $valor4+
                        $valor5+
                        $valor6+
                        $valor7+
                        $valor8+
                        $valor9+
                        $valor10+
                        $valor11+
                        $row->total_redes
                        ;                        
                        
                      
                      
                          $row->total =$suma_total;      

                      }

                      return $result->result();
                    
              }   
              else {
                return false; 

              }

              $result->free_result();           

      }  

      


  } 
?>
