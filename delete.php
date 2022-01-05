<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact Name Product exists
if (isset($_GET['nama_produk'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM produk WHERE nama_produk = ?');
    $stmt->execute([$_GET['nama_produk']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that product name!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM produk WHERE nama_produk = ?');
            $stmt->execute([$_GET['nama_produk']]);
            $msg = 'You have deleted the contact!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No Product Name specified!');
}
?>


<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Product #<?=$contact['nama_produk']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete contact #<?=$contact['nama_produk']?>?</p>
    <div class="yesno">
        <a href="delete.php?nama_produk=<?=$contact['nama_produk']?>&confirm=yes">Yes</a>
        <a href="delete.php?nama_produk=<?=$contact['nama_produk']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>