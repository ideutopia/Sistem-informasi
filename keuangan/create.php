<?php
include 'func.php';
$pdo = pdo_connect_mysql();
$msg = '';
//check apakah ada data yang dikirimkan melalui method POST
if (!empty($_POST)) {
    //kirim data melalui method post untuk diinsert ke database
    //set up variabel yang akan dimasukkan
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    //cek variabel pada metod post apakah telah diisi, jika tidak isi otomatis dengan blank
    $tipe = isset($_POST['tipe']) ? $_POST['tipe'] : '';
    $tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : '';
    $bulan = isset($_POST['bulan']) ? $_POST['bulan'] : '';
    $admin = isset($_POST['admin']) ? $_POST['admin'] : '';
    $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : '';
    $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';
    $log = isset($_POST['log']) ? $_POST['log'] : date('Y-m-d H:i:s');
    //insert Ke database
    $stmt = $pdo->prepare('INSERT INTO keuangan VALUES (?,?,?,?,?,?,?,?)');
    $stmt->execute([$id, $admin, $tipe, $tanggal, $bulan, $jumlah, $keterangan, $log]);
    $msg = 'sukses dibuat';
}
?>
<?= template_header('Create') ?>
<div class="container update">
    <h2>Buat LOG</h2>
    <form action="create.php" method="post">
        <div class="form-group">
            <label for="id">ID</label>
            <input type="number" name="id" class="form-control" placeholder="otomatis diisi sistem" value="auto" id="id" disabled>
            <label for="admin">Administrator</label>
            <input type="text" class="form-control" name="admin" placeholder="Penanggung jawab" id="admin" required>
            <label for="tipe">Tipe</label>
            <select name="tipe" id="tipe" class="form-control" required>
                <option value="Pemasukan">Pemasukan</option>
                <option value="Pengeluaran">Pengeluaran</option>
            </select>
            <label for="tanggal">Tanggal Pemasukan/Pengeluaran</label>
            <input type="date" class="form-control" name="tanggal" id="tanggal" required>
            <label for="bulan">Bulan</label>
            <select name="bulan" class="form-control" id="filterBulan" required>
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
            <input type="number" class="form-control" name="jumlah" id="jumlah" required>
            <label for="keterangan">Keterangan</label>
            <input type="text" class="form-control" name="keterangan" placeholder="misal uang kas" id="keterangan" required>
            <label for="log">Log Waktu</label>
            <input type="datetime-local" class="form-control" name="log" value="<?= date('Y-m-d\TH:i') ?>" id="log" required>
        </div>
        <input type="submit" class="btn btn-primary" value="Buat log catatan">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>
<?= template_footer() ?>