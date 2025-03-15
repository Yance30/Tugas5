<?php
session_start();

$timeout = 60;
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    session_unset();
    session_destroy();
    header("Location: login.php?message=session_expired");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = htmlspecialchars($_POST['nama']);
    $ttl = htmlspecialchars($_POST['ttl']);
    $sma = htmlspecialchars($_POST['SMA']);
    $pendidikan = htmlspecialchars($_POST['pendidikan']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $kontak = htmlspecialchars($_POST['kontak']);
    $sosmed = htmlspecialchars($_POST['sosmed']);

    $foto_path = 'uploads/default.jpg';
    
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024;

        if (in_array($_FILES['foto']['type'], $allowed_types) && $_FILES['foto']['size'] <= $max_size) {
            $foto_dir = 'uploads/';
            if (!is_dir($foto_dir)) {
                mkdir($foto_dir, 0777, true);
            }
            $foto_name = time() . "_" . basename($_FILES['foto']['name']);
            $foto_path = $foto_dir . $foto_name;
            move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path);
        }
    }
} else {
    header("Location: form_biodata.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>CV - <?php echo $nama; ?></title>
</head>
<body class="flex justify-center bg-gradient-to-r from-blue-900 to-black p-5 font-[Poppins]">
    <main class="flex flex-col md:flex-row w-full max-w-4xl bg-white shadow-lg border-2 border-gray-300 rounded-lg">
        <aside class="bg-gray-800 text-white p-6 w-full md:w-1/3">
            <div class="flex flex-col items-center">
                <img src="<?php echo $foto_path; ?>" alt="Foto Profil" class="w-40 h-60 rounded-full object-cover border-4 border-white">
                <h2 class="text-xl font-bold mt-4 text-center"> <?php echo $nama; ?> </h2>
            </div>
            <div class="mt-6">
                <h3 class="text-lg font-bold border-b border-gray-600 pb-1">CONTACT</h3>
                <p class="mt-3">📍 <?php echo $ttl; ?></p>
                <p class="mt-3">📞 <?php echo $kontak; ?></p>
                <p class="mt-3">📷 <a href="https://instagram.com/<?php echo $sosmed; ?>" target="_blank" class="text-blue-400">@<?php echo $sosmed; ?></a></p>
            </div>
        </aside>
        <section class="w-full md:w-4/3 p-6">
            <h1 class="text-gray-800 font-bold text-3xl text-center"> <?php echo $nama; ?> </h1>
            <h2 class="text-gray-500 text-lg text-center">SISTEM INFORMASI</h2>
            <div class="mt-6">
                <h3 class="text-lg font-bold border-b border-gray-600 pb-1">PROFILE</h3>
                <p class="mt-3 text-gray-700"> <?php echo $deskripsi; ?> </p>
            </div>
            <div class="mt-6">
                <h3 class="text-lg font-bold border-b border-gray-600 pb-1">EDUCATION</h3>
                <div class="mt-3">
                    <h4 class="font-semibold">Lulusan SMA</h4>
                    <p class="text-gray-700"> <?php echo $sma; ?> </p>
                </div>
                <div class="mt-3">
                    <h4 class="font-semibold">Pendidikan Sekarang</h4>
                    <p class="text-gray-700"> <?php echo $pendidikan; ?> </p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
