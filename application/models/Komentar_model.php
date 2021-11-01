<?php
class Komentar_model extends CI_Model{
    public function getKomentar(){
        return $this->db->get('komentar')->result_array();
    }
    public function getKomentarById($id){
        return $this->db->get_where('komentar', ['id' => $id])->result_array();
    }
    public function getKomentarByIdPost($id){
        $komentar = $this->db->get_where('komentar', ['id_post' => $id])->result_array();
        for ($i=0;$i<count($komentar);$i++){
            // $user = json_decode($this->curl->simple_get('http://10.5.12.26/user/api/user/',array('username'=>$komentar['pengirim']))true);
            $user = json_decode($this->curl->simple_get('http://localhost/microservice/user/api/user/', array('username'=>$komentar[$i]['pengirim'])),true)['data'][0];

            if($user['level']==3){
            // $profil = json_decode($this->curl->simple_get('http://10.5.12.26/user/api/dosen/', array(CURLOPT_BUFFERSIZE => 10)),true)['data'];
            $profil = json_decode($this->curl->simple_get('http://localhost/microservice/user/api/dosen/', array('nip'=>$user['username']), array(CURLOPT_BUFFERSIZE => 10)),true)['data'];
            }else{
            // $profil = json_decode($this->curl->simple_get('http://10.5.12.26/user/api/mahasiswa/', array(CURLOPT_BUFFERSIZE => 10)),true)['data'];
            $profil = json_decode($this->curl->simple_get('http://localhost/microservice/user/api/mahasiswa/', array('nim'=>$user['username']), array(CURLOPT_BUFFERSIZE => 10)),true)['data'];
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