<?php
session_start();

$error = isset($_SESSION['error']) ? $_SESSION['error'] : "";
unset($_SESSION['error']);

$allowed_email = "yansgrouppansi@gmail.com";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format email tidak valid!";
        header("Location: login.php");
        exit();
    }
    
    if ($username !== $allowed_email) {
        $_SESSION['error'] = "Email tidak terdaftar!";
        header("Location: login.php");
        exit();
    }
    
    $correctPassword = "@gmail.com";
    
    if ($password === $correctPassword) {
        $_SESSION['username'] = $username;
        header("Location: form.php");
        exit();
    } else {
        $_SESSION['error'] = "Password salah!";
        header("Location: login.php"); 
        exit();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-900 to-black">
  <div class="w-full max-w-4xl bg-white shadow-2xl rounded-xl overflow-hidden flex flex-col md:flex-row">
    <div class="md:w-1/2 bg-blue-600 flex flex-col justify-center items-center text-white p-10">
      <h2 class="text-4xl font-bold">Selamat Datang</h2>
      <p class="mt-4 text-lg text-center">Silakan login untuk melanjutkan</p>
    </div>
    <div class="md:w-1/2 p-10">
      <h2 class="text-3xl font-bold text-center text-blue-600">Login</h2>
      <?php if ($error): ?>
        <p class="text-white bg-red-600 p-3 rounded mt-4 text-center"><?php echo $error; ?></p>
      <?php endif; ?>
      <form action="login.php" method="post" class="mt-6">
        <label for="username" class="block font-semibold text-gray-700">Username</label>
        <input class="w-full border rounded-lg p-3 mt-2 focus:outline-none focus:ring-2 focus:ring-blue-600" type="text" id="username" name="username" placeholder="Masukkan email Anda" autocomplete="off" required>
        
        <label for="password" class="block font-semibold text-gray-700 mt-4">Password</label>
        <input class="w-full border rounded-lg p-3 mt-2 focus:outline-none focus:ring-2 focus:ring-blue-600" type="password" id="password" name="password" placeholder="*******" autocomplete="off" required>
        
        <button class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg mt-6 hover:bg-blue-700 transition duration-300" type="submit" name="login">Login</button>
      </form>
    </div>
  </div>
</body>
</html>
