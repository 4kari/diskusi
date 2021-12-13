<?php
class Posting_model extends CI_Model{
    // protected $ipSkripsi='http://10.5.12.21/skripsi/api/';
    // protected $ipPenjadwalan='http://10.5.12.47/penjadwalan/api/';
    // protected $ipDiskusi='http://10.5.12.56/diskusi/api/';
    // protected $ipUser='http://10.5.12.16/user/api/';

    protected $ipSkripsi='http://localhost/microservice/skripsi/api/';
    protected $ipPenjadwalan='http://localhost/microservice/penjadwalan/api/';
    protected $ipDiskusi='http://localhost/microservice/diskusi/api/';
    protected $ipUser='http://localhost/microservice/user/api/';
    
    public function getPosting(){
        return $this->db->get('post')->result_array();
    }
    public function getPostingById($id){
        $post = $this->db->get_where('post', ['id' => $id])->result_array();
        return $this->olahPosting($post);
    }
    public function getPostingBySkripsi($id_skripsi){
        $post = $this->db->get_where('post', ['id_skripsi' => $id_skripsi])->result_array();
        $post = $this->olahPosting($post);
        return $post;
    }
    
    public function getPostingByNip($nip){
        $skripsi = json_decode($this->curl->simple_get($this->ipSkripsi.'Skripsi/',array('nip'=>$nip), array(CURLOPT_BUFFERSIZE => 10)),true)['data'];

        //update data skripsi status dosen
        for ($i=0;$i<count($skripsi);$i++){
            $sebagai="";
            if($skripsi[$i]['pembimbing_1']==$nip){$sebagai="pembimbing_1";}
            elseif($skripsi[$i]['pembimbing_2']==$nip){$sebagai="pembimbing_2";}
            elseif($skripsi[$i]['penguji_1']==$nip){$sebagai="penguji_1";}
            elseif($skripsi[$i]['penguji_2']==$nip){$sebagai="penguji_2";}
            elseif($skripsi[$i]['penguji_3']==$nip){$sebagai="penguji_3";}
            $skripsi[$i]['sebagai'] = $sebagai;
        }
        $posting=$this->db->get('post')->result_array();
        $hasil=[];
        foreach($posting as $p){
            foreach ($skripsi as $s){
                if($p['id_skripsi']==$s['id']){
                    $p['data_skripsi']=$s;
                    array_push($hasil,$p);
                }
            }
        }
        return $hasil;
    }
    private function olahPosting($post){
        for ($i = 0; $i < count($post); $i++){
            $skripsi = json_decode($this->curl->simple_get($this->ipSkripsi.'skripsi/',array('id' => $post[$i]['id_skripsi']), array(CURLOPT_BUFFERSIZE => 10)),true)['data'];
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
            if($posting[$data['tipe']-1]){
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