<?php include_once('header.php');
require_once "../config/config.php";
$idbarang = $_GET['namabarang'];
$tahun = $_GET['tahun'];
$bulan = $_GET['bulan'];
$merek = $_GET['merk'];
$ukuran = $_GET['ukuran'];

$del1 = mysqli_query($con, "DELETE FROM prediksi");
$del2 = mysqli_query($con, "DELETE FROM hasil_prediksi");


$Sqlcek = mysqli_query($con, "SELECT * FROM penjualan where id_barang = '$idbarang' && bulan ='$bulan' && tahun='$tahun'");
$rowcek = mysqli_num_rows($Sqlcek);

if ($rowcek > 0) {


    $SqlQuery = mysqli_query($con, "SELECT * FROM penjualan where id_barang = '$idbarang'");
    while ($row = mysqli_fetch_array($SqlQuery)) {

        // Cek data terbaru
        $Sqlprediksi = mysqli_query($con, "SELECT * FROM penjualan where id_barang = '$idbarang' && bulan ='$bulan' && tahun='$tahun'");
        $rowprediksi = mysqli_fetch_array($Sqlprediksi);
        // rumus
        $bulanpenjualan = $row['bulan'];
        $tahunpenjualan = $row['tahun'];
        if ($bulanpenjualan == $bulan && $tahunpenjualan == $tahun) {
            break;
        } else {
            $nilai_pangkat = 2;
            $rumus1 = $row['stok_barang'] - $rowprediksi['stok_barang'];
            $rumus2 = $row['harga_satuan'] - $rowprediksi['harga_satuan'];
            $rumus3 = $row['terjual'] - $rowprediksi['terjual'];

            $pangkat1  = pow($rumus1, $nilai_pangkat);
            $pangkat2 = pow($rumus2, $nilai_pangkat);
            $pangkat3  = pow($rumus3, $nilai_pangkat);

            $total = sqrt($pangkat1 + $pangkat2 + $pangkat3);
            $totalsemua = round($total, 4);
            // mengambil data barang dengan kode paling besar
            $query = mysqli_query($con, "SELECT max(id_prediksi) as maxKode FROM prediksi");
            $data = mysqli_fetch_array($query);
            $id = $data['maxKode'];


            $urutan = $id;

            $urutan++;

            $idprediksi = sprintf("%03s", $urutan);

            $save = mysqli_query($con, "INSERT INTO prediksi VALUES ('$idprediksi', '$row[id_penjualan]', '$row[id_barang]', '$row[bulan]', '$row[tahun]')") or die(mysqli_error($con));

            // rumus transformasi data
            $Sqlmax = mysqli_query($con, "SELECT max(total_harga) FROM penjualan where id_barang = '$idbarang'");
            $rowmax = mysqli_fetch_array($Sqlmax);

            $Sqlmin = mysqli_query($con, "SELECT min(total_harga) FROM penjualan where id_barang = '$idbarang'");
            $rowmin = mysqli_fetch_array($Sqlmin);

            $rumus11 = $rowmax['max(total_harga)'] - $rowmin['min(total_harga)'];
            $rumus22 = $rumus11 / 3;

            $kategori1 = $rowmin['min(total_harga)'] + $rumus22;
            $kategori2 = $rumus22 + $kategori1;
            $kategori3 = $rumus22 + $kategori2;

            // save hasil prediksi
            if ($row['total_harga'] >= $rowmin['min(total_harga)'] && $row['total_harga'] <= $kategori1) {
                $save = mysqli_query($con, "INSERT INTO hasil_prediksi VALUES ('', '$idprediksi', '$row[bulan]', '$row[tahun]', '$totalsemua', 'Turun')") or die(mysqli_error($con));
                $idpenjualan = $row['id_penjualan'];
                $update = mysqli_query($con, "UPDATE penjualan set klasifikasi ='Turun' WHERE id_penjualan = '$idpenjualan'") or die(mysqli_error($con));
            } else if ($row['total_harga'] >= $kategori1 && $row['total_harga'] <= $kategori2) {
                $save = mysqli_query($con, "INSERT INTO hasil_prediksi VALUES ('', '$idprediksi', '$row[bulan]', '$row[tahun]', '$totalsemua', 'Naik')") or die(mysqli_error($con));
                $idpenjualan = $row['id_penjualan'];
                $update = mysqli_query($con, "UPDATE penjualan set klasifikasi ='Naik' WHERE id_penjualan = '$idpenjualan'") or die(mysqli_error($con));
            } else  if ($row['total_harga'] >= $kategori2 && $kategori3) {
                $save = mysqli_query($con, "INSERT INTO hasil_prediksi VALUES ('', '$idprediksi', '$row[bulan]', '$row[tahun]', '$totalsemua', 'Sangat Naik')") or die(mysqli_error($con));
                $idpenjualan = $row['id_penjualan'];
                $update = mysqli_query($con, "UPDATE penjualan set klasifikasi ='Sangat Naik' WHERE id_penjualan = '$idpenjualan'") or die(mysqli_error($con));
            }


?>
<?php
        }
    }

    $SqlQuery = mysqli_query($con, "SELECT * FROM penjualan where id_barang = '$idbarang' && bulan ='$bulan' && tahun='$tahun'");
    while ($row = mysqli_fetch_array($SqlQuery)) {

        $id = $row['id_penjualan'];
        // rumus transformasi data
        $Sqlmax = mysqli_query($con, "SELECT max(total_harga) FROM penjualan where id_barang = '$idbarang'");
        $rowmax = mysqli_fetch_array($Sqlmax);

        $Sqlmin = mysqli_query($con, "SELECT min(total_harga) FROM penjualan where id_barang = '$idbarang'");
        $rowmin = mysqli_fetch_array($Sqlmin);

        $rumus11 = $rowmax['max(total_harga)'] - $rowmin['min(total_harga)'];
        $rumus22 = $rumus11 / 3;

        $kategori1 = $rowmin['min(total_harga)'] + $rumus22;
        $kategori2 = $rumus22 + $kategori1;
        $kategori3 = $rumus22 + $kategori2;

        // save hasil prediksi
        if ($row['total_harga'] >= $rowmin['min(total_harga)'] && $row['total_harga'] <= $kategori1) {

            $update = mysqli_query($con, "UPDATE penjualan set klasifikasi ='Turun' WHERE id_penjualan = '$id'") or die(mysqli_error($con));
        } else if ($row['total_harga'] >= $kategori1 && $row['total_harga'] <= $kategori2) {

            $update = mysqli_query($con, "UPDATE penjualan set klasifikasi ='Naik' WHERE id_penjualan = '$id'") or die(mysqli_error($con));
        } else  if ($row['total_harga'] >= $kategori2 && $kategori3) {

            $update = mysqli_query($con, "UPDATE penjualan set klasifikasi ='Sangat Naik' WHERE id_penjualan = '$id'") or die(mysqli_error($con));
        }
    }
} else {
    echo "<script type='text/javascript'>
                                setTimeout(function () { 
                                    swal({ 
                                        title: 'Maaf', 
                                        text: 'Data Penjualan Bulan $bulan dan $tahun Tidak Ada', 
                                        type: 'warning',
                                         timer: 3000,
                                          showConfirmButton: false });
                                },10);  
                                window.setTimeout(function(){ 
                                  window.location.replace('index.php');
                                } ,3000); 
                                </script>";
}
?>


