<?php
class Tipe_model extends CI_Model{
    public function getTipe($id=null){
        if ($id === null){
            return $this->db->get('tipe')->result_array();
        } else {
            return $this->db->get_where('tipe', ['id' => $id])->row_array();
        }
    }
    public function deleteTipe($id){
        //data master tidak bisa dihapus
        $this->db->delete('tipe', ['id' => $id]);
        return $this->db->affected_rows();
    }
    public function createTipe($data){
        $this->db->insert('tipe',$data);
        return $this->db->affected_rows();
    }
    public function updateTipe($data,$id){
        $this->db->update('tipe', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}
?>