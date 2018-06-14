<?php
class Model_m_numberings extends CI_Model{
    function list_data(){
        $data = $this->db->get('m_numberings');
        return $data;
    }

    function cek_data($code){
        $data = $this->db->query("Select * From m_numberings Where prefix='".$code."'");        
        return $data;
    }
    
    function show_data($id){
        $data = $this->db->query("Select * From m_numberings Where id=".$id);        
        return $data;
    }
    	
    function getNumbering($bill_type, $date=null){        		
        $MNumbers = $this->db->query("Select * From m_numberings Where "
                . "prefix='".$bill_type."' order by id limit 1 ")->row_array();  
       
        if(count($MNumbers) > 0){
            //Generate Prefix
            $prefix      = $MNumbers['prefix'];
            
            $prefix .= $MNumbers['prefix_separator'];
            if($MNumbers['date_info']==1){
                if($date != null || $date !=""){
                    $date = $date;
                }else{				
                    $date =date('Y-m-d');
                }
                $prefix .= date('dmY', strtotime($date));
            }          
            $padding = $MNumbers['padding'];            

            //Cek Prefix            
            $MNumberDetails = $this->db->query("Select * From m_numbering_details Where "
                    . "prefix='".$prefix."' order by id limit 1 ")->row_array();  

            if(count($MNumberDetails) > 0){
                //Jika ada ambil last_number
                $last_number    = $MNumberDetails['last_number'];
                $current_number = $last_number + 1;

                $this->db->query("UPDATE m_numbering_details SET last_number='".$current_number."' WHERE prefix='".$prefix."'");
            }else{
                //Jika belum ada insert prefix dan mulai penomoran dari 1
                $current_number = 1;
                $this->db->query("INSERT INTO m_numbering_details(prefix, last_number)VALUES('".$prefix."', '".$current_number."')");
            }
                $code = str_pad($current_number,$padding,0,STR_PAD_LEFT);
                $code = $prefix.$MNumbers['date_separator'].$code;
        }else{
            $code = '';
        }
        return $code;
    }
}