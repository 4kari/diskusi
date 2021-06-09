<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Catatan extends REST_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Catatan_model','mCatatan');
    }
    public function index_get(){
        $id = $this->get('id');
        if ($id == null) {
            $Catatan = $this->mCatatan->getCatatan();
        } else{
            $Catatan = $this->mCatatan->getCatatan($id);
        }
        if ($Catatan){
            $this->response([
                'status' => true,
                'data' =>$Catatan
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
            $this->response([
                'status' => false,
                'message' => 'tambahkan id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->mCatatan->deleteCatatan($id)>0){
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
            'tipe' => $this->post('tipe'),
            'pesan' => $this->post('pesan'),
            'pengirim' => $this->post('pengirim'),
            'validasi' => $this->post('validasi'),
            'waktu' => $this->post('waktu')
        ];
        
        if ($this->mCatatan->createCatatan($data)>0){
            $this->response([
                'status' => true,
                'message' => 'Catatan baru ditambahkan'
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
            'tipe' => $this->put('tipe'),
            'pesan' => $this->put('pesan'),
            'pengirim' => $this->put('pengirim'),
            'validasi' => $this->put('validasi'),
            'waktu' => $this->put('waktu')
        ];
        if ($this->mCatatan->updateCatatan($data,$id)>0){
            $this->response([
                'status' => true,
                'message' => 'Catatan telah diperbarui'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else {
            $this->response([
                'status' => false,
                'message' => 'gagal memperbarui Catatan'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}