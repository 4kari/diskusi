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
    public function getPostingByNip($nip){
        //ambil semua data skripsi dengan nip
        $skripsi = json_decode($this->curl->simple_get('http://localhost/microservice/skripsi/api/Skripsi/',array('nip'=>$nip), array(CURLOPT_BUFFERSIZE => 10)),true)['data'];
        // $skripsi = json_decode($this->curl->simple_get('http://10.5.12.21/skripsi/api/skripsi/',array('nip'=>$nip), array(CURLOPT_BUFFERSIZE => 10)),true)['data];

        //update data skripsi status dosen
        for ($i=0;$i<count($skripsi);$i++){
            $sebagai="";
            if($skripsi[$i]['pembimbing_1']==$nip){$sebagai="pembimbing_1";}
            elseif($skripsi[$i]['pembimbing_2']==$nip){$sebagai="pembimbing_2";}
            elseif($skripsi[$i]['penguji_1']==$nip){$sebagai="penguji_1";}
            elseif($skripsi[$i]['penguji_2']==$nip){$sebagai="penguji_2";}
            elseif($skripsi[$i]['penguji_3']==$nip){$sebagai="penguji_3";}
            $skripsi[$i]['sebagai']=$sebagai;
        }
        $post=[];//inisialisasi post
        //looping untuk ambil postingan dari setiap skripsi
        for ($i=0;$i<count($skripsi);$i++){
            if($skripsi[$i]['status']>=1 && $skripsi[$i]['status']<=7){
                $id_skripsi=$skripsi[$i]['id'];
                $post[$i]=$this->db->get_where('post', ['id_skripsi' => $id_skripsi])->row_array();
                if($post[$i]){
                    $post[$i]['data_skripsi']=$skripsi[$i];
                }
            }
        }
        $hasil=[[],[],[]];
        for ($i=0;$i<count($post);$i++){
            if($post[$i]['tipe']==1){
                array_push($hasil[0],$post[$i]);
            }elseif($post[$i]['tipe']==2){
                array_push($hasil[1],$post[$i]);
            }else{
                array_push($hasil[2],$post[$i]);
            }
        }
        return $hasil;
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