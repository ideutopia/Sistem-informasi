<?php
include 'func.php';
$pdo = pdo_connect_mysql();
$msg = '';

//Cek apakah ID Ada
if (isset($_GET['id'])) {
    //pilih record yang akan dihapus
    $stmt = $pdo->prepare('SELECT * FROM keuangan where id =?');
    $stmt->execute([$_GET['id']]);
    $logKeuangan = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$logKeuangan) {
        exit('Record dengan id tersebut tidak terdaftar di database');
    }
    //tampilkan konfirmasi sebelum melakukan penghapusan
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            //jika user mengklik button delete
            $stmt = $pdo->prepare('DELETE FROM keuangan WHERE id= ?');
            $stmt->execute([$_GET['id']]);
            $msg = "Data telah dihapus \n klik <a href='read.php'>Disini</a>Untuk kembali kehalaman awal!";
        } else {
            //user mengklik NO
            header('Location:read.php');
            exit;
        }
    }
} else {
    exit('No ID specified');
}
?>

<?= template_header('Delete') ?>
<div class="container">
    <h2>Hapus Record!</h2>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php else : ?>
        <p>Yakin untuk menghapus record ?</p>
        <div class="yesno">
            <a href="delete.php?id=<?= $logKeuangan['id'] ?>&confirm=yes" class="btn btn-danger">Ya</a>
            <a href="delete.php?id=<?= $logKeuangan['id'] ?>&confirm=no" class="btn btn-warning">Tidak</a>
        </div>
    <?php endif; ?>
</div>
<?= template_footer() ?>