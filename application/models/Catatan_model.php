<?php
class Catatan_model extends CI_Model{
    public function getCatatan($id=null){
        if ($id === null){
            return $this->db->get('Catatan')->result_array();
        } else {
            return $this->db->get_where('Catatan', ['id' => $id])->row_array();
        }
    }
    public function deleteCatatan($id){
        $this->db->delete('Catatan', ['id' => $id]);
        return $this->db->affected_rows();
    }
    public function createCatatan($data){
        $this->db->insert('Catatan',$data);
        return $this->db->affected_rows();
    }
    public function updateCatatan($data,$id){
        $this->db->update('Catatan', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}
?>