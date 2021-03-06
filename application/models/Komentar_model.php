<?php
class Komentar_model extends CI_Model{
    // protected $ipSkripsi='http://10.5.12.24/skripsi/api/';
    // protected $ipPenjadwalan='http://10.5.12.82/penjadwalan/api/';
    // protected $ipDiskusi='http://10.5.12.56/diskusi/api/';
    // protected $ipUser='http://10.5.12.18/user/api/';

    protected $ipSkripsi='http://localhost:8080/microservice/skripsi/api/';
    protected $ipPenjadwalan='http://localhost:8080/microservice/penjadwalan/api/';
    protected $ipDiskusi='http://localhost:8080/microservice/diskusi/api/';
    protected $ipUser='http://localhost:8080/microservice/user/api/';
    
    public function getKomentar(){
        return $this->db->get('komentar')->result_array();
    }
    public function getKomentarById($id){
        return $this->db->get_where('komentar', ['id' => $id])->result_array();
    }
    public function getKomentarByIdPost($id){
        $komentar = $this->db->get_where('komentar', ['id_post' => $id])->result_array();
        for ($i=0;$i<count($komentar);$i++){
            $user = json_decode($this->curl->simple_get($this->ipUser.'user/', array('username'=>$komentar[$i]['pengirim'])),true)['data'][0];

            if($user['level']==3){
            $profil = json_decode($this->curl->simple_get($this->ipUser.'dosen/', array('nip'=>$user['username']), array(CURLOPT_BUFFERSIZE => 10)),true)['data'];
            }else{
            $profil = json_decode($this->curl->simple_get($this->ipUser.'mahasiswa/', array('nim'=>$user['username']), array(CURLOPT_BUFFERSIZE => 10)),true)['data'];
            }
            $komentar[$i]['npengirim'] = $profil['nama'];
        }
        return $komentar;
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