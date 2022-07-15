<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('Barang_model');
	}

	public function index()
	{
		$konten = $this->load->view('barang/list_barang', null, true);
		$data_json = array(
			'konten' => $konten,
			'title' => 'List Barang',
		);
		echo json_encode($data_json);
	}

	public function list_barang()
	{
		$data_barang = $this->Barang_model->getBarang();

		$konten = '<thead class="table-dark text-center">
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Deskripsi</th>
							<th>Stock</th>
							<th>Foto</th>
							<th>Opsi</th>
						</tr>
					</thead>';

		foreach ($data_barang->result() as $key => $value) {
			$no = 1;
			$konten .= '
					<tbody>
						<tr>
							<td class="fw-bold text-center">' . $no++ . '</td>
							<td>' . $value->nama_barang . '</td>
							<td>' . $value->deskripsi . '</td>
							<td class="text-center">' . $value->stok . '</td>
							<td class="text-center"><img src="' . base_url() . '/foto/' . $value->id_barang . '/' . $value->foto_produk . '"width="50"></td>
							<td class="text-center">Read | <a href="#' . $value->id_barang . '" class="linkHapusBarang">Hapus</a> | <a href="#' . $value->id_barang . '" class="linkEditBarang">Edit</a></td>
						</tr>
					</tbody>';
		}

		$data_json = array(
			'konten' => $konten
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

	private function upload_foto($id_barang, $files)
	{
		$gallerPath = realpath(APPPATH . '../foto');
		$path = $gallerPath . '/' . $id_barang;
		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}
		$konfigurasi = array(
			'allowed_types' => 'jpg|jpeg|png|gif',
			'upload_path' => $path,
			'overwrite' => true,
		);

		$this->load->library('upload', $konfigurasi);
		$_FILES['file']['name'] = $files['file']['name'];
		$_FILES['file']['type'] = $files['file']['type'];
		$_FILES['file']['tmp_name'] = $files['file']['tmp_name'];
		$_FILES['file']['error'] = $files['file']['error'];
		$_FILES['file']['size'] = $files['file']['size'];

		if ($this->upload->do_upload('file')) {
			$data_barang = array(
				'foto_produk' => $this->upload->data('file_name')
			);
			$this->Barang_model->update_data($id_barang, $data_barang);
			return 'Success Upload';
		} else {
			return 'Error Upload';
		}
	}

	public function create_action()
	{
		$this->db->trans_start();
		$arr_input = array(
			'nama_barang' => $this->input->post('nama_barang'),
			'deskripsi' => $this->input->post('deskripsi'),
		);
		$this->Barang_model->insert_data_barang($arr_input);

		$id_barang = $this->db->insert_id();
		if ($_FILES != null) {
			$this->upload_foto($id_barang, $_FILES);
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$data_output = array(
				'sukses' => 'tidak', 'pesan' => 'Gagal Input Data Barang'
			);
		} else {
			$this->db->trans_commit();
			$data_output = array(
				'sukses' => 'ya', 'pesan' => 'Berhasil Input Data Barang'
			);
		}
		echo json_encode($data_output);
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

	public function update_action()
	{
		$this->db->trans_start();
		$id_barang = $this->input->post('id_barang');
		$arr_input = array(
			'nama_barang' => $this->input->post('nama_barang'),
			'deskripsi' => $this->input->post('deskripsi'),
		);
		$this->Barang_model->update_data($id_barang, $arr_input);

		if ($_FILES != null) {
			$this->upload_foto($id_barang, $_FILES);
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$data_output = array(
				'sukses' => 'tidak', 'pesan' => 'Gagal Update Data Barang'
			);
		} else {
			$this->db->trans_commit();
			$data_output = array(
				'sukses' => 'ya', 'pesan' => 'Berhasil Update Data Barang'
			);
		}
		echo json_encode($data_output);
	}
	public function delete_data()
	{
		$this->db->trans_start();
		$id_barang = $this->input->get('id_barang');
		$this->Barang_model->deleteBarang($id_barang);
		if ($this->db->trans_status() == FALSE) {
			$this->db->trans_rollback();
			$data_output = array(
				'sukses' => 'tidak', 'pesan' => 'Gagal hapus data barang'
			);
		} else {
			$this->db->trans_commit();
			$data_output = array(
				'sukses' => 'ya', 'pesan' => 'Berhasil hapus data barang'
			);
		}
		echo json_encode($data_output);
	}

	public function soft_delete_data()
	{
		$this->db->trans_start();
		$id_barang = $this->input->get('id_barang');
		$this->Barang_model->soft_delete_data($id_barang);
		if ($this->db->trans_status() == FALSE) {
			$this->db->trans_rollback();
			$data_output = array(
				'sukses' => 'tidak', 'pesan' => 'Gagal hapus data barang'
			);
		} else {
			$this->db->trans_commit();
			$data_output = array(
				'sukses' => 'ya', 'pesan' => 'Berhasil hapus data barang'
			);
		}
		echo json_encode($data_output);
	}

	public function cari_barang()
	{
		$nama_barang = $this->input->post('cari_nama');
		$deskripsi = $this->input->post('cari_desk');
		$stok = $this->input->post('cari_stok');

		$data_barang = $this->Barang_model->getBarang($nama_barang, $deskripsi, $stok);

		$konten = '<tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Stok</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                   </tr>';

		foreach ($data_barang->result() as $key => $value) {
			$konten .= '<tr>
                            <td>' . $value->nama_barang . '</td>
                            <td>' . $value->deskripsi . '</td>
                            <td>' . $value->stok . '</td>
							<td><img src="' . base_url() . '/foto/' . $value->id_barang . '/' . $value->foto_produk . '"width="50"></td>
                            <td>Read | <a href="#' . $value->id_barang . '" class="linkHapusBarang">Hapus</a> | <a href="#' . $value->id_barang . '" class="linkEditBarang">Edit</a></td>
                        </tr>';
		};
		$data_json = array(
			'konten' => $konten
		);
		echo json_encode($data_json);
	}
}
