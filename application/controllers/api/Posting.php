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
        $id = $this->get('id');
        if ($id == null) {
            $Posting = $this->mposting->getPosting();
        } else{
            $Posting = $this->mposting->getPosting($id);
        }
        if ($Posting){
            $this->response([
                'status' => true,
                'data' =>$Posting
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
                'message' => 'Tambahkan id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->mposting->deletePosting($id)>0){
                //ok
                $this->response([
                    'status' => true,
                    'message' => 'Terhapus'
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
            'judul' => $this->post('judul'),
            'file' => $this->post('file'),
            'tipe' => $this->post('tipe'),
            'tanggal_dibuat' => $this->post('tanggal_dibuat')
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
        $id=$this->put('id');
        $data=[
            'judul' => $this->post('judul'),
            'file' => $this->post('file'),
            'tipe' => $this->post('tipe'),
            'tanggal_dibuat' => $this->post('tanggal_dibuat')
        ];

        if ($this->mposting->updatePosting($data,$id)>0){
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