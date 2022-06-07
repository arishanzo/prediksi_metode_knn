<?php include_once('header.php');
require_once "../config/config.php";
?>

<div class="row col-lg-12">
    <div class="col-lg-12">
        <div class="card">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="card-body">

                            <form action="" enctype="multipart/form-data" method="post">
                                <?php
                                // mengambil data barang dengan kode paling besar
                                $query = mysqli_query($con, "SELECT max(id_penjualan) as maxKode FROM penjualan");
                                $data = mysqli_fetch_array($query);
                                $id = $data['maxKode'];


                                $urutan = $id;

                                $urutan++;

                                $id = sprintf("%03s", $urutan);
                                ?>

                                <div class="form-group">
                                    <label for="kategori">
                                        <div class="section-title mt-0"> Nama Barang </div>
                                    </label>

                                    <select class="custom-select" id="idbarang" name="idbarang">
                                        <option disabled selected>Pilih Barang</option>
                                        <?php

                                        $sql2 = mysqli_query($con, "SELECT * FROM barang ");
                                        while ($row2 = mysqli_fetch_array($sql2)) {
                                        ?>
                                            <option value="<?= $row2['id_barang'] ?>"><?= $row2['nama_barang'] ?></option>
                                        <?php

                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="Bulan">
                                        <div class="section-title mt-0"> Bulan </div>
                                    </label>

                                    <select class="custom-select" id="Bulan" name="bulan">
                                        <option selected disabled>Pilih Bulan</option>
                                        <option value="Januari">Januari</option>
                                        <option value="Februari">Februari</option>
                                        <option value="Maret">Maret</option>
                                        <option value="April">April</option>
                                        <option value="Mei">Mei</option>
                                        <option value="Juni">Juni</option>
                                        <option value="Juli">Juli</option>
                                        <option value="Agustus">Agustus</option>
                                        <option value="September">September</option>
                                        <option value="Oktober">Oktober</option>
                                        <option value="November">November</option>
                                        <option value="Desember">Desember</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="tahun">
                                        <div class="section-title mt-0"> Tahun </div>
                                    </label>

                                    <select class="custom-select" id="Tahun" name="tahun">
                                        <option selected disabled>Pilih Tahun</option>
                                         
                                            <option value="2022">2022</option>

                                          <option value="2021">2021</option>

                                        <option value="2020">2020</option>
                                           <option value="2019">2019</option>
                                      
                                                 </select>
                                </div>
                                <div class="form-group">
                                    <div class="section-title mt-0">Stok Barang</div>
                                    <div class="input-group mb-2">
                                        <input type="number" class="form-control" name="stokbarang" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="section-title mt-0">Harga</div>
                                    <div class="input-group mb-2">

                                        <div class="input-group-text">
                                            Rp
                                        </div>
                                        <input type="number" class="form-control" name="harga" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="section-title mt-0">Terjual</div>
                                    <div class="input-group mb-2">

                                        <input type="number" class="form-control" name="terjual" required>
                                    </div>
                                </div>



                                <div class="card-footer bg-white">
                                    <button class="btn btn-primary mr-1" type="submit" name="submit">Simpan</button>

                                </div>
                                </from>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php
if (isset($_POST['submit'])) {
    $idbarang = $_POST['idbarang'];
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $terjual = $_POST['terjual'];
    $harga = $_POST['harga'];
    $stok = $_POST['stokbarang'];
$totalharga = $harga * $terjual;
    
    // rumus transformasi data
$Sqlmax= mysqli_query($con, "SELECT max(total_harga) FROM penjualan where id_barang ='$idbarang'");
$rowmax = mysqli_fetch_array($Sqlmax);

$Sqlmin= mysqli_query($con, "SELECT min(total_harga) FROM penjualan where id_barang ='$idbarang'");
$rowmin = mysqli_fetch_array($Sqlmin);

$rumus11 = $rowmax['max(total_harga)'] - $rowmin['min(total_harga)'];
$rumus22 = $rumus11 / 3;

$kategori1 = $rowmin['min(total_harga)'] + $rumus22;
$kategori2 = $rumus22 + $kategori1;
$kategori3 = $rumus22 + $kategori2;
    
    // save hasil prediksi
  if ($totalharga > $kategori3) {
       echo "<script type='text/javascript'>
                                setTimeout(function () { 
                                    swal({ 
                                        title: 'Maaf', 
                                        text: 'Total Harga Melebihi batas', 
                                        type: 'warning',
                                         timer: 3000,
                                          showConfirmButton: false });
                                },10);  
                                window.setTimeout(function(){ 
                                  window.location.replace('add.php');
                                } ,3000); 
                                </script>";
  
    }else {
    $save = mysqli_query($con, "INSERT INTO penjualan VALUES ('$id', '$idbarang', '$tahun', '$bulan', '$stok' , '$harga', '$terjual', '$totalharga', '')") or die(mysqli_error($con));

        echo "<script type='text/javascript'>
                                setTimeout(function () { 
                                    swal({ 
                                        title: 'Suksess', 
                                        text: 'Data Penjualan Berhasil Disimpan', 
                                        type: 'success',
                                         timer: 3000,
                                          showConfirmButton: false });
                                },10);  
                                window.setTimeout(function(){ 
                                  window.location.replace('index.php');
                                } ,3000); 
                                </script>";
    }
}

?>

<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
<?php include_once('footer.php');

?>