<?php
require_once "../config/config.php";
if (isset($_POST['idbarang'])) {
    $id_barang = $_POST["idbarang"];

    $sql = "select * from barang where id_barang=$id_barang";

    $hasil = mysqli_query($con, $sql);
    $no = 0;
?>
    <option>Pilih Merek</option>

    <?Php
    while ($data = mysqli_fetch_array($hasil)) {
    ?>
        <option value="<?php echo  $data['merek']; ?>"><?php echo $data['merek']; ?></option>
    <?php
    }
}
if (isset($_POST['merek'])) {
    $merek = $_POST["merek"];

    $sql = "select * from barang where merek='$merek'";

    $hasil = mysqli_query($con, $sql);
    $no = 0;
    ?>
    <option>Pilih Ukuran</option>

    <?Php
    while ($data = mysqli_fetch_array($hasil)) {
    ?>
        <option value="<?php echo $data['ukuran']; ?>"><?php echo $data['ukuran']; ?></option>
<?php
    }
}

?>