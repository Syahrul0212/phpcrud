<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
        $tanggal_lahir = isset($_POST['tanggal_lahir']) ? $_POST['tanggal_lahir'] : '';
        $fakultas = isset($_POST['fakultas']) ? $_POST['fakultas'] : '';
        $jurusan = isset($_POST['jurusan']) ? $_POST['jurusan'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE mahasiswa SET id = ?, nama = ?, tanggal_lahir = ?,fakultas = ?, jurusan = ? WHERE id = ?');
        $stmt->execute([$id, $nama, $tanggal_lahir, $fakultas, $jurusan, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM mahasiswa WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Data doesn\'t exist with that NIM!');
    }
} else {
    exit('No NIM specified!');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update Data Mahasiswa #<?=$contact['id']?></h2>
    <form action="update.php?id=<?=$contact['id']?>" method="post">

        <label for="id">NIM</label>
        <input type="text" name="id" value="<?=$contact['id']?>" id="id">
        
        <label for="nama">Nama</label>
        <input type="text" name="nama" value="<?=$contact['nama']?>" id="nama">

        <label for="tanggal_lahir">tanggal_lahir</label>
        <input type="date" name="tanggal_lahir" value="<?=$contact['tanggal_lahir']?>" id="tanggal_lahir">

        <label for="fakultas">fakultas</label>
        <input type="text" name="fakultas" value="<?=$contact['fakultas']?>" id="fakultas">

        <label for="jurusan">jurusan</label>
        <input type="text" name="jurusan" value="<?=$contact['jurusan']?>" id="jurusan">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>