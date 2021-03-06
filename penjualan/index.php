<?php include_once('header.php');
require_once "../config/config.php";


require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
?>

<div class="col-lg-12 mt-5">
    <div class="card">
        <div class="card-body">
            <a class="btn btn-dark btn-action btn-xs mr-1" href="add.php" data-toggle="tooltip" title="Tambah"><span>Tambah</span></a>
            <button class="btn btn-success btn-action btn-xs mr-1" data-toggle="modal" data-target="#exampleModal" data-toggle="tooltip" title="Tambah Data"><span>Excel</span></button>

        </div>
        <div class="card-body">

            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 barang" id="barang">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Tahun</th>
                                    <th>Bulan</th>
                                    <th>Stok Barang</th>
                                    <th>Harga Satuan</th>
                                    <th>Terjual</th>
                                    <th>Total Harga</th>
                                    <th>Klasifikasi</th>
                                   
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $SqlQuery = mysqli_query($con, "SELECT * FROM barang as b INNER JOIN penjualan as p ON b.id_barang=p.id_barang");
                                $no = 1;
                                if (mysqli_num_rows($SqlQuery) > 0) {
                                    while ($row = mysqli_fetch_array($SqlQuery)) {
                                ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row['nama_barang'] ?></td>
                                            <td><?= $row['tahun'] ?></td>
                                            <td><?= $row['bulan'] ?></td>
                                            <td><?= $row['stok_barang'] ?></td>
                                            <td><?= "Rp " . number_format($row['harga_satuan'], 2, ',', '.'); ?></td>
                                            <td><?= $row['terjual'] ?></td>
                                            <td><?= "Rp " . number_format($row['total_harga'], 2, ',', '.'); ?></td>
                                            <td><?= $row['klasifikasi'] ?></td>
                                          
                                            <td>
                                                <a href="edit.php?id=<?= $row['id_penjualan'] ?>" class="btn btn-primary btn-action mr-1" title="Edit"><i class="fas fa-pencil-alt"></i></a>

                                                <a href="delete.php?id=<?= $row['id_penjualan'] ?>" class="btn btn-danger btn-xs delete-data" title="hapus"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan=\"10\" align=\"center\">data tidak ada</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                </section>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="section-title">Upload File Excel</div>
                        <div class="custom-file">
                            <input type="file" name="namafile">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-dark mr-1" type="submit" name="submit">Simpan</button>

                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                    </div>
            </div>
            </form>
        </div>
    </div>
</div>


<?php
if (isset($_POST['submit'])) {
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    if (isset($_FILES['namafile']['name']) && in_array($_FILES['namafile']['type'], $file_mimes)) {

        $arr_file = explode('.', $_FILES['namafile']['name']);
        $extension = end($arr_file);

        if ('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $reader->load($_FILES['namafile']['tmp_name']);

        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        for ($i = 2; $i < count($sheetData); $i++) {
            // mengambil data barang dengan kode paling besar
            $query = mysqli_query($con, "SELECT max(id_penjualan) as maxKode FROM penjualan");
            $data = mysqli_fetch_array($query);
            $id = $data['maxKode'];


            $urutan = $id;

            $urutan++;

            $id = sprintf("%03s", $urutan);
            $idbarang    = $sheetData[$i]['0'];
            $tahun   = $sheetData[$i]['1'];
            $bulan  = $sheetData[$i]['2'];
            $stok = $sheetData[$i]['3'];
            $harga = $sheetData[$i]['4'];
            $terjual = $sheetData[$i]['5'];
            $total = $sheetData[$i]['6'];
        
            $save = mysqli_query($con, "INSERT INTO penjualan VALUES ('$id',  '$idbarang', '$tahun', '$bulan', '$stok', '$harga', '$terjual', '$total','' )") or die(mysqli_error($con));
        }
        echo "<script type='text/javascript'>
                                    setTimeout(function () { 
                                       swal({ 
                                           title: 'Suksess', 
                                           text: 'Data Berhasil Disimpan', 
                                           type: 'success',
                                           icon: 'success',
                                           timer: 3000,
                                           buttons: false });
                                   },10);  
                                   window.setTimeout(function(){ 
                                   window.location.replace('index.php');
                                   } ,3000); 
                                   </script>";
    }
}
?>

<script>
    $(document).ready(function() {
        $('.barang').DataTable({
            "paging": true,

        });

    });
</script>

<script>
    // swall
    $('.delete-data').on('click', function(e) {
        e.preventDefault();
        var getLink = $(this).attr('href');

        Swal.fire({
            title: 'Apa Anda Yakin?',
            text: "Data akan dihapus permanen",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.value) {
                window.location.href = getLink;
            }
        })
    });
</script>
<?php include_once('footer.php');

?>