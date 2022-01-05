<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact name product exists, for example update.php?name_product= will get the contact with the name product of 1
if (isset($_GET['nama_produk'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        
    $nama_produk = isset($_POST['nama_produk']) ? $_POST['nama_produk'] : NULL;
    $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';
    $harga = isset($_POST['harga']) ? $_POST['harga'] : '';
    $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE produk SET nama_produk = ?, keterangan = ?, harga = ?, jumlah = ? WHERE nama_produk = ?');
        $stmt->execute([$nama_produk, $keterangan, $harga, $jumlah, $_GET['nama_produk']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM produk WHERE nama_produk = ?');
    $stmt->execute([$_GET['nama_produk']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that Product Name!');
    }
} else {
    exit('No Product Name specified!');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update Product #<?=$contact['nama_produk']?></h2>
    <form action="update.php?nama_produk=<?=$contact['nama_produk']?>" method="post">
        <label for="nama_produk">Nama Produk</label>
        <label for="keterangan">Keterangan</label>
        <input type="text" name="nama_produk" value="<?=$contact['nama_produk']?>" nama_produk="nama_produk">
        <input type="text" name="keterangan" value="<?=$contact['keterangan']?>" nama_produk="keterangan">
        <label for="harga">harga</label>
        <label for="jumlah">jumlah</label>
        <input type="text" name="harga" value="<?=$contact['harga']?>" nama_produk="harga">
        <input type="text" name="jumlah" value="<?=$contact['jumlah']?>" nama_produk="jumlah">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>