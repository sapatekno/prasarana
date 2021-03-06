<?php
//berkas sistem
require_once './app/config.php';
require_once './app/database.php';
require_once './app/fungsi.php';

//fungsi
_isLogin();
_isLevel([1]);

$error = 0;
$d_jenis = db_jenis_all($db_conn);
$d_ruang = db_ruang_all($db_conn);
$tambah = filter_input(INPUT_POST, 'tambah', FILTER_SANITIZE_STRING);

if (!empty($tambah)) {
    $kode_inventaris = filter_input(INPUT_POST, 'kode_inventaris', FILTER_SANITIZE_STRING);
    $tanggal_register = filter_input(INPUT_POST, 'tanggal_register', FILTER_SANITIZE_STRING);
    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $id_jenis = filter_input(INPUT_POST, 'id_jenis', FILTER_SANITIZE_STRING);
    $id_ruang = filter_input(INPUT_POST, 'id_ruang', FILTER_SANITIZE_STRING);
    $jumlah = filter_input(INPUT_POST, 'jumlah', FILTER_SANITIZE_STRING);
    $kondisi = filter_input(INPUT_POST, 'kondisi', FILTER_SANITIZE_STRING);
    $keterangan = filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_STRING);
    $id_petugas = $_SESSION['id_petugas'];

    $simpan = db_inventaris_add($db_conn, $kode_inventaris, $tanggal_register, $nama, $id_jenis, $id_ruang, $jumlah, $kondisi, $keterangan, $id_petugas);
    if ($simpan > 0) {
        //berhasil menyimpan data
        header('Location: ./inventaris.php');
    } else {
        $error = 1;
    }
}
?>
<html>
    <head>
        <title>Tambah Data Inventaris</title>
    </head>
    <body>
        <p><a href="./index.php">Home</a> > <a href="./inventaris.php">Inventaris</a> > Tambah Inventaris</p>
        <form action="" method="post">
            <table>
                <tr>
                    <td>Petugas Input</td>
                    <td>:</td>
                    <td>
                        <?= $_SESSION['username'] ?> - <?= $_SESSION['nama'] ?>
                    </td>
                </tr>
                <tr>
                    <td>Kode Inventaris</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="kode_inventaris" required autofocus>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Register</td>
                    <td>:</td>
                    <td>
                        <input type="date" name="tanggal_register" value="<?= date('Y-m-d') ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Nama Inventaris</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="nama" required>
                    </td>
                </tr>
                <tr>
                    <td>Jenis Inventaris</td>
                    <td>:</td>
                    <td>
                        <select name="id_jenis">
                            <?php foreach ($d_jenis as $data) : ?>
                                <option value="<?= $data['id_jenis'] ?>"><?= $data['kode_jenis'] ?> - <?= $data['nama_jenis'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Ruangan</td>
                    <td>:</td>
                    <td>
                        <select name="id_ruang">
                            <?php foreach ($d_ruang as $data) : ?>
                                <option value="<?= $data['id_ruang'] ?>"><?= $data['kode_ruang'] ?> - <?= $data['nama_ruang'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td>:</td>
                    <td>
                        <input type="number" value="1" name="jumlah" required >
                    </td>
                </tr>
                <tr>
                    <td>Kondisi Inventaris</td>
                    <td>:</td>
                    <td>
                        <select name="kondisi">
                            <option value="bagus">BAGUS</option>
                            <option value="rusak">RUSAK</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>:</td>
                    <td>
                        <textarea name="keterangan" required></textarea>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <input type="submit" name="tambah" value="Tambah">
                    </td>
                </tr>                
            </table>
            <?php
            if ($error == 1) :
                echo '<p>Kesalahan dalam menyimpan data kedalam database.</p>';
            endif;
            ?>
        </form>
    </body>
</html>
