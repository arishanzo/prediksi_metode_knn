<?php include_once('header.php');
require_once "../config/config.php";
$id = @$_GET['id'];
$del1 = mysqli_query($con, "DELETE FROM barang WHERE id_barang='$id'");


echo "<script type='text/javascript'>
    setTimeout(function () { 
        swal({ 
            title: 'BERHASIL', 
            text:  'HAPUS DATA BERHASIL',
            type: 'success',
            timer: 1000,
            ConfirmButton: 'OK',
            showConfirmButton: true});
    },10);  
    window.setTimeout(function(){ 
      window.location.replace('index.php');
    } ,1000); 
    </script>";

?>
</div>
<?php include_once('footer.php');
?>