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

  <?php 
  
    $conn = mysqli_connect("localhost", "root", "", "db_jwp");
    $id = $_GET['id'];
    $sql = "SELECT * FROM `articles` where article_id = " . $id;

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
  ?>

    <div class='max-w-2xl mb-10 mx-auto'>
        <p class='mt-20 text-4xl font-bold tracking-tight'><?= $row['title']?>,<span class="text-lg font-normal"><?= $row['created_at']?></span></p>
        <hr class='border-2 my-3'/>
        <p class='text-lg'>
           <?= $row['content_text']?>
        </p>
        <a href="assets/img/<?=$row['content_file']?>" class="mt-2 text-blue-600 hover:underline hover:underline-offset-2" download>Download File</a>
        <hr class='border-2 my-3'/>
        <?php
             if (!isset($_SESSION['login'])){
              ?>
    <div class="p-6">
                
  <h3 class="text-xl font-semibold mb-4">Leave a Comment</h3>
  <form method="POST">
    <div class="flex space-x-5">
        <div class="mb-4 w-full">
          <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
          <input type="text" id="name" name="name" class="border border-gray-300 px-4 py-2 rounded-md w-full focus:outline-none focus:ring focus:border-blue-500" required>
        </div>
        <div class="mb-4 w-full">
          <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
          <input type="email" id="email" name="email" class="border border-gray-300 px-4 py-2 rounded-md w-full focus:outline-none focus:ring focus:border-blue-500" required>
        </div>
    </div>
    <div class="mb-4">
      <label for="comment" class="block text-gray-700 font-medium mb-2">Comment</label>
      <textarea id="comment" name="comment" rows="4" class="border border-gray-300 px-4 py-2 rounded-md w-full resize-none focus:outline-none focus:ring focus:border-blue-500" required></textarea>
    </div>
    <button name="submit" type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md">Submit</button>
  </form>
</div>

<?php
if (isset($_POST['submit'])) {

    $n = $_POST['name'];
    $e = $_POST['email'];
    $c = $_POST['comment'];

        $sql = mysqli_query($conn, "INSERT INTO `comments` (`article_id`,`name`, `email`, `comment`) 
        VALUES ('$id',
                '$n',
                '$e',
                '$c'
                )");
echo "<script>alert('add new article is successful');
location.href='article.php?id=" . $id . "';</script>";
}

?>

<hr class='border-2 my-3'/> 
<?php
             }
             ?>
    <div>
    <?php 
  
  $sql = "SELECT * FROM comments where article_id = $id";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {

   ?>
        <div class="bg-white p-6">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center">
                    <div class="bg-gray-300 w-10 h-10 rounded-full mr-4"></div>
                    <div>
                        <h3 class="text-lg font-semibold"><?=$row['name']?></h3>
                        <p class="text-gray-500"><?=$row['email']?></p>
                    </div>
                </div>
                <?php
             if (isset($_SESSION['login'])){
              ?>
                <div>
                    <a href="article.php?hapus=<?=$row['comment_id']?>&id=<?=$id?>" class="text-red-600">
                    Hapus
                    </a>
                </div>
                <?php
             }
             ?>
            </div>
            <p class="text-gray-800"><?=$row['comment']?>

        <?php     }
} else {
    echo "no comments";
}



if(isset($_GET['hapus'])){
    $sql = "DELETE FROM comments WHERE comment_id = " . $_GET['hapus'];
    $stmt = $conn->prepare($sql);
    $stmt->execute();
  
    // Check if the row was successfully deleted
    if ($stmt->affected_rows > 0) {
      echo "<script>alert('delete comment is success');
      location.href='article.php?id=".$id."';</script>";     
    } else {
      echo "<script>alert('delete comment is failed');
      location.href='article.php?id=".$id."';</script>";  
    }
  }

?>
    </div>
        </div>

</body>
</html>
