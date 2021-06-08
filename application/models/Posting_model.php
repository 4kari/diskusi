<?php
class Posting_model extends CI_Model{
    public function getPosting($id=null){
        if ($id === null){
            return $this->db->get('post')->result_array();
        } else {
            return $this->db->get_where('post', ['id' => $id])->row_array();
        }
    }
    public function deletePosting($id){
        $this->db->delete('post', ['id' => $id]);
        return $this->db->affected_rows();
    }
    public function createPosting($data){
        $this->db->insert('post',$data);
        return $this->db->affected_rows();
    }
    public function updatePosting($data,$id){
        $this->db->update('post', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}
?>