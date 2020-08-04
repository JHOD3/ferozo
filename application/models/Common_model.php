<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class COMMON_MODEL extends CI_Model {
    public function insert_data($data,$tbl_name){
		$sql = $this->db->insert($tbl_name,$data);
		// return ( $this->db->insert_id() );
		return $data['id'];
	}	  
   // public function get_data($tbl,$field,$value,$limit=0,$limit_start=0){
		// if(!empty($field)){
			// $this->db->where($field,$value);
		// }
		// if(!empty($limit)){
			// $this->db->limit($limit, $limit_start);
		// }
		
		// $this->db->order_by('id','DESC');
		// return $this->db->get($tbl)->result_array();
	// }
	
	public function get_data($tbl){
		$this->db->order_by('id','DESC');
		return $this->db->get($tbl)->result_array();
	}
	 	
	public function update($tbl,$data,$field,$value){
		$this->db->where($field,$value);
		return $this->db->update($tbl,$data);
	}	
	public function get_rows($tbl,$field=0,$value=0)	{
		if(!empty($field)){
			$this->db->where($field,$value);
		}
		return $this->db->get($tbl)->num_rows();
	}	
	public function get_data_by_id($tbl,$field=0,$value=0){
		if(!empty($field)){
			$this->db->where($field,$value);
		}
		return $this->db->get($tbl)->row_array();
	}	
	
	public function delete($tbl,$field=0,$value=0){
		$this->db->where($field,$value);
		return $this->db->delete($tbl);
	}
	public function count_data_with_id($tbl,$field=0,$value=0){
		if(!empty($field)){
			$this->db->where($field,$value);
		}
		return $this->db->count_all_results($tbl);
	}
	
	public function get_join_data($tbl1,$tbl2,$clm1,$clm2){
		$this->db->select('c.*,u.name as username');
		$this->db->from($tbl1.' as c');
		$this->db->join($tbl2.' as u','u.'.$clm2.'=c.'.$clm1);
		$this->db->where('c.status','1');
		$this->db->order_by('c.created_at','DESC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_join_data_packages($tbl1,$tbl2,$tbl3,$clm1,$clm2,$clm3){
		$this->db->select('p.*,u.name as username,c.name as container_name');
		$this->db->from($tbl1.' as p');
		$this->db->join($tbl3.' as u','u.'.$clm3.'=p.'.$clm1);
		$this->db->join($tbl2.' as c','c.'.$clm3.'=p.'.$clm2);
		$this->db->where('p.status','1');
		$this->db->order_by('p.created_at','DESC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_data_by_id_rows($tbl,$field=0,$value=0){
		if(!empty($field)){
			$this->db->where($field,$value);
			$this->db->where('status','1');
		}
		return $this->db->get($tbl)->result_array();
	}
	
	public function get_max_value($tbl,$clm,$key,$val){
		$this->db->select_max($clm);
		$this->db->where($key,$val);
		$query = $this->db->get($tbl);
		return $query->row_array();
	}
	
	
	
	
	
}
