<?php
include 'func.php';
$pdo = pdo_connect_mysql();
$msg = '';
//cek apakah id di request GET
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $tipe = isset($_POST['tipe']) ? $_POST['tipe'] : '';
        $tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : '';
        $bulan = isset($_POST['bulan']) ? $_POST['bulan'] : '';
        $admin = isset($_POST['admin']) ? $_POST['admin'] : '';
        $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : '';
        $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';
        $log = isset($_POST['log']) ? $_POST['log'] : date('Y-m-d H:i:s');
        $stmt = $pdo->prepare('UPDATE keuangan SET admin = ?, tipe=?,tanggal=?,bulan=?,jumlah=?,keterangan=?,log=? WHERE id = ?');
        $stmt->execute([$admin, $tipe, $tanggal, $bulan, $jumlah, $keterangan, $log, $_GET['id']]);
        $msg = "Update sukses";
    }
    //Get data dari tabel
    $stmt = $pdo->prepare('SELECT * FROM keuangan WHERE id =?');
    $stmt->execute([$_GET['id']]);
    $logKeuangan = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$logKeuangan) {
        exit("Record dengan id yang dirujuk tidak ada di database");
    }
} else {
    exit('Tidak ada ID yang spesifik');
}
?>

<?= template_header('Read') ?>

<div class="container">
    <h2>Update Data</h2>
    <form action="update.php?id=<?= $logKeuangan['id'] ?>" method="post">
        <div class="form-group">
            <label for="id">ID</label>
            <input type="text" class="form-control" name="id" value="<?= $logKeuangan['id'] ?>" id="id" readonly>
            <label for="admin">Administrator</label>
            <input type="text" class="form-control" name="admin" value="<?= $logKeuangan['admin'] ?>" id="admin">
            <label for="tipe">Tipe</label>
            <select name="tipe" class="form-control" id="tipe">
                <option selected><?= $logKeuangan['tipe'] ?></option>
                <option value="Pemasukan">Pemasukan</option>
                <option value="Pengeluaran">Pengeluaran</option>
            </select>
            <label for="tanggal">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" value="<?= date('d-m-Y', strtotime($logKeuangan['tanggal'])) ?>" id="tanggal">
            <label for="bulan">Bulan</label>
            <select name="bulan" class="form-control" id="filterBulan">
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
            <label for="jumlah">Jumlah</label>
            <input type="number" class="form-control" name="jumlah" value="<?= $logKeuangan['jumlah'] ?>" id="jumlah">
            <label for="keterangan">Keterangan</label>
            <input type="text" class="form-control" name="keterangan" value="<?= $logKeuangan['keterangan'] ?>" id="keterangan">
            <label for="log">Log Waktu</label>
            <input type="datetime-local" class="form-control" name="log" value="<?= date('Y-m-d\TH:i', strtotime($logKeuangan['log'])) ?>" id="log">
        </div>
        <input type="submit" class="btn btn-primary" value="Update">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>