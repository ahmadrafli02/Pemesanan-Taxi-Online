<?php

	$mobil = array("Avanza", "Rush", "Alphard", "Innova", "Fortuner");

	sort($mobil);

	//	menjumlah harga sewa taxi
	function hitung_sewa($jarak, $biaya){
		$nilai_sewa = $jarak * $biaya;
		return $nilai_sewa;
	}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pemesanan Taxi Online</title>
    <link rel="stylesheet" href="CSS/bootstrap.css">
</head>

<body>
    <div class="container border">
        <!-- Menampilkan judul halaman -->
        <p><img src="CSS/logo.jpg" alt="logo" style="float:left;width:42px;height:42px;">

        <h2>Pemesanan Taxi Online</h2>


        <!-- Form untuk memasukkan data pemesanan. -->
        <form action="index.php" method="post" id="formPemesanan">
            <div class="row">
                <!-- Masukan data nama pelanggan. Tipe data text. -->
                <div class="col-lg-2"><label for="nama">Nama Pelanggan:</label></div>
                <div class="col-lg-2"><input type="text" id="nama" name="nama"></div>
            </div>
            <div class="row">
                <!-- Masukan data nomor HP pelanggan. Tipe data number. -->
                <div class="col-lg-2"><label for="nomor">Nomor HP:</label></div>
                <div class="col-lg-2"><input type="number" id="noHP" name="noHP" maxlength="16"></div>
            </div>
            <div class="row">
                <!-- Masukan pilihan jenis mobil. -->
                <div class="col-lg-2"><label for="tipe">Jenis Mobil:</label></div>
                <div class="col-lg-2">
                    <select id="mobil" name="mobil">
                        <option value="">- Jenis mobil -</option>
                        <?php
						foreach ($mobil as $key => $value) {
                        echo "<option value =$value>$value</option>";
                    }
					?>
                    </select>
                </div>
            </div>

            <div class="row">
                <!-- Masukan data Jarak Tempuh. Tipe data number. -->
                <div class="col-lg-2"><label for="nomor">Jarak:</label></div>
                <div class="col-lg-2"><input type="number" id="jarak" name="jarak" maxlength="4"></div>
            </div>
            <div class="row">
                <!-- Tombol Submit -->
                <div class="col-lg-2"><button class="btn btn-primary" type="submit" form="formPemesanan" value="Pesan"
                        name="Pesan">Pesan</button></div>
                <div class="col-lg-2"></div>
            </div>
        </form>
    </div>
    <?php
		//	Kode berikut dieksekusi setelah tombol Hitung ditekan.
		if(isset($_POST['Pesan'])) {
			
			//	Variabel $dataPesanan berisi data-data pemesanan dari form dalam bentuk array.
			
			$dataPesanan = array(
				'nama' => $_POST['nama'],
				'noHP' => $_POST['noHP'],
				'mobil' => $_POST['mobil'],
				'jarak' => $_POST['jarak']
			);
			$jarak_tempuh = $_POST['jarak'];
            function hitung_sewaa($jarak_tempuh) {
			if ($jarak_tempuh <= 10 ){
				$biaya_sewa = $jarak_tempuh*1000;
			} else{
				$biaya_sewa = 10 * 1000; // Biaya untuk 10 km pertama
                $jarak_selanjutnya = $jarak_tempuh - 10; // Jarak selanjutnya setelah 10 km pertama
                $biaya_selanjutnya = $jarak_selanjutnya * 5000; // Biaya untuk setiap km selanjutnya
                $biaya_sewa += $biaya_selanjutnya;  //Total Biaya
			}
			 return $biaya_sewa;
			}
            $tagihan = hitung_sewaa($jarak_tempuh);
            
			//	Variabel berisi path file data.json yang digunakan untuk menyimpan data pemesanan.
			$berkas = "data.json";
			
			//	Mengubah data pemesanan yang berbentuk array PHP menjadi bentuk JSON.
			$dataJson = json_encode($dataPesanan, JSON_PRETTY_PRINT);
			
			//	Instruksi Kerja Nomor 10.
			//	Menyimpan data pemesanan yang berbentuk JSON ke dalam file JSON
			file_put_contents($berkas, $dataJson);
			$dataJson = file_get_contents($berkas);
			
			//	Mengubah data pemesanan dalam format JSON ke dalam format array PHP.
			$dataPesanan = json_decode($dataJson, true);
            
			
			//	Menampilkan data pemesanan dan total biaya sewa.
			//  KODE DI BAWAH INI TIDAK PERLU DIMODIFIKASI!!!
			echo "
				<br/>
				<div class='container'>
					
					<div class='row'>
						<!-- Menampilkan nama pelanggan. -->
						<div class='col-lg-2'>Nama Pelanggan:</div>
						<div class='col-lg-2'>".$dataPesanan['nama']."</div>
					</div>
					<div class='row'>
						<!-- Menampilkan nomor HP pelanggan. -->
						<div class='col-lg-2'>Nomor HP:</div>
						<div class='col-lg-2'>".$dataPesanan['noHP']."</div>
					</div>
					<div class='row'>
						<!-- Menampilkan Jenis mobil Taxi Online. -->
						<div class='col-lg-2'>Jenis Mobil:</div>
						<div class='col-lg-2'>".$dataPesanan['mobil']."</div>
					</div>
					<div class='row'>
						<!-- Menampilkan jumlah Jarak Tempuh. -->
						<div class='col-lg-2'>Jarak(km):</div>
						<div class='col-lg-2'>".$dataPesanan['jarak']." km</div>
					</div>
					<div class='row'>
						<!-- Menampilkan Total Tagihan. -->
						<div class='col-lg-2'>Total:</div>
						<div class='col-lg-2'>Rp".number_format($tagihan, 0, ".", ".").",-</div>
					</div>
					
			</div>
			";
		}
	?>
</body>

</html>