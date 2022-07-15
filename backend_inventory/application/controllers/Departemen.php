<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Departemen extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('Departemen_model');
	}

	public function index()
	{
		$konten = $this->load->view('departemen/list_departemen', null, true);

		$data_json = array(
			'konten' => $konten,
			'title' => 'List Data Departemen',
		);

		echo json_encode($data_json);
	}

	public function list_departemen()
	{
		$data_departemen = $this->Departemen_model->get_departemen();

		$konten = '<tr>
			<td><strong>ID</strong></td>
			<td><strong>Nama Departemen</strong></td>
			<td><strong>Aksi</strong></td>
		</tr>';

		foreach ($data_departemen->result() as $key => $value) {
			$konten .= '<tr>
				<td>' . $value->id_departemen . '</td>
				<td>' . $value->nama_departemen . '</td>
				<td>Read | Hapus | Edit</td>
			</tr>';
		}

		$data_json = array(
			'konten' => $konten,
		);

		echo json_encode($data_json);
	}
}
