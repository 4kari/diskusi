<?php
class Komentar_model extends CI_Model{
    public function getKomentar(){
        return $this->db->get('komentar')->result_array();
    }
    public function getKomentarById($id){
        return $this->db->get_where('komentar', ['id' => $id])->result_array();
    }
    public function getKomentarByIdPost($id){
        return $this->db->get_where('komentar', ['id_post' => $id])->result_array();
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