<?php
class Posting_model extends CI_Model{
    public function getPosting(){
        return $this->db->get('post')->result_array();
    }
    public function getPostingById($id){
        $post = $this->db->get_where('post', ['id' => $id])->result_array();
        return $this->olahPosting($post);
    }
    public function getPostingBySkripsi($id_skripsi){
        $post = $this->db->get_where('post', ['id_skripsi' => $id_skripsi])->result_array();
        return $this->olahPosting($post);
    }
    private function olahPosting($post){
        for ($i = 0; $i < count($post); $i++){
            $skripsi = json_decode($this->curl->simple_get('http://localhost/microservice/skripsi/api/skripsi/',array('id' => $post[$i]['id_skripsi']), array(CURLOPT_BUFFERSIZE => 10)),true)['data'];
            $post[$i]['data_skripsi']=$skripsi;
        }
        return $post;
    }

    public function deletePosting($id){
        $this->db->delete('post', ['id' => $id]);
        return $this->db->affected_rows();
    }
    public function createPosting($data){
        $posting = $this->getPostingBySkripsi($data['id_skripsi']);
        if($posting){
            if($posting['tipe']=$data['tipe']){
                return null;
            }else{
                $this->db->insert('post',$data);
                return $this->db->affected_rows();
            }
        }else{
            $this->db->insert('post',$data);
            return $this->db->affected_rows();
        }
        
    }
    public function updatePosting($data,$id){
        $this->db->update('post', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}
?>