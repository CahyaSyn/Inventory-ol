<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
	public function index()
	{
		$konten = $this->load->view('barang/list_barang', null, true);
		$data_json = array(
			'konten' => $konten,
			'title' => 'List Barang',
		);
		echo json_encode($data_json);
	}

	public function form_create()
	{
		$data_view = array(
			'title' => 'Form Data Barang Baru'
		);
		$konten = $this->load->view('barang/form_barang', $data_view, true);
		$data_json = array(
			'konten' => $konten,
			'title' => 'Form Data Barang Baru'
		);
		echo json_encode($data_json);
	}

	public function form_edit($id_barang)
	{
		$data_view = array(
			'title' => 'Form Edit Data Barang',
			'id_barang' => $id_barang
		);
		$konten = $this->load->view('barang/form_barang', $data_view, true);
		$data_json = array(
			'konten' => $konten,
			'title' => 'Form Edit Data Barang',
			'id_barang' => $id_barang
		);
		echo json_encode($data_json);
	}
}
