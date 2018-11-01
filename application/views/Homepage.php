<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Test Marlin 2</title>
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
</head>
<body>
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">Data Pengiriman</div>
		<div class="panel-body">
			<div class="form-group">
				<label for="kota_asal">Kota/Kabupaten Asal:</label>
				<select class="form-control" id="kota_asal" name="kota_asal">
				<?php for($i=0; $i < count($kota_asal); $i++) { ?>
					<option value="<?php echo $kota_asal[$i]['city_id'] ?>"><?php echo $kota_asal[$i]['city_name'] ?></option>
				<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label for="provinsi">Provinsi Tujuan:</label>
				<select class="form-control" id="provinsi" name="provinsi">
				<?php for($i=0; $i < count($prov_tujuan); $i++) { ?>
					<option value="<?php echo $prov_tujuan[$i]['province_id'] ?>"><?php echo $prov_tujuan[$i]['province'] ?></option>
				<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label for="kabupaten">Kota/Kabupaten Tujuan</label><br>
				<select class="form-control" id="kabupaten" name="kabupaten"></select>
			</div>
			<div class="form-group">
				<label for="kurir">Kurir</label><br>
				<select class="form-control" id="kurir" name="kurir">
					<option value="jne">JNE</option>
					<option value="tiki">TIKI</option>
					<option value="pos">POS INDONESIA</option>
				</select>
			</div>
			<div class="form-group">
				<label for="berat">Berat (gram)</label><br>
				<input class="form-control" id="berat" type="number" name="berat" value="500" />
			</div>
			<div class="text-center">
				<button class="btn btn-success" id="cek" type="submit" name="button">Cek Ongkir</button>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">Ongkir</div>
		<div class="panel-body" id="ongkir">
			
		</div>
	</div>
</div>
</body>
<script src="<?php echo base_url('assets/JQuery/jquery-2.1.4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript">
$(document).ready(function(){

	$('#provinsi').change(function(){
		var prov = $('#provinsi').val();
		 
		$.ajax({
			type : 'GET',
			url : '<?php echo site_url('homepage/cek_kota/') ?>' + prov,
			success: function (data) {
				//jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
				$("#kabupaten").html(data);
			}
		});
	});

	$('#provinsi').trigger('change');

	$("#cek").click(function(){
		var asal = $('#kota_asal').val();
		var kab = $('#kabupaten').val();
		var kurir = $('#kurir').val();
		var berat = $('#berat').val();

		$.ajax({
			type : 'POST',
			url : '<?php echo site_url('homepage/cek_ongkir') ?>',
			data : {'kab_id' : kab, 'kurir' : kurir, 'asal' : asal, 'berat' : berat},
			success: function (data) {
				$("#ongkir").html(data);
			}
		});
	});

});
</script>
</html>