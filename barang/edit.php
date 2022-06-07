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
                            <?php
                            $id = @$_GET['id'];
                            $sql_user = mysqli_query($con, "SELECT * FROM barang WHERE id_barang = '$id'") or die(mysqli_error($con));
                            $data = mysqli_fetch_array($sql_user)
                            ?>
                            <form action="" enctype="multipart/form-data" method="post">
                                <div class="form-group">
                                    <div class="section-title mt-0">Nama Barang</div>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="namabarang" value="<?= $data['nama_barang'] ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="section-title mt-0">Merek</div>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="merek" value="<?= $data['merek'] ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="section-title mt-0">Ukuran</div>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="ukuran" value="<?= $data['ukuran'] ?>" required>
                                    </div>
                                </div>

                                <div class="card-footer bg-white text-right">
                                    <button class="btn btn-dark mr-1" type="submit" name="submit">Update</button>
                                    <button class="btn btn-danger" type="reset">Reset</button>
                                </div>
                                </from>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {

    $namabarang = $_POST['namabarang'];

    $merek = $_POST['merek'];
    $ukuran = $_POST['ukuran'];

    $update = mysqli_query($con, "UPDATE barang set nama_barang ='$namabarang', merek ='$merek', ukuran ='$ukuran' WHERE id_barang = '$id'") or die(mysqli_error($con));

    echo "<script type='text/javascript'>
                        setTimeout(function () { 
                            swal({ 
                                title: 'success', 
                                text: 'Berhasil Di Updhate', 
                                type: 'success',
                                 timer: 3000,
                                  showConfirmButton: false });
                        },10);  
                        window.setTimeout(function(){ 
                          window.location.replace('index.php');
                        } ,3000); 
                        </script>";
}



?>
</div>

<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
<?php include_once('footer.php');

?>