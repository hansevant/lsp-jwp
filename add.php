<?php
session_start();

if (!isset($_SESSION['login'])) {
    // Redirect the user to the login page or any other page as desired
    header('Location: admin/?error=0');
    exit();
  }
// connect database
$conn = mysqli_connect("localhost", "root", "", "db_jwp");
// function add article
if (isset($_POST['submit'])) {

    $type = array('png', 'jpg', 'jpeg');

    $title = $_POST['title'];
    $article = $_POST['article'];
    $random_number = round(microtime(true));
    $file_name = $_FILES['img']['name'];

    $x = explode('.', $file_name);
    $format = strtolower(end($x));

    $file_tmp = $_FILES['img']['tmp_name'];
    $new_file_name = $random_number . '_' . $file_name;

    if (in_array($format, $type) === true) {
        @move_uploaded_file($file_tmp, "assets/img/" . $new_file_name);
        $sql = mysqli_query($conn, "INSERT INTO `articles` (title, content_text, content_file) 
        VALUES ('$title',
                '$article',
                '$new_file_name'
                )");
        echo "<script>alert('add new article is succesfully');
        location.href='./';</script>";     
    }   else {
        echo "<script>alert('please add an image');
        location.href='add.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Input Article</title>
</head>
<body>
<nav class="bg-gray-800 py-4">
  <div class="container space-x-3 mx-auto flex justify-between items-center">
    <div>
      <a href="./" class="text-white text-xl font-semibold">JWP Wall Magazine</a>
    </div>
    <div>
      <a href="index.php?logout=1" class="bg-gray-900 text-white px-4 py-2 rounded-lg">Log-out</a>
    </div>
  </div>
</nav>

<div class="mx-auto max-w-lg shadow-lg rounded-lg border p-8 bg-white my-10">
  <div class="max-w-md w-ful">
    <h1 class="text-2xl font-bold mb-3">Add Article</h1>
    <hr class="mb-3 border-2">
    <form method="POST" enctype="multipart/form-data">
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Title*</label>
        <input type="text" id="title" name="title" 
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" required>
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="article">Article*</label>
        <textarea id="article" name="article" class='border p-2.5 rounded-lg block w-full' required></textarea>
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="img">Image</label>
        <input type="file" id="img" name="img" required 
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500">
      </div>
      <div class="flex items-center justify-between">
        <button name="submit" type="submit" 
            class="bg-indigo-500 w-full hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Submit</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>