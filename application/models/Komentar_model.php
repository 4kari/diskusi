<?php
class Komentar_model extends CI_Model{
    public function getKomentar($id=null){
        if ($id === null){
            return $this->db->get('komentar')->result_array();
        } else {
            return $this->db->get_where('komentar', ['id' => $id])->row_array();
        }
    }
    public function deleteKomentar($id){
        $this->db->delete('komentar', ['id' => $id]);
        return $this->db->affected_rows();
    }
    public function createKomentar($data){
        $this->db->insert('komentar',$data);
        return $this->db->affected_rows();
    }
    public function updateKomentar($data,$id){
        $this->db->update('komentar', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}
?>