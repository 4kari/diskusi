<?php
class Posting_model extends CI_Model{
    public function getPosting($judul=null){
        if ($judul === null){
            return $this->db->get('post')->result_array();
        } else {
            return $this->db->get_where('post', ['judul' => $judul])->row_array();
        }
    }
    public function deletePosting($judul){
        $this->db->delete('post', ['judul' => $judul]);
        return $this->db->affected_rows();
    }
    public function createPosting($data){
        $this->db->insert('post',$data);
        return $this->db->affected_rows();
    }
    public function updatePosting($data,$judul){
        $this->db->update('post', $data, ['judul' => $judul]);
        return $this->db->affected_rows();
    }
}
?>