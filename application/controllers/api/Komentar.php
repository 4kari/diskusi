<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Komentar extends REST_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Komentar_model','mkomentar');
    }
    public function index_get(){
        $id = $this->get('id');
        if ($id == null) {
            $Komentar = $this->mkomentar->getKomentar();
        } else{
            $Komentar = $this->mkomentar->getKomentar($id);
        }
        if ($Komentar){
            $this->response([
                'status' => true,
                'data' =>$Komentar
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete(){
        $id = $this->delete('id');
        if ($id == null){
            $this->response([
                'status' => false,
                'message' => 'tambahkan id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->mkomentar->deleteKomentar($id)>0){
                //ok
                $this->response([
                    'status' => true,
                    'message' => 'terhapus'
                ], REST_Controller::HTTP_NO_CONTENT);
            }
            else{
                $this->response([
                    'status' => false,
                    'message' => 'id tidak ditemukan'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }          
        }
    }
    public function index_post(){
        $data=[
            'id_post' => $this->post('id_post'),
            'waktu' => $this->post('waktu'),
            'pesan' => $this->post('pesan'),
            'pengirim' => $this->post('pengirim'),
            'file' => $this->post('file')
        ];
        
        if ($this->mkomentar->createKomentar($data)>0){
            $this->response([
                'status' => true,
                'message' => 'komentar baru ditambahkan'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'gagal menambahkan data baru'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function index_put(){
        $id=$this->put('id');
        $data=[
            'id_post' => $this->post('id_post'),
            'waktu' => $this->post('waktu'),
            'pesan' => $this->post('pesan'),
            'pengirim' => $this->post('pengirim'),
            'file' => $this->post('file')
        ];

        if ($this->mkomentar->updateKomentar($data,$id)>0){
            $this->response([
                'status' => true,
                'message' => 'komentar telah diperbarui'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else {
            $this->response([
                'status' => false,
                'message' => 'gagal memperbarui komentar'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}