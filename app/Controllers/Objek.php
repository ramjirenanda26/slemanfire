<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TabelObjekModel;

class Objek extends BaseController
{
    protected $TableObjekModel;

    public function __construct()
    {
        $this->TabelObjekModel = new TabelObjekModel();
        $this->data['validation'] = \config\Services::validation();   
    }

    public function index()
    {
        session();
        return view('v_input', $this->data);
    }

    public function view()
    {
        return view('v_map');
    }


    public function table()
    {
        $data['objek'] = $this->TabelObjekModel->findAll();

        return view('v_table', $data);

    }
    public function hapus($id)
    {
        $this->TabelObjekModel->delete($id);

        return redirect()->to('objek/table')->with('message', 'Data berhasil dihapus');

    }

    public function edit($id){
        $data['objek']= $this->TabelObjekModel->find($id);

        return view('v_edit', $data);
    }
    public function simpantambahdata()
    {
        if(!$this->validate([
            'input_nama' => [
                'rules' => 'required',
                'errors' => [
                    'required'=>'Kolom nama objek harus diisi.'
                    ]
                ],
                'input_longitude'=>[
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required'=> 'Kolom longitude harus diisi.',
                        'numeric' => 'Kolom longitude harus berupa angka.'
                    ]
                ],
                'input_latitude'=>[
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required'=> 'Kolom latitude harus diisi.',
                        'numeric' => 'Kolom latitude harus berupa angka.'
                    ]
                ],
                'input_foto'=>[
                    'rules' => 'max_size[input_foto, 1024]|is_image[input_foto]mime_in
                    [input_foto,image/jpg,image/jpeg,image/png]',

                    'errors'=>[
                        'max_size' => 'Ukuran foto maksimal 1mb',
                        'mime_in' => 'File yang diupload harus berupa gambar JPG/JPEG/PNG'
                    ]
                ]


        ])){
            return redirect()->to('objek')->with("message", 'Gagal menambah data lokasi objek.')->withInput();
        }

        //Upload foto
        $file_foto = $this->request->getFile('input_foto');

        if ($file_foto->getError() == 4) {
            $nama_foto = NULL;
        }else {
            $foto_dir = 'upload/foto/';
            if (!is_dir($foto_dir)) {
                mkdir($foto_dir, 0777, TRUE);
            }
            $nama_foto = 'foto_' . preg_replace('/\s+/', '', $_POST['input_nama']) . '.' .
            $file_foto->getExtension();
            //memindahkan file
            $file_foto->move($foto_dir, $nama_foto);
        }
        $data =[
            'nama' => $_POST['input_nama'],
            'deskripsi' => $_POST['input_deskripsi'],
            'longitude' => $_POST['input_longitude'],
            'latitude' => $_POST['input_latitude'],
            'foto' => $nama_foto,

        ];

        $this->TabelObjekModel->save($data);

        return redirect()-> to('objek')->with('message', 'Data berhasil ditambahkan');
    }
    public function simpaneditdata($id)
    {
        session();

        //Upload foto
        $file_foto = $this->request->getFile('input_foto');

        if ($file_foto->getError() == 4) {
            if ($_POST ['input_foto_lama'] !==''){
                $nama_foto = $_POST['input_foto_lama'];
            }else {
                $nama_foto = NULL;
            }

            }else {
                $foto_dir = 'upload/foto/';
                if (!is_dir($foto_dir)) {
                    mkdir($foto_dir, 0777, TRUE);
                }                
            

            //Cek foto lama existing
            if ($_POST['input_foto_lama'] !==''){
                if (file_exists($foto_dir . $_POST['input_foto_lama'])){
                    unlink($foto_dir . $_POST['input_foto_lama']);
                }
            }      

            $nama_foto = 'foto_' . preg_replace('/\s+/', '', $_POST['input_nama']) . '.' .
            $file_foto->getExtension();


            //memindahkan file
            $file_foto->move($foto_dir, $nama_foto);
        }
        $data =[
            'id' => $id,
            'nama' => $_POST['input_nama'],
            'deskripsi' => $_POST['input_deskripsi'],
            'longitude' => $_POST['input_longitude'],
            'latitude' => $_POST['input_latitude'],
            'foto' => $nama_foto,

        ];

        $this->TabelObjekModel->save($data);

        return redirect()-> to('objek/table')->with('message', 'Data berhasil diubah');
    }
    public function map()
    {
        return view('v_view_map');
    }

    
}
