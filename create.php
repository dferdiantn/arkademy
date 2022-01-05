<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $nama_produk = isset($_POST['nama_produk']) && !empty($_POST['nama_produk']) && $_POST['nama_produk'] != 'auto' ? $_POST['nama_produk'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    
    $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';
    $harga = isset($_POST['harga']) ? $_POST['harga'] : '';
    $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO produk VALUES (?, ?, ?, ?)');
    $stmt->execute([$nama_produk, $keterangan, $harga, $jumlah]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Create Products</h2>
    <form action="create.php" method="post">
        <label for="nama_produk">Nama Produk</label>
        <label for="keterangan">keterangan</label>
        <input type="text" name="nama_produk" nama_produk="nama_produk">
        <input type="text" name="keterangan" nama_produk="keterangan">
        <label for="harga">Harga</label>
        <label for="jumlah">jumlah</label>
        <input type="text" name="harga" nama_produk="harga">
        <input type="text" name="jumlah" nama_produk="jumlah">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>