<?php
session_start();

if (isset($_SESSION['login'])) {
    // Redirect the user to the login page or any other page as desired
    header('Location: ../');
    exit();
  }

function login($us, $pw) {
    $validUsername = 'admin';
    $validPassword = 'lahacia';
  
    // Check if the provided username and password match the valid credentials
    if ($us === $validUsername && $pw === $validPassword) {
      // Set the user's email in the session
      $_SESSION['login'] = true;
      return true;
    }
    return false;
  }

  if (isset($_POST["login"])) {
    $us = $_POST['username'];
    $pw = $_POST['password'];

    if (login($us, $pw)) {
        // Redirect to the dashboard or any other authenticated page
        header('Location: ../');
        exit();
    } else {
        // Redirect back to the login page with an error message
        header('Location: ./?error=1');
        exit();
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
  <title>Login Page</title>
</head>

<body class="flex justify-center items-center h-screen bg-gray-100">
  <div class="max-w-md w-full p-6 bg-white rounded-md shadow-md">
    <h1 class="text-2xl text-center font-bold mb-6">Admin</h1>
    <form method="POST">
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
        <input type="text" id="username" name="username" 
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" required>
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
        <input type="password" id="password" name="password" 
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" required>
      </div>
      <div class="flex items-center justify-between">
        <button name="login" type="submit" 
            class="bg-indigo-500 w-full hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Login</button>
      </div>
    <?php
        if (isset($_GET['error'])) {
            if($_GET['error'] == 1)
            echo "<p class='text-red-500 mt-2'>Silahkan coba Lagi!</p>";
            else{
                echo "<p class='text-red-500 mt-2'>Silahkan login terlebih dahulu!</p>";  
            }
        }
    ?>
    </form>
  </div>
</body>
</html>