<div class="col-lg-12">
    <div class="card">

        <div class="card-body">
            <div class="text-header">
                <?php

                $Sqlcek = mysqli_query($con, "SELECT * FROM barang where id_barang = '$idbarang'");
                $row = mysqli_fetch_array($Sqlcek);
                $namabarang = $row['nama_barang'];
                ?>
                <h5>Hasil Predikisi Nama <?= $namabarang ?> Merek <?= $merek ?> Ukuran <?= $ukuran ?> Pada Bulan <?= $bulan ?> Tahun <?= $tahun ?></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 barang" id="barang">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th>Terjual</th>
                                    <th>Jarak</th>
                                    <th>Klasifikasi</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $SqlQuery = mysqli_query($con, "SELECT * FROM hasil_prediksi inner join barang as b inner join penjualan as p INNER JOIN prediksi as k on k.id_penjualan = p.id_penjualan && b.id_barang = '$idbarang' where hasil_prediksi.id_prediksi = k.id_prediksi ORDER BY jarak ASC limit 10");
                                $Sqlbarang = mysqli_query($con, "SELECT * FROM barang where id_barang='$idbarang'");
                                $rowbarang = mysqli_fetch_array($Sqlbarang);
                                $no = 1;
                                $rank = 1;
                                if (mysqli_num_rows($SqlQuery) > 0) {
                                    while ($row = mysqli_fetch_array($SqlQuery)) {
                                ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row['bulan_hasil'] ?></td>
                                            <td><?= $row['tahun_hasil'] ?></td>
                                            <td><?= $row['stok_barang'] ?></td>
                                            <td><?= $row['total_harga'] ?></td>
                                            <td><?= $row['terjual'] ?></td>
                                            <td><?= $row['jarak'] ?></td>
                                            <td><?= $row['tetangga'] ?></td>

                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan=\"10\" align=\"center\">data tidak ada</td></tr>";
                                }
                                ?>
                            <tfoot>

                            </tfoot>
                            </tbody>
                        </table>
                    </div>
                </div>
                </section>
            </div>
        </div>
    </div>
</div>

<?php
$Sqlklasifikasi = mysqli_query($con, "SELECT * FROM hasil_prediksi ORDER BY jarak ASC limit 5");
$rowklasifikasi = mysqli_num_rows($Sqlklasifikasi);




?>
<div class="row col-lg-12 mt-5">
    <div class="col-lg-12">
        <div class="card-body">
            <div class="card-header">
                <span>Hasil Dari Prediksi Mempunyai Kedekatan 3 dari Urutan Paling Kecil Sebagai Berikut</span> <br>
                <?php
                $Sql = mysqli_query($con, "SELECT * FROM hasil_prediksi ORDER BY jarak ASC limit 3");
                $urutan = 1;
                while ($row = mysqli_fetch_array($Sql)) {
                ?>
                    <span>K3 = <?= $row['tetangga'] ?></span> <br>
                <?php
                }
                $Sql = mysqli_query($con, "SELECT * FROM penjualan where id_barang = '$idbarang' && bulan ='$bulan' && tahun='$tahun'");
                $rowsql = mysqli_fetch_array($Sql);

                ?>
                <H6 class="font-weight-bold">Maka Dari Itu Hasil Prediksi Bulan <?= $bulan ?> Tahun <?= $tahun ?> Adalah <?= $rowsql['klasifikasi'] ?> </H6>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.barang').DataTable({
            "paging": true,

        });

    });
</script>
<?php include_once('footer.php');

?>