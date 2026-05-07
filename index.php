<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP CRUD Railway</title>
</head>
<body>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Buat tabel jika belum ada
mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    sandi VARCHAR(255) NOT NULL
)");

// Logika Create
if (isset($_POST['tambah'])) {
    $nama  = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $sandi = mysqli_real_escape_string($koneksi, $_POST['sandi']);
    mysqli_query($koneksi, "INSERT INTO users (nama, sandi) VALUES('$nama', '$sandi')");
    header("Location: index.php");
    exit;
}

// Logika Delete
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM users WHERE id=$id");
    mysqli_query($koneksi, "ALTER TABLE users AUTO_INCREMENT = 1"); 
    header("Location: index.php");
    exit;
}
?>
    <h2>Tambah Data</h2>
    <form method="POST">
        <input type="text"     name="nama"  placeholder="Nama"  required>
        <input type="password" name="sandi" placeholder="Sandi" required>
        <button type="submit" name="tambah">Simpan</button>
    </form>

    <h2>Data Users</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Sandi</th>
            <th>Aksi</th>
        </tr>
        <?php
        $data = mysqli_query($koneksi, "SELECT * FROM users");
        while ($d = mysqli_fetch_array($data)) : ?>
        <tr>
            <td><?php echo $d['id']; ?></td>
            <td><?php echo htmlspecialchars($d['nama']); ?></td>
            <td><?php echo htmlspecialchars($d['sandi']); ?></td>
            <td>
                <a href="index.php?hapus=<?php echo $d['id']; ?>"
                   onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
