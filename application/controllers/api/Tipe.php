<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Tipe extends REST_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Tipe_model','tm');
    }
    public function index_get(){
        $id = $this->get('id');
        if ($id == null) {
            $Tipe = $this->tm->getTipe();
        } else{
            $Tipe = $this->tm->getTipe($id);
        }
        if ($Tipe){
            $this->response([
                'status' => true,
                'data' =>$Tipe
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete(){
        $id = $this->delete('id');
        if ($id == null){
            var_dump($id);
            $this->response([
                'status' => false,
                'message' => 'tambahkan id untuk hapus'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->tm->deleteTipe($id)>0){
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
            'keterangan' => $this->post('keterangan')
        ];
        
        if ($this->tm->createTipe($data)>0){
            $this->response([
                'status' => true,
                'message' => 'Tipe baru berhasil dibuat'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal menambahkan tipe baru'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function index_put(){
        $id=$this->put('id');
        $data=[
            'keterangan' => $this->put('keterangan')
        ];

        if ($this->tm->updateTipe($data,$id)>0){
            $this->response([
                'status' => true,
                'message' => 'Tipe berhasil di perbarui'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal memperbarui data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}