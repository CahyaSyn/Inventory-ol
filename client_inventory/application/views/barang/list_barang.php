<div class="card mt-5">
	<h5 class="d-flex justify-content-between align-items-center card-header bg-dark text-white">Data Barang<a href="#" class="btn btn-primary" type="button" style="border-radius: 4px;" onclick="loadMenu('<?= base_url('barang/form_create') ?>')">Tambah Data</a></h5>
	<div class="card-body">
		<div class="d-sm-flex row">
			<div class="input-group input-group-sm d-flex justify-content-center align-items-sm-center" style="margin: 0px;margin-right: 0px;margin-left: 0px;">
				<div class="input-group-text" style="margin-right: 10px;border-radius: 4px;"><span class="fw-bold" style="margin-right: 10px;">Nama</span><input type="text" name="cari_nama" id="cari_nama" class="form-control form-control-sm form-cari" autocomplete="off"></div>
				<div class="input-group-text" style="margin-right: 10px;border-radius: 4px;"><span class="fw-bold" style="margin-right: 10px;">Deskripsi</span><input type="text" name="cari_desk" id="cari_desk" class="form-control form-control-sm form-cari" autocomplete="off"></div>
				<div class="input-group-text" style="margin-right: 10px;border-radius: 4px;"><span class="fw-bold" style="margin-right: 10px;">Stock</span><input type="number" step="1" name="cari_stok" id="cari_stok" class="form-control form-control-sm form-cari"></div><button class="btn btn-primary d-sm-flex align-items-sm-center" type="button" style="border-radius: 4px;" id="btn-cari">Cari Barang</button>
			</div>
		</div>
		<div class="table-responsive" style="margin-top: 16px;">
			<table id="table_barang" class="table table-hover">

			</table>
		</div>
	</div>
</div>



<!-- loadKonten -->
<script type="text/javascript">
	function loadKonten(url) {
		$.ajax(url, {
			type: 'GET',
			success: function(data, status, xhr) {
				var objData = JSON.parse(data);
				$('#table_barang').html(objData.konten);

				reload_event();
			},
			error: function(jqXhr, textStatus, errorMsg) {
				alert('Error: ' + errorMsg);
			}
		})
	}
	loadKonten('http://localhost/backend_inventory/barang/list_barang')
</script>

<!-- cariBarang -->
<script>
	$('#btn-cari').on('click', function() {
		cariData();
	})

	function cariData() {
		var url = 'http://localhost/backend_inventory/barang/cari_barang';
		var dataForm = {};
		var allInput = $('.form-cari');
		$.each(allInput, function(i, val) {
			dataForm[val['name']] = val['value'];
		});

		$.ajax(url, {
			type: 'POST',
			data: dataForm,
			success: function(data, status, xhr) {
				var objData = JSON.parse(data);
				$('#table_barang').html(objData.konten);
				reload_event();
			},
			error: function(jqXhr, textStatus, errorMsg) {
				alert('Error' + errorMsg)
			}
		})
	}
</script>

<!-- edit&hapus -->
<script type="text/javascript">
	function reload_event() {
		$('.linkEditBarang').on('click', function() {
			var hashClean = this.hash.replace('#', '');
			loadMenu('<?= base_url('barang/form_edit/') ?>' + hashClean)
		});
		$('.linkHapusBarang').on('click', function() {
			var hashClean = this.hash.replace('#', '');
			hapusData(hashClean);
		})
	}
</script>

<script type="text/javascript">
	function hapusData(id_barang) {
		// var link = 'http://localhost/backend_inventory/barang/delete_data?id_barang=' + id_barang;
		var link = 'http://localhost/backend_inventory/barang/soft_delete_data?id_barang=' + id_barang;
		$.ajax({
			url: link,
			type: "get",
			success: function(data, status, xhr) {
				var data_str = JSON.parse(data);
				alert(data_str['pesan']);
				loadKonten('http://localhost/backend_inventory/barang/list_barang');
			},
			error: function(jqXHR, textStatus, errorMsg) {
				alert('Error :' + errorMsg)
			},
		})
	}
</script>
