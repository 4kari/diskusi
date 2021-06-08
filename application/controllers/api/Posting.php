<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Posting extends REST_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Posting_model','mposting');
    }
    public function index_get(){
        $judul = $this->get('judul');
        if ($judul == null) {
            $Posting = $this->mposting->getPosting();
        } else{
            $Posting = $this->mposting->getPosting($judul);
        }
        if ($Posting){
            $this->response([
                'status' => true,
                'data' =>$Posting
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'judul tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete(){
        $judul = $this->delete('judul');
        if ($judul == null){
            var_dump($judul);
            $this->response([
                'status' => false,
                'message' => 'Tambahkan judul'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->mposting->deletePosting($judul)>0){
                //ok
                $this->response([
                    'status' => true,
                    'message' => 'Terhapus'
                ], REST_Controller::HTTP_NO_CONTENT);
            }
            else{
                $this->response([
                    'status' => false,
                    'message' => 'judul tidak ditemukan'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }          
        }
    }
    public function index_post(){
        $data=[
            'nrp' => $this->post('judul'),
            'nama' => $this->post('file'),
            'email' => $this->post('tipe'),
            'jurusan' => $this->post('tanggal_dibuat')
        ];
        
        if ($this->mposting->createPosting($data)>0){
            $this->response([
                'status' => true,
                'message' => 'Post baru telah ditambahkan'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal menambahkan post'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function index_put(){
        $judul=$this->put('judul');
        $data=[
            'nrp' => $this->post('judul'),
            'nama' => $this->post('file'),
            'email' => $this->post('tipe'),
            'jurusan' => $this->post('tanggal_dibuat')
        ];

        if ($this->mposting->updatePosting($data,$judul)>0){
            $this->response([
                'status' => true,
                'message' => 'Data post telah diperbarui'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal memperbarui data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}