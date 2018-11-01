<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends CI_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->library('rajaongkir');
	}

	public function index()
	{
		$content['kota_asal'] = json_decode($this->rajaongkir->city(5), true)['rajaongkir']['results'];
		$content['prov_tujuan'] = json_decode($this->rajaongkir->province(), true)['rajaongkir']['results'];
		$this->load->view('homepage', $content);
	}

	public function cek_kota($prov_id = null)
	{
		if ($prov_id == null) echo "";

		$kota = json_decode($this->rajaongkir->city($prov_id), true)['rajaongkir']['results'];
		for ($i=0; $i < count($kota); $i++) {
			echo "<option value='".$kota[$i]['city_id']."'>".$kota[$i]['city_name']."</option>";
		}
	}

	public function cek_ongkir()
	{
		$asal = $_POST['asal'];
		$id_kabupaten = $_POST['kab_id'];
		$kurir = $_POST['kurir'];
		$berat = $_POST['berat'];

		$data = json_decode($this->rajaongkir->cost($asal, $id_kabupaten, $berat, $kurir), true);

		echo $data['rajaongkir']['origin_details']['city_name']." ke ".$data['rajaongkir']['destination_details']['city_name']." @".$berat."gram. Kurir: ".strtoupper($kurir)."\n";

		for ($k=0; $k < count($data['rajaongkir']['results']); $k++) {
		echo "<div title=\"".strtoupper($data['rajaongkir']['results'][$k]['name'])."\" style=\"padding:10px\">
			<table class=\"table table-striped\">
			<tr>
				<th>No.</th>
				<th>Jenis Layanan</th>
				<th>ETD</th>
				<th>Tarif</th>
			</tr>";
			if (count($data['rajaongkir']['results'][$k]['costs']) > 0) {
				for ($l=0; $l < count($data['rajaongkir']['results'][$k]['costs']); $l++) {
				echo "<tr>
					<td>".($l+1)."</td>
					<td>
					<div style=\"font:bold 16px Arial\">".$data['rajaongkir']['results'][$k]['costs'][$l]['service']."</div>
					<div style=\"font:normal 11px Arial\">".$data['rajaongkir']['results'][$k]['costs'][$l]['description']."</div>
					</td>
					<td align=\"left\">&nbsp;".$data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['etd']." days</td>
					<td align=\"left\">Rp ".number_format($data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['value'])."</td>
					</tr>";
				}
			} else {
				echo "<tr>
					<td colspan=\"4\" class=\"text-center\">Tidak ditemukan data pengiriman</td>
					</tr>";
			}
			echo "</table></div>";
		}
	}
}
