<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_model extends CI_Model
{
	public function getBarang($nama_barang = '', $deskripsi = '', $stok = '')
	{
		if ($nama_barang != '' && $nama_barang != null) {
			$this->db->like('nama_barang', $nama_barang);
		}
		if ($deskripsi != '' && $deskripsi != null) {
			$this->db->like('deskripsi', $deskripsi);
		}
		if ($stok != '' && $stok != null) {
			$this->db->like('stok', $stok);
		}
		return $this->db->select('*')->where('status_delete', 0)->get('barang');
	}
	public function getDepartemen()
	{
		$this->db->select('*');
		$this->db->from('departemen');
		return $this->db->get();
	}
	public function insert_data_barang($data)
	{
		$this->db->insert('barang', $data);
	}

	public function getById($id_barang)
	{
		return $this->db->select('*')
			->where('id_barang', $id_barang)
			->get('barang');
	}
	public function update_data($id_barang, $arr_input)
	{
		$this->db->where('id_barang', $id_barang);
		$this->db->update('barang', $arr_input);
	}

	public function deleteBarang($id_barang)
	{
		$this->db->where('id_barang', $id_barang);
		$this->db->delete('barang');
	}
	public function soft_delete_data($id_barang)
	{
		$data = [
			'status_delete' => 1
		];
		$this->db->where('id_barang', $id_barang);
		$this->db->update('barang', $data);
	}
}
