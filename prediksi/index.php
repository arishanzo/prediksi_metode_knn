<?php include_once('header.php');
require_once "../config/config.php";
?>


<div class="row col-lg-12">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="card-body">
                                <form action="hasil.php" enctype="multipart/form-data" method="get">
                                    <div class="form-group">
                                        <label for="kategori">
                                            <div class="section-title mt-0"> Nama Barang </div>
                                        </label>

                                        <select class="custom-select" id="namabarang" name="namabarang">
                                            <option disabled selected>Pilih Barang</option>
                                            <?php
                                            $query = mysqli_query($con, "select * from barang");

                                            while ($data = mysqli_fetch_array($query)) {
                                            ?>
                                                <option value="<?php echo $data['id_barang']; ?>"><?php echo $data['nama_barang']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>



                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="sel1">Merek</label>
                                            <select class="form-control" name="merk" id="merk">
                                                <option>Pilih Merek</option>
                                                <!-- Merk  akan diload menggunakan ajax, dan ditampilkan disini -->
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="sel1">Ukuran</label>
                                                <select class="form-control" name="ukuran" id="ukuran">
                                                    <option>Pilih Ukuran</option>
                                                    <!-- ukuran akan diload menggunakan ajax, dan ditampilkan disini -->
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

                                            <div class="card-footer bg-white">
                                                <button class="btn btn-dark mr-1" type="submit" name="submit">prediksi</button>
                                            </div>
                                            </from>
                                            <div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <script>
        $("#namabarang").change(function() {
            // variabel dari nilai combo box
            var id_barang = $("#namabarang").val();

            // Menggunakan ajax untuk mengirim dan dan menerima data dari server
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "ambil-data.php",
                data: "idbarang=" + id_barang,
                success: function(data) {
                    $("#merk").html(data);
                }
            });
        });

        $("#merk").change(function() {
            // variabel dari nilai combo box merk
            var merek = $("#merk").val();

            // Menggunakan ajax untuk mengirim dan dan menerima data dari server
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "ambil-data.php",
                data: "merek=" + merek,
                success: function(data) {
                    $("#ukuran").html(data);
                }
            });
        });
    </script>
    <?php include_once('footer.php');
    ?>