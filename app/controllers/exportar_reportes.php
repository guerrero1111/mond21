<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Exportar_reportes extends CI_Controller {
 
    function __construct() {
        parent::__construct();
        $this->load->model('admin/modelo', 'modelo'); 
        
        

    }
    




 public function exportar()  {
        $this->load->library('export');
        $data['busqueda'] = ($this->input->post('busqueda'));
        $data['tipo_reporte'] = ($this->input->post('tipo_reporte'));
        $data['id_region'] = ($this->input->post('id_region'));
        $nombre_completo=$this->session->userdata('nombre_completo');
        //echo $data['tipo_reporte'];
        
        // 2- ordenar por factura
        switch($data['tipo_reporte']) {

                   

            
            case "reportes_participante":
                $data['movimientos'] = $this->modelo->exportar_participantes($data);
                
                
                if ($data['movimientos']) {
                    $this->export->to_excel($data['movimientos'], 'reporte_participante_'.date("Y-m-d_H-i-s").'-'.$nombre_completo);
                }    
                
                break; 


            case "exportar_todo":
                $data['movimientos'] = $this->modelo->exportar_todo($data);
                
                
                if ($data['movimientos']) {
                    $this->export->to_excel($data['movimientos'], 'reporte_participante_todo'.date("Y-m-d_H-i-s").'-'.$nombre_completo);
                }    
                
                break; 
                

            default:
        }

}


}