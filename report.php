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

  <div class="container mx-auto">
        <p class="text-2xl font-medium mt-4">
        Jumlah Artikel : <?php
        
        $conn = mysqli_connect("localhost", "root", "", "db_jwp");
        $sql = "SELECT * FROM articles";
        $result = $conn->query($sql);
        if ($result) {
            $rowCount = $result->num_rows;
            echo $rowCount;
        } else {
            echo "Error executing the query: " . $conn->error;
        }

        ?>
    </p>
        <p class="text-2xl font-medium mt-4">
        Jumlah Semua Komentar :
        <?php
        
        $conn = mysqli_connect("localhost", "root", "", "db_jwp");
        $sql = "SELECT * FROM comments";
        $result = $conn->query($sql);
        if ($result) {
            $rowCount = $result->num_rows;
            echo $rowCount;
        } else {
            echo "Error executing the query: " . $conn->error;
        }

        ?>
    </p>

    <hr class="border-2 mt-3">
    
    <ul>
    <?php 
  
  $sql = "SELECT * FROM articles";
  $result = $conn->query($sql);
  $n=1;
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $id =  $row['article_id'];
        $sql2 = "SELECT * FROM comments where article_id = ". $id;
        $result2 = $conn->query($sql2);
        $rowCount = $result2->num_rows;
   ?>
        <li><?=$n++?>. <?= $row['title']?> : <?=$rowCount?> Komentar</li>
   
   <?php
    }
    ?>
     </ul>
  </div>

</body>
</html>
