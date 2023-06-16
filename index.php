<?php
session_start();

// for logout
if (isset($_GET['logout'])) {
  // Redirect the user to the login page or any other page as desired
  session_destroy();
  echo "<script>alert('logout succesfully');
        location.href='./';</script>";
  exit();
}

$conn = mysqli_connect("localhost", "root", "", "db_jwp");

if(isset($_GET['hapus'])){
  $sql = "DELETE FROM articles WHERE article_id = " . $_GET['hapus'];
  $sql2 = "DELETE FROM comments WHERE article_id = " . $_GET['hapus'];
  $stmt = $conn->prepare($sql);
  $stmt2 = $conn->prepare($sql2);
  $stmt2->execute();
  $stmt->execute();

  // Check if the row was successfully deleted
  if ($stmt->affected_rows > 0) {
    echo "<script>alert('delete article is success');
    location.href='./';</script>";     
  } else {
    echo "<script>alert('delete article is failed');
    location.href='./';</script>";  
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <title>Mading Online JeWePe</title>
</head>

<body>
  <nav class="bg-gray-800 py-4">
    <div class="container space-x-3 mx-auto flex justify-between items-center">
      <div>
        <a href="./" class="text-white text-xl font-semibold">JWP Wall Magazine</a>
      </div>
      <div class="flex-grow">
      <form action="index.php" method="GET">
      <input type="text" name="search" placeholder="Search" class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg">
      </div>
      </form>
      <?php 
       if (isset($_SESSION['login'])){
        ?>
      <div>
        <a href="index.php?logout=1" class="bg-red-900 text-white px-4 py-2 rounded-lg">Logout</a>
      </div>
      <?php
        } 
      ?>
    </div>
  </nav>
  <?php 
       if (isset($_SESSION['login'])){
        ?>
  <div class="container mt-5 mx-auto ">
    <div class="flex justify-between items-center">
      <p class="text-lg font-serif">Hi Admin,</p>
      <div>
        <a href="add.php" class="bg-blue-900 text-white px-4 py-2 rounded-lg">Add Article</a>
        <a href="report.php" class="bg-yellow-600 text-white px-4 py-2 rounded-lg">Report 📃</a>
      </div>
    </div> 
    
<hr class="border-2 mt-4"> 
  </div>
      <?php
        } 
      ?>
  <div class="container my-12 mx-auto grid gap-16 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">

  <?php 
  if(isset($_GET['search'])){
    $search = $_GET['search'];
    $sql = "SELECT * FROM articles WHERE title LIKE '%" . $search . "%'";
  }else{
    $sql = "SELECT * FROM articles";
  }
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {

   ?>
    <div class="max-w-sm bg-white rounded-lg shadow-md overflow-hidden h-200">
  <div class="relative h-64">
    <img src="assets/img/<?= $row['content_file']?>" alt="Article Image" class="w-full h-full object-cover">
  </div>
  <div class="p-4">
    <h3 class="text-xl font-semibold mb-2"><?php echo $row['title']; ?>, <span class="text-base font-normal"><?php echo $row['created_at']; ?></span></h3> 
    <p class="text-gray-700 mb-4"><?php echo substr($row['content_text'], 0, 100); ?>...</p>
    <div class="flex justify-between items-center">
      <a href="article.php?id=<?=$row['article_id']?>" class="text-white px-2 py-1 rounded bg-blue-600 shadow">Read more</a>
      <?php
             if (isset($_SESSION['login'])){
              ?>
      <a href="index.php?hapus=<?= $row['article_id']?>" class="text-white px-2 py-1 rounded bg-red-600 shadow">Hapus</a>
      
      <?php
        } 
      ?>
    </div>
  </div>
</div>
  <?php     }
} else {
    echo "no articles";
} ?>
    <!-- Add more article cards as needed -->
  </div>
  <!-- Your content goes here -->
</body>
</html>
