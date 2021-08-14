<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

	class registros extends CI_Model{
		
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
          $this->catalogo_litraje      = $this->db->dbprefix('catalogo_litraje');

          $this->participantes      = $this->db->dbprefix('participantes');
          $this->bitacora_participante     = $this->db->dbprefix('bitacora_participante');
          $this->catalogo_imagenes         = $this->db->dbprefix('catalogo_imagenes');
          
          $this->registro_participantes         = $this->db->dbprefix('registro_participantes');

          $this->catalogo_preguntas         = $this->db->dbprefix('catalogo_preguntas');
          

		}



//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////USUARIOS////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




    //checar si nick existe
    public function check_nick_existente($data){
      $this->db->select("AES_DECRYPT(nick,'{$this->key_hash}') AS nick", FALSE);      
      $this->db->from($this->participantes);
      $this->db->where('nick', "AES_ENCRYPT('{$data['nick']}','{$this->key_hash}')", FALSE); 
      $login = $this->db->get();
      if ($login->num_rows() > 0)
        return FALSE;
      else
        return TRUE;
      $login->free_result();
    }

         //checar el loguin y recoger datos de usuario registrado
    public function check_login_nick($data){
          $this->db->select("id", FALSE);           
          $this->db->select("AES_DECRYPT(p.email,'{$this->key_hash}') AS email", FALSE);      
          $this->db->select("AES_DECRYPT(p.nombre,'{$this->key_hash}') AS nombre", FALSE);      
          $this->db->select("AES_DECRYPT(p.apellidos,'{$this->key_hash}') AS apellidos", FALSE);      
          $this->db->select("AES_DECRYPT(p.celular,'{$this->key_hash}') AS celular", FALSE);      
          $this->db->select("AES_DECRYPT(p.contrasena,'{$this->key_hash}') AS contrasena", FALSE);
          $this->db->select("AES_DECRYPT(p.nick,'{$this->key_hash}') AS nick", FALSE);

          $this->db->from($this->participantes.' as p');
            
          $this->db->where('p.nick', "AES_ENCRYPT('{$data['nick']}','{$this->key_hash}')", FALSE); 
          $this->db->where('p.contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE);
          $login = $this->db->get();

          if ($login->num_rows() > 0)
            return $login->result();
          else 
            return FALSE;
          $login->free_result();
    }      


       //agregar participante
    public function anadir_registro( $data ){
            $timestamp = time();

            //$this->db->set( 'total', "AES_ENCRYPT(0,'{$this->key_hash}')", FALSE );  //total comienza en 0
           // $this->db->set( 'tarjeta', "AES_ENCRYPT('','{$this->key_hash}')", FALSE );  //total comienza en 0
           // $this->db->set( 'juego', "AES_ENCRYPT('','{$this->key_hash}')", FALSE );  //total comienza en 0


            $this->db->set( 'id_perfil', $data['id_perfil']);
            $this->db->set( 'creacion',  gmt_to_local( $timestamp, $this->timezone, TRUE) );
            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );  //fecha cdo se registro
            $this->db->set( 'id', "UUID()", FALSE); //id

            $this->db->set( 'nombre', "AES_ENCRYPT('{$data['nombre']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'apellidos', "AES_ENCRYPT('{$data['apellidos']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'email', "AES_ENCRYPT('{$data['email']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'fecha_nac', strtotime(date( "d-m-Y", strtotime($data['fecha_nac']) )) ,false);
            $this->db->set( 'calle', "AES_ENCRYPT('{$data['calle']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'numero', $data['numero']);
            $this->db->set( 'colonia', "AES_ENCRYPT('{$data['colonia']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'municipio', "AES_ENCRYPT('{$data['municipio']}','{$this->key_hash}')", FALSE );


            $this->db->set( 'cp', "AES_ENCRYPT('{$data['cp']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'ciudad', $data['ciudad']);
            $this->db->set( 'celular', "AES_ENCRYPT('{$data['celular']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'telefono', "AES_ENCRYPT('{$data['telefono']}','{$this->key_hash}')", FALSE );

            $this->db->set( 'contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'id_estado', $data['id_estado_compra']);
            $this->db->set( 'nick', "AES_ENCRYPT('{$data['nick']}','{$this->key_hash}')", FALSE );


            $this->db->insert($this->participantes );

            if ($this->db->affected_rows() > 0){
                  return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
            
        }


    


      //agregar a la bitacora de participante sus accesos  
       public function anadir_historico_acceso($data){
            $timestamp = time();
            $ip_address = $this->input->ip_address();
            $user_agent= $this->input->user_agent();

            $this->db->set( 'id_usuario', $data->id); // luego esta se compara con la tabla participante
            $this->db->set( 'email', "AES_ENCRYPT('{$data->email}','{$this->key_hash}')", FALSE );
            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );  //fecha cdo se registro
            $this->db->set( 'ip_address',  $ip_address, TRUE );
            $this->db->set( 'user_agent',  $user_agent, TRUE );
            $this->db->insert($this->bitacora_participante );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();

        }


    //Recuperar contraseña  del participante
      public function recuperar_contrasena($data){
        $this->db->select("id", FALSE);           
        $this->db->select("AES_DECRYPT(p.email,'{$this->key_hash}') AS email", FALSE);            
        $this->db->select("AES_DECRYPT(p.nombre,'{$this->key_hash}') AS nombre", FALSE);      
        $this->db->select("AES_DECRYPT(p.apellidos,'{$this->key_hash}') AS apellidos", FALSE);      
      $this->db->select("AES_DECRYPT(p.nick,'{$this->key_hash}') AS nick", FALSE);      
      //$this->db->select("AES_DECRYPT(p.telefono,'{$this->key_hash}') AS telefono", FALSE);      
        $this->db->select("AES_DECRYPT(p.contrasena,'{$this->key_hash}') AS contrasena", FALSE);
        $this->db->from($this->participantes.' as p');
        $this->db->where('p.email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);
        $login = $this->db->get();
        if ($login->num_rows() > 0)
          return $login->result();
        else 
          return FALSE;
        $login->free_result();    
      } 


//----------------**************catalogos-------------------************------------------
  public function listado_estados(){
            $this->db->select( 'id, nombre' );
            $this->db->order_by('nombre', 'ASC');
            $estados = $this->db->get($this->catalogo_estados );
            if ($estados->num_rows() > 0 )
               return $estados->result();
            else
               return FALSE;
            $estados->free_result();
        }   


//----------------**************catalogos-------------------************------------------
  public function listado_estadosregistro(){
            $this->db->select( 'id, nombre' );
            $this->db->order_by('nombre', 'ASC');
            $estados = $this->db->get($this->catalogo_estadosregistro );
            if ($estados->num_rows() > 0 )
               return $estados->result();
            else
               return FALSE;
            $estados->free_result();
        }   


//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////tickets///////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////

        //checar si el tickets ya fue registrado
        public function check_tickets_existente($data){
            $this->db->from($this->registro_participantes);
            $this->db->where('ticket',"AES_ENCRYPT('{$data['ticket']}','{$this->key_hash}')",FALSE);
            $this->db->where('folio',"AES_ENCRYPT('{$data['folio']}','{$this->key_hash}')",FALSE);
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return FALSE;
            else
                return TRUE;
            $login->free_result();
        }

         //checar si el tickets ya fue registrado
         //checar si el tickets ya fue registrado teniendo en cuenta su folio
        public function check_tickets_existente_cero($data){
             $segundo_num=substr($data["folio"],  -4); ////los 4ultimos
             $cantidad_comparar = intval( ltrim(substr($segundo_num, 0, 3),'0') ); //los 3 primeros
             //$cantidad_comparar = intval($str); //ultimo
            //$this->db->select("AES_DECRYPT(tarjeta,'{$this->key_hash}') AS tarjeta", FALSE);   

             //1- checo si el ticket ya fue registrado y devuelvo los registros
            $this->db->from($this->registro_participantes);
            $this->db->where('ticket',"AES_ENCRYPT('{$data['ticket']}','{$this->key_hash}')",FALSE);
            //$this->db->where('folio',"AES_ENCRYPT('{$data['folio']}','{$this->key_hash}')",FALSE);
            //$this->db->where("tarjeta != ''");
            $query1 = $this->db->get();

            if ($query1->num_rows() ==0 ) { //sino hay registro q entonces entregue toda la cantidad a comparar
                return $cantidad_comparar;  
            }
            


            //si la cantidad de registros es < =  entonces no termino
            if ($query1->num_rows() <= $cantidad_comparar) {

              //elimino la consulta q se hizo anteriormente para hacer otra
               $query1->free_result();
            
              //comparo si el que quiere repetir es otra persona
               $this->db->from($this->registro_participantes.' r ');
               $where = "(((r.id_participante<>'".$this->session->userdata('id_participante')."') AND  
                      ( AES_DECRYPT(r.ticket,'{$this->key_hash}') = '".$data['ticket']."' )) OR (( (r.id_participante='".$this->session->userdata('id_participante')."') ) AND  
                      ( AES_DECRYPT(r.ticket,'{$this->key_hash}') = '".$data['ticket']."' ) AND ( AES_DECRYPT(r.folio,'{$this->key_hash}')!='".$data['folio']."' )))
               ";   
               $this->db->where($where);

               $query2 = $this->db->get();

               
               if ( $query2->num_rows() > 0 ){ //no es la persona que se quedo a la mitad
                 return FALSE;
               } 

              //elimino la consulta q se hizo anteriormente para hacer otra
               $query1->free_result();


               //Por ultimo solo elimino los registros que no fueron completados, y devuelvo la diferencia de los q elimine
              

               $where = "( ( tarjeta is NULL ) AND  
                      ( AES_DECRYPT(ticket,'{$this->key_hash}') = '".$data['ticket']."' ) )
               ";   
               $this->db->where($where);              
              $this->db->delete( $this->registro_participantes );
              
              //$afftectedRows = $this->db->affected_rows();

               $this->db->from($this->registro_participantes.' r ');
               $where = "( (r.id_participante='".$this->session->userdata('id_participante')."') ) AND  
                      ( AES_DECRYPT(r.ticket,'{$this->key_hash}') = '".$data['ticket']."' ) 
               ";   
               $this->db->where($where);

               $query3 = $this->db->get();


                return $cantidad_comparar-$query3->num_rows(); //cantidad total - eliminados
            }                
            else
                return FALSE;
            $login->free_result();
        }




        // public function check_tickets_existente_cero($data){
        //      $segundo_num=substr($data["folio"],  -4); 
        //      $cantidad_comparar = intval( ltrim(substr($segundo_num, 0, 3),'0') ); 
        //     $this->db->from($this->registro_participantes);
        //     $this->db->where('ticket',"AES_ENCRYPT('{$data['ticket']}','{$this->key_hash}')",FALSE);
        //     $this->db->where('folio',"AES_ENCRYPT('{$data['folio']}','{$this->key_hash}')",FALSE);
        //     $cant = $this->db->count_all_results();  
        //     if ($cant < $cantidad_comparar) {
        //       $this->db->where('ticket',"AES_ENCRYPT('{$data['ticket']}','{$this->key_hash}')",FALSE);
        //       $this->db->where('folio',"AES_ENCRYPT('{$data['folio']}','{$this->key_hash}')",FALSE);
        //       $this->db->delete( $this->registro_participantes );
        //         return $cantidad_comparar;
        //     }                
        //     else
        //         return FALSE;
        //     $login->free_result();
        // }

          //agregar tickets
        public function anadir_tickets( $data ){
            $timestamp = time();

            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );  //fecha cdo se registro
            
            $id_participante = $this->session->userdata('id_participante');
            $this->db->set( 'id_participante', '"'.$id_participante.'"',false); // id del usuario que se registro
            
            $this->db->set( 'ticket', "AES_ENCRYPT('{$data['ticket']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'monto', "AES_ENCRYPT('{$data['monto']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'compra', strtotime(date( "d-m-Y", strtotime($data['compra']) )) ,false);
            $this->db->set( 'folio', "AES_ENCRYPT('{$data['folio']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'id_ciudad', $data['id_ciudad_compra']);

            $this->db->insert($this->registro_participantes );


            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
            
        }  



////////////////////////////////////////////////////////////////////////////////////
/////////////////////////juegos/////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
        public function listado_imagenes(){

            $this->db->select('c.id, c.nombre, c.valor, c.activo, c.puntos, c.porciento');
            $this->db->from($this->catalogo_imagenes.' as c');
            $this->db->where('c.activo',0);
            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }     




     
        //agregar las caras para un ticket y un folio de un determinado usuario
        public function agregar_datos($data){

             $timestamp = time();

             $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );  
             $this->db->set( 'cara', "AES_ENCRYPT('{$data['cara']}','{$this->key_hash}')", FALSE );
             $this->db->set( 'misdatos', "AES_ENCRYPT('{$data['misdatos']}','{$this->key_hash}')", FALSE );
              
              $this->db->where("id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
              $this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
              $this->db->where('folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);
            
              //Actualizar solo el ultimo
              //ORDER BY id DESC
              $this->db->order_by("id", "DESC");
              $this->db->limit(1,0); //$largo,$inicio


             $this->db->update($this->registro_participantes );
  
              if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();

        }


        public function get_datos(){
            
            $this->db->select("AES_DECRYPT(cara,'{$this->key_hash}') AS cara", FALSE);      
            $this->db->select("AES_DECRYPT(misdatos,'{$this->key_hash}') AS misdatos", FALSE);      
            $this->db->select("AES_DECRYPT(tarjeta,'{$this->key_hash}') AS tarjeta", FALSE);      
            $this->db->select("AES_DECRYPT(juego,'{$this->key_hash}') AS juego", FALSE);      
            $this->db->select("AES_DECRYPT(tiempo_juego,'{$this->key_hash}') AS tiempo_juego", FALSE);      
            $this->db->select("AES_DECRYPT(redes,'{$this->key_hash}') AS redes", FALSE);      
            

            $this->db->from($this->registro_participantes);
            $this->db->where("id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
            $this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
            $this->db->where('folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);

              //Actualizar solo el ultimo
              //ORDER BY id DESC
              $this->db->order_by("id", "DESC");
              $this->db->limit(1,0); //$largo,$inicio


            $preg = $this->db->get();
            if ($preg->num_rows() > 0)
              return $preg->row();
            else
              return TRUE;
            $login->free_result();
        }




 

//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////        

        //cada vez que vire la tarjeta pues que guarde la "cadena [tarjeta] y el [tiempo]", 
      public function actualizar_respuesta_tarjeta($data){
        if ( ($this->session->userdata( 'session_participante' ) == TRUE ) && ($this->session->userdata( 'registro_ticket' ) == TRUE )  ) { 
            //leer la tarjeta
            $this->db->select("AES_DECRYPT(tarjeta,'{$this->key_hash}') AS tarjeta", FALSE);      
            $this->db->from($this->registro_participantes);
            $this->db->where("id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
            $this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
            $this->db->where('folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);
              
              //Actualizar solo el ultimo
              //ORDER BY id DESC
              $this->db->order_by("id", "DESC");
              $this->db->limit(1,0); //$largo,$inicio

             //Actualizar solo el ultimo
              //ORDER BY id DESC
            $this->db->order_by("id", "DESC");
            $this->db->limit(1,0); //$largo,$inicio

            $preg = $this->db->get();
            $data["formato"] =trim($preg->row()->tarjeta).trim($data["formato"]);
            $timestamp = time();
            

            //Actualizar la tarjeta
            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );  
            $this->db->set( 'tarjeta', "AES_ENCRYPT(' {$data["formato"]}  ','{$this->key_hash}')", FALSE );
            $this->db->set( 'tiempo_juego', "AES_ENCRYPT('{$data['tiempo']}','{$this->key_hash}')", FALSE );  
            
            $this->db->where("id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
            $this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
            $this->db->where('folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);

              //Actualizar solo el ultimo
              //ORDER BY id DESC
              $this->db->order_by("id", "DESC");
              $this->db->limit(1,0); //$largo,$inicio


            $this->db->update($this->registro_participantes );
  
            if ($this->db->affected_rows() > 0){
                  return json_encode($data["formato"]);
              } else {
                  return FALSE;
              }
              $result->free_result();
        }
}

        public function actualizar_tiempoinicial(){
if ( ($this->session->userdata( 'session_participante' ) == TRUE ) && ($this->session->userdata( 'registro_ticket' ) == TRUE )  ) { 
             $timestamp = date('Y-m-d H:i:s');

             $this->db->set( 'fechainicial',  $timestamp,TRUE );  
             //$this->db->set( 'tiempo_juego', "AES_ENCRYPT('{$data['tiempo']}','{$this->key_hash}')", FALSE );  
            
            $this->db->where("id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
            $this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
            $this->db->where('folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);
            
              //Actualizar solo el ultimo
              //ORDER BY id DESC
              $this->db->order_by("id", "DESC");
              $this->db->limit(1,0); //$largo,$inicio

            $this->db->update($this->registro_participantes );
  
              if ($this->db->affected_rows() > 0){
                    return true;
                } else {
                    return false;
                }
                $result->free_result();
}
        }  


          public function checartiempo(){
if ( ($this->session->userdata( 'session_participante' ) == TRUE ) && ($this->session->userdata( 'registro_ticket' ) == TRUE )  ) { 
            $this->db->select("fechainicial,cuenta100,cuenta50,cuenta20,cuenta0"); 
            $this->db->from($this->registro_participantes);
            $this->db->where("id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
            $this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
            $this->db->where('folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);
            
              //Actualizar solo el ultimo
              //ORDER BY id DESC
              $this->db->order_by("id", "DESC");
              $this->db->limit(1,0); //$largo,$inicio

               $preg2 = $this->db->get();
            if ($preg2->num_rows() > 0)
              return $preg2->row();
            else
              return TRUE;
            $preg2->free_result();
}
          }           

public function actualizar_cuenta100(){
if ( ($this->session->userdata( 'session_participante' ) == TRUE ) && ($this->session->userdata( 'registro_ticket' ) == TRUE )  ) { 
             $timestamp = date('Y-m-d H:i:s');

             $this->db->set('cuenta100', 'cuenta100+1', FALSE);
           
             //$this->db->set( 'tiempo_juego', "AES_ENCRYPT('{$data['tiempo']}','{$this->key_hash}')", FALSE );  
            
            $this->db->where("id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
            $this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
            $this->db->where('folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);
            
              //Actualizar solo el ultimo
              //ORDER BY id DESC
              $this->db->order_by("id", "DESC");
              $this->db->limit(1,0); //$largo,$inicio

            $this->db->update($this->registro_participantes );
  
              if ($this->db->affected_rows() > 0){
                    return true;
                } else {
                    return false;
                }
                $result->free_result();
}
        }   

        public function actualizar_cuenta50(){
if ( ($this->session->userdata( 'session_participante' ) == TRUE ) && ($this->session->userdata( 'registro_ticket' ) == TRUE )  ) { 
             $timestamp = date('Y-m-d H:i:s');

             $this->db->set('cuenta50', 'cuenta50+1', FALSE);
           
             //$this->db->set( 'tiempo_juego', "AES_ENCRYPT('{$data['tiempo']}','{$this->key_hash}')", FALSE );  
            
            $this->db->where("id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
            $this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
            $this->db->where('folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);
            
              //Actualizar solo el ultimo
              //ORDER BY id DESC
              $this->db->order_by("id", "DESC");
              $this->db->limit(1,0); //$largo,$inicio

            $this->db->update($this->registro_participantes );
  
              if ($this->db->affected_rows() > 0){
                    return true;
                } else {
                    return false;
                }
                $result->free_result();
}
        }   

        public function actualizar_cuenta20(){
if ( ($this->session->userdata( 'session_participante' ) == TRUE ) && ($this->session->userdata( 'registro_ticket' ) == TRUE )  ) { 
             $timestamp = date('Y-m-d H:i:s');

             $this->db->set('cuenta20', 'cuenta20+1', FALSE);
           
             //$this->db->set( 'tiempo_juego', "AES_ENCRYPT('{$data['tiempo']}','{$this->key_hash}')", FALSE );  
            
            $this->db->where("id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
            $this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
            $this->db->where('folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);
            
              //Actualizar solo el ultimo
              //ORDER BY id DESC
              $this->db->order_by("id", "DESC");
              $this->db->limit(1,0); //$largo,$inicio

            $this->db->update($this->registro_participantes );
  
              if ($this->db->affected_rows() > 0){
                    return true;
                } else {
                    return false;
                }
                $result->free_result();
}
        }   

        public function actualizar_cuenta0(){
if ( ($this->session->userdata( 'session_participante' ) == TRUE ) && ($this->session->userdata( 'registro_ticket' ) == TRUE )  ) { 
             $timestamp = date('Y-m-d H:i:s');

             $this->db->set('cuenta0', 'cuenta0+1', FALSE);
           
             //$this->db->set( 'tiempo_juego', "AES_ENCRYPT('{$data['tiempo']}','{$this->key_hash}')", FALSE );  
            
            $this->db->where("id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
            $this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
            $this->db->where('folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);
            
              //Actualizar solo el ultimo
              //ORDER BY id DESC
              $this->db->order_by("id", "DESC");
              $this->db->limit(1,0); //$largo,$inicio

            $this->db->update($this->registro_participantes );
  
              if ($this->db->affected_rows() > 0){
                    return true;
                } else {
                    return false;
                }
                $result->free_result();
}
        }        



        public function actualizar_tiempofinal(){
if ( ($this->session->userdata( 'session_participante' ) == TRUE ) && ($this->session->userdata( 'registro_ticket' ) == TRUE )  ) { 
             $timestamp = date('Y-m-d H:i:s');

             $this->db->set( 'fechafinal',  $timestamp,TRUE );  
             //$this->db->set( 'tiempo_juego', "AES_ENCRYPT('{$data['tiempo']}','{$this->key_hash}')", FALSE );  
            
            $this->db->where("id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
            $this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
            $this->db->where('folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);
            
              //Actualizar solo el ultimo
              //ORDER BY id DESC
              $this->db->order_by("id", "DESC");
              $this->db->limit(1,0); //$largo,$inicio

            $this->db->update($this->registro_participantes );
  
              if ($this->db->affected_rows() > 0){
                    return true;
                } else {
                    return false;
                }
                $result->free_result();
}
        }        


        //este es cuando el tiempo se agota a 0:00
        public function actualizar_tiempo($data){
if ( ($this->session->userdata( 'session_participante' ) == TRUE ) && ($this->session->userdata( 'registro_ticket' ) == TRUE )  ) { 
             $timestamp = time();

             $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );  
             $this->db->set( 'tiempo_juego', "AES_ENCRYPT('{$data['tiempo']}','{$this->key_hash}')", FALSE );  
            
            $this->db->where("id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
            $this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
            $this->db->where('folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);
            
              //Actualizar solo el ultimo
              //ORDER BY id DESC
              $this->db->order_by("id", "DESC");
              $this->db->limit(1,0); //$largo,$inicio

            $this->db->update($this->registro_participantes );
  
              if ($this->db->affected_rows() > 0){
                    return true;
                } else {
                    return false;
                }
                $result->free_result();

        }        
}






 

//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////las preguntas/////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////        


    //listado de todas las preguntas
        public function listado_preguntas(){
            $this->db->select( 'id' );
            $this->db->from($this->catalogo_preguntas);
            //$this->db->where('fig',(int)$i);
            $preguntas = $this->db->get();
            if ($preguntas->num_rows() > 0 )
                 

               return $preguntas->result();
            else
               return FALSE;
            $estados->free_result();
        }   


       //tomar la pregunta por el id pasado
        public function get_preguntas(){
            $this->db->select( 'id,  pregunta, a, b, c, respuesta' );
            $this->db->from($this->catalogo_preguntas);
            $this->db->where('id', $this->session->userdata('pregunta'));
            $preg = $this->db->get();
            if ($preg->num_rows() > 0)
              return $preg->row();
            else
              return TRUE;
            $login->free_result();
        }        


   //poner la respuesta del juego 
        public function actualizar_respuesta_juego($data){

            //$this->db->set( 'responder', "AES_ENCRYPT('{$data['responder']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'responder', $data['responder'] );
            $this->db->set("id_pregunta", (int)$this->session->userdata( 'pregunta'));  
            $this->db->set( 'respuesta', "AES_ENCRYPT('{$data['respuesta']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'acumulado_pto', "AES_ENCRYPT('{$data['acumulado_pto']}','{$this->key_hash}')", FALSE );
            

            $this->db->where("id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
            $this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
            $this->db->where('folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);
            
              //Actualizar solo el ultimo
              //ORDER BY id DESC
              $this->db->order_by("id", "DESC");
              $this->db->limit(1,0); //$largo,$inicio

            $this->db->update($this->registro_participantes );






  
              if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();

        }        

         

      public function acumulado_puntos(){

          $this->db->select("p.fecha_pc");   
          $this->db->select("AES_DECRYPT(r.ticket, '{$this->key_hash}') AS ticket", FALSE);
          $this->db->select("AES_DECRYPT(r.folio, '{$this->key_hash}') AS folio", FALSE);

          $this->db->select("sum( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '1;', '')) ) /2 )  AS  cant1", FALSE);
          $this->db->select("sum( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '2;', '')) ) /2 )  AS  cant2", FALSE);
          $this->db->select("sum( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '3;', '')) ) /2 )  AS  cant3", FALSE);
          $this->db->select("sum( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '4;', '')) ) /2 )  AS  cant4", FALSE);
          $this->db->select("sum( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '5;', '')) ) /2 )  AS  cant5", FALSE);



          $this->db->from($this->participantes.' as p');
          $this->db->join($this->registro_participantes.' as r', 'p.id = r.id_participante');

            //$this->db->where("p.id", '"'.$this->session->userdata('id_participante').'"',false);  
            
            $this->db->where("r.id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
            $this->db->where('r.ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
            $this->db->where('r.folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);
            

 
          $this->db->group_by("p.id, r.ticket, r.folio");

            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();


      }  


////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////

 public function total_facebook(){

            

              $this->db->select("sum( (AES_DECRYPT(r.redes, '{$this->key_hash}')=1)*100) AS total", FALSE); 


          $this->db->from($this->registro_participantes.' as r');
          $this->db->where("r.id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
        

          $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return  (int) ($result->row()->total);
            else
               return False;
            $result->free_result();


         } 


 //agregar participante
        public function actualizar_facebook( $data ){
            $timestamp = time();

            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );  //fecha cdo se registro
            $this->db->set( 'redes', "AES_ENCRYPT('{$data['redes']}','{$this->key_hash}')", FALSE );
            $this->db->where("id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
            $this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
            $this->db->where('folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);
            
              //Actualizar solo el ultimo
              //ORDER BY id DESC
              $this->db->order_by("id", "DESC");
              $this->db->limit(1,0); //$largo,$inicio

            $this->db->update($this->registro_participantes );

            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }        








////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
 

      public function record_personal(){

          $this->db->select("p.fecha_pc");   
          $this->db->select("AES_DECRYPT(p.nombre, '{$this->key_hash}') AS nombre", FALSE);
          $this->db->select("AES_DECRYPT(p.Apellidos, '{$this->key_hash}') AS Apellidos", FALSE);
          $this->db->select("AES_DECRYPT(p.nick, '{$this->key_hash}') AS nick", FALSE);

          /*
          $this->db->select("sum( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '1;', '')) ) /2 )  AS  cant1", FALSE);
          $this->db->select("sum( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '2;', '')) ) /2 )  AS  cant2", FALSE);
          $this->db->select("sum( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '3;', '')) ) /2 )  AS  cant3", FALSE);
          $this->db->select("sum( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '4;', '')) ) /2 )  AS  cant4", FALSE);
          $this->db->select("sum( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '5;', '')) ) /2 )  AS  cant5", FALSE);*/



          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|1;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant1", FALSE);
          
          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|2;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant2", FALSE);
          
          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|3;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant3", FALSE);

          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|4;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant4", FALSE);

          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|5;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant5", FALSE);



  


         $this->db->select("sum( (AES_DECRYPT(r.redes, '{$this->key_hash}')=1)*100) AS total_redes", FALSE); 



          //$this->db->select("AES_DECRYPT(r.tarjeta, '{$this->key_hash}') AS tarjeta", FALSE);
             


          $this->db->from($this->participantes.' as p');
          $this->db->join($this->registro_participantes.' as r', 'p.id = r.id_participante');

          $this->db->where("p.id", '"'.$this->session->userdata('id_participante').'"',false);  
          //$this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
          //$this->db->where('folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);

          
          $this->db->group_by("p.id");

            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->row();
            else
               return False;
            $result->free_result();


      }  



 public function record_detalle(){

      


$id_session = $this->session->userdata('id');
  $this->db->select("p.id", FALSE);           
         
           
 
          //$this->db->select("AES_DECRYPT(p.nombre, '{$this->key_hash}') AS nombre", FALSE);
          //$this->db->select("AES_DECRYPT(p.Apellidos, '{$this->key_hash}') AS apellidos", FALSE);
          //$this->db->select("AES_DECRYPT(p.celular, '{$this->key_hash}') AS celular", FALSE);
          //$this->db->select("AES_DECRYPT(p.email, '{$this->key_hash}') AS email", FALSE);
          //$this->db->select("AES_DECRYPT(p.contrasena, '{$this->key_hash}') AS contrasena", FALSE);
          //$this->db->select("AES_DECRYPT(p.nick, '{$this->key_hash}') AS nick", FALSE);
          //$this->db->select("p.fecha_mac,p.fecha_pc");
          //$this->db->select("AES_DECRYPT(p.ciudad, '{$this->key_hash}') AS ciudad", FALSE);
          //$this->db->select("( CASE WHEN p.fecha_pc = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(p.fecha_pc-21600),'%d-%m-%Y %H:%i:%s') END ) AS fecha_pc", FALSE); 
          //$this->db->select("e.nombre estado");
          $this->db->select("AES_DECRYPT(r.ticket, '{$this->key_hash}') AS ticket", FALSE);
          $this->db->select("AES_DECRYPT(r.folio, '{$this->key_hash}') AS folio", FALSE);
          

          $this->db->select("( CASE WHEN r.responder = 1 THEN 'Si' ELSE 'No' END ) AS respuesta", FALSE);  

          //$this->db->select("AES_DECRYPT(r.folio, '{$this->key_hash}') AS folio", FALSE);
          $this->db->select("AES_DECRYPT(r.monto, '{$this->key_hash}') AS monto", FALSE);


          $this->db->select("0 subtotal, 0 total_redes, 0 total", false);
      

          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|1;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant1", FALSE);
          
          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|2;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant2", FALSE);
          
          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|3;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant3", FALSE);

          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|4;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant4", FALSE);

          $this->db->select("(( (LENGTH(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}')  ) - LENGTH(REPLACE(  AES_DECRYPT(r.tarjeta, '{$this->key_hash}'), '|5;', '')) ) /3 )  *  ((2*(r.responder=1))+ (1*(r.responder<>1)))  )*((r.fechainicial is not NULL) AND (r.fechafinal is not NULL)) AS  cant5", FALSE);
      







    
          $this->db->select("( (AES_DECRYPT(r.redes, '{$this->key_hash}')=1)*100) AS redes", FALSE); 


          
          $this->db->from($this->participantes.' as p'); 
          //$this->db->join($this->catalogo_estados.' as e', 'e.id = p.id_estado');
          $this->db->join($this->registro_participantes.' as r', 'p.id = r.id_participante');
         // $this->db->where("p.id", '"'.$this->session->userdata('id_participante').'"',false);  

          $where = "( (p.id='".$this->session->userdata('id_participante')."') )  

           ";   

          $this->db->where($where);       
          
            

          
          //$this->db->group_by('p.id'); 

          $result = $this->db->get();


              if ( $result->num_rows() > 0 ) {

                        foreach ($result->result() as $row) {


                         $valor1= ( ((int)$row->cant1) > 5 ? 5 : ((int)$row->cant1))*$this->session->userdata('ip1');
                        $valor2= ( ((int)$row->cant2) > 10 ? 10 : ((int)$row->cant2))*$this->session->userdata('ip2');
                        $valor3= ( ((int)$row->cant3) > 20 ? 20 : ((int)$row->cant3))*$this->session->userdata('ip3');
                        $valor4= ( ((int)$row->cant4) > 55 ? 55 : ((int)$row->cant4))*$this->session->userdata('ip4');
                        $valor5= ( ((int)$row->cant5) > 1 ? 1 : ((int)$row->cant5))*$this->session->userdata('ip5');
                        // $valor6=((int)$row->cant6)*$this->session->userdata('ip6');     
                        // $valor7=((int)$row->cant7)*$this->session->userdata('ip7');     
                        // $valor8=((int)$row->cant8)*$this->session->userdata('ip8');     
                        // $valor9=((int)$row->cant9)*$this->session->userdata('ip9');
                        // $valor10=((int)$row->cant10)*$this->session->userdata('ip10');   
                        // $valor11=((int)$row->cant11)*$this->session->userdata('ip11');               
                                            
                    
                      
                  


                        $suma_total = 
                        $valor1+
                        $valor2+
                        $valor3+
                        $valor4+
                        $valor5;
                        // $valor6+
                        // $valor7+
                        // $valor8+
                        // $valor9+
                        // $valor10+
                        // $valor11;



                          
                             $row->subtotal = $suma_total;
                             $row->total_redes =((int)$row->redes); 
                             $row->total =$row->subtotal+$row->total_redes;
                                


                          }      
                  return $result->result();
                    
              }  else {
                  return false; 

              }



      }  







 public function total_alcanzado(){

         
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
          
          $this->db->from($this->participantes.' as p'); 
          //$this->db->join($this->catalogo_estados.' as e', 'e.id = p.id_estado');
          $this->db->join($this->registro_participantes.' as r', 'p.id = r.id_participante');
          $this->db->where("p.id", '"'.$this->session->userdata('id_participante').'"',false);  

          
          $this->db->where('r.ticket',"AES_ENCRYPT('{$this->session->userdata('new_ticket')}','{$this->key_hash}')",FALSE);
          $this->db->where('r.folio',"AES_ENCRYPT('{$this->session->userdata('new_folio')}','{$this->key_hash}')",FALSE);

          
          
          
            

          
          //$this->db->group_by('p.id'); 

          $result = $this->db->get();

            $suma_total  = 0;
              if ( $result->num_rows() > 0 ) {

                        foreach ($result->result() as $row) {


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
                                $valor11;
                             //$row->subtotal = $suma_total;
                             
                                


                          }      
                  return $suma_total;
                    
              }  else {
                  return false; 

              }



      }  


//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////  
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////////         
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////  
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////         


   //agregar participante
        public function actualizar_tickets( $data ){
            $timestamp = time();

            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );  //fecha cdo se registro
            
            $id_participante         = $this->session->userdata('id_participante');
            $num_ticket_participante = $this->session->userdata('num_ticket_participante');
            

            $this->db->set( 'redes', 1, FALSE );
            $this->db->where('id_participante', $id_participante);  
            $this->db->where("AES_DECRYPT(ticket,'{$this->key_hash}')", '"'.$num_ticket_participante.'"',false);  

    
              //Actualizar solo el ultimo
              //ORDER BY id DESC
              $this->db->order_by("id", "DESC");
              $this->db->limit(1,0); //$largo,$inicio
                          
            $this->db->update($this->registro_participantes );


            if ($this->db->affected_rows() > 0){
                    self::registro_total_tickets2($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
            
        }  


        public function registro_total_tickets2( $data ){


            $id_participante = $this->session->userdata('id_participante');

            
            
            $this->db->set( 'total', "AES_ENCRYPT( (CASE WHEN ( ISNULL (CONVERT(AES_DECRYPT(total,'{$this->key_hash}') , decimal) ) =1 )  THEN 0 else (CONVERT(AES_DECRYPT(total,'{$this->key_hash}') , decimal) ) END ) +".$data['total']." , '{$this->key_hash}')", false);


              $this->db->where('id', $id_participante);   
            $this->db->update($this->participantes );
            

        }           






        public function registro_total_tickets( $data ){


            $id_participante = $this->session->userdata('id_participante');

            
            
            $this->db->set( 'total', "AES_ENCRYPT( (CASE WHEN ( ISNULL (CONVERT(AES_DECRYPT(total,'{$this->key_hash}') , decimal) ) =1 )  THEN 0 else (CONVERT(AES_DECRYPT(total,'{$this->key_hash}') , decimal) ) END ) +".$data['total']." , '{$this->key_hash}')", false);


              $this->db->where('id', $id_participante);   
            //$this->db->where('id', '"'.$id_participante.'"',false); // id del usuario que se registro

            $this->db->update($this->participantes );
            

        }    

      
    


//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////









    



////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////


       public function record_general(){

          $largo = 20;
          $inicio =0; 
          $this->db->select("CONVERT(AES_DECRYPT(p.total,'{$this->key_hash}'),decimal) AS total", FALSE);
          $this->db->select("AES_DECRYPT(p.nick,'{$this->key_hash}') AS nick", FALSE);      
          $this->db->from($this->participantes.' as p');
          $this->db->order_by("total", "DESC");

          $this->db->limit($largo,$inicio); 

            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();


      }  




/*

INSERT INTO calimax_participantes (`tarjeta`, `juego`)  
values (
AES_ENCRYPT('pana','gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5'), 
AES_ENCRYPT('osmel','gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5')
    )


SELECT
 AES_DECRYPT(nombre, 'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS nombre,
AES_DECRYPT(Apellidos, 'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS Apellidos,
AES_DECRYPT(juego, 'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS juego,
AES_DECRYPT(tiempo_juego, 'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS tiempo_juego,
AES_DECRYPT(tarjeta, 'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS tarjeta,
AES_DECRYPT(email, 'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS email,
AES_DECRYPT(contrasena, 'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS contrasena,

AES_DECRYPT(puntos, 'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS puntos,
redes

   FROM calimax_participantes

*/

    

/*
select 
  AES_DECRYPT( email,'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS email,
  AES_DECRYPT( email_invitado,'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS email_invitado,
  AES_DECRYPT( tarjeta,'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS tarjeta
from 
  calimax_participantes

*/

 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                      //no se usan
////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    //checar si el correo ya fue registrado
    public function check_correo_existente($data){
      $this->db->select("AES_DECRYPT(email,'{$this->key_hash}') AS email", FALSE);      
      $this->db->from($this->participantes);
      $this->db->where('email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);
      $login = $this->db->get();
      if ($login->num_rows() > 0)
        return FALSE;
      else
        return TRUE;
      $login->free_result();
    }


    //checar el login del participante
    public function check_loginconemail($data){
      $this->db->select("id", FALSE);           
      $this->db->select("AES_DECRYPT(p.email,'{$this->key_hash}') AS email", FALSE);      
      $this->db->select("AES_DECRYPT(p.nombre,'{$this->key_hash}') AS nombre", FALSE);      
      $this->db->select("AES_DECRYPT(p.apellidos,'{$this->key_hash}') AS apellidos", FALSE);      
      $this->db->select("AES_DECRYPT(p.nick,'{$this->key_hash}') AS nick", FALSE);      
      $this->db->select("AES_DECRYPT(p.telefono,'{$this->key_hash}') AS telefono", FALSE);      
      $this->db->select("AES_DECRYPT(p.contrasena,'{$this->key_hash}') AS contrasena", FALSE);

      $this->db->select("p.premiado,p.id_premio");
      
      $this->db->from($this->participantes.' as p');
      
      $this->db->where('p.contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE);
      $this->db->where('p.email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);

      $login = $this->db->get();

      if ($login->num_rows() > 0)
        return $login->result();
      else 
        return FALSE;
      $login->free_result();
    }



     //checar el login del participante
        public function check_login($data){
          $this->db->select("id", FALSE);           
          $this->db->select("AES_DECRYPT(p.email,'{$this->key_hash}') AS email", FALSE);      
          $this->db->select("AES_DECRYPT(p.nombre,'{$this->key_hash}') AS nombre", FALSE);      
          $this->db->select("AES_DECRYPT(p.apellidos,'{$this->key_hash}') AS apellidos", FALSE);      
          $this->db->select("AES_DECRYPT(p.celular,'{$this->key_hash}') AS celular", FALSE);      
          $this->db->select("AES_DECRYPT(p.contrasena,'{$this->key_hash}') AS contrasena", FALSE);

          $this->db->from($this->participantes.' as p');
            
          $this->db->where('p.email', "AES_ENCRYPT('{$data['email']}','{$this->key_hash}')", FALSE); 
          $this->db->where('p.contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE);
          $login = $this->db->get();

          if ($login->num_rows() > 0)
            return $login->result();
          else 
            return FALSE;
          $login->free_result();
        }        







	} 
?>
