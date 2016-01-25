<?php
$conn = mysqli_connect('localhost', 'root', '9085');
mysqli_select_db($conn, 'opentutorials');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>HTML</title>
    <meta charset="utf-8">
    <style>
      #title {
        border-bottom:1px solid gray;
        padding:20px;
        margin-bottom:0;
      }
      #navigation {
        border-right:1px solid gray;
        width:100px;
        float:left;
        height:2000px;
        margin-top:0;
        padding-top:20px;
      }
      article{
        padding-left: 30px;
        float: left;
        width: 300px;
      }
      body.white{
        background-color: white;
        color:black;
      }
      body.black{
        background-color: black;
        color:white;
      }
    </style>
  </head>
  <body id="target" class="white">
    <h1 id="title">
      <a href="index.php">Vita Web Camp</a>
    </h1>
    <ol id="navigation">
      <?php
        $sql = "SELECT id,title FROM topic";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)){
          $title = htmlspecialchars($row['title']);
          print("<li><a href=\"index.php?id={$row['id']}\">{$title}</a></li>");
        }
       ?>
    </ol>
    <article>
    <?php
    if(empty($_GET['id'])){
    ?>
      <h2>Welcome to Vita WEB</h2>
    <?php
    } else {
      $id = mysqli_real_escape_string($conn, $_GET['id']);
      $sql = "SELECT * FROM topic WHERE id='{$id}'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);
    ?>
    <p>
      <h2><?php print(htmlspecialchars($row['title'])); ?></h2>
    </p>
    <p>
      <?php print(strip_tags($row['description'],'<h1><h2><h3><h4><h5><h6><a><ul><li><ol>'));?>
    </p>
    <div>
      <input type="button" id="white" value="white" onclick="document.getElementById('target').className='white'">
      <input type="button" id="black" value="black" onclick="document.getElementById('target').className='black'">
      <a href="write.php">write</a>
      <a href="modify.php?id=<?php print($_GET['id']);?>">modify</a>
      <form action="delete_process.php" method="post" onsubmit="return confirm('really?');">
        <input type="hidden" name="id" value="<?php print($_GET['id']);?>">
        <input type="submit" name="name" value="delete">
      </form>
    </div>
    <div>
      <form class="" action="comment_process.php" method="post">
        <p>
          이름 : <input type="text" name="author" value="">
        </p>
        <p>
          <textarea name="description" rows="8" cols="40"></textarea>
        </p>
        <input type="hidden" name="topic_id" value="<?php print($_GET['id'])?>">
        <p>
          <input type="submit" name="" value="댓글작성">
        </p>
      </form>
      <ul>
        <?php
          $sql = "SELECT * FROM comment WHERE topic_id='{$id}'";
          $result = mysqli_query($conn, $sql);
          while($row = mysqli_fetch_array($result)) {
            print("<li>{$description}</li>");
          }
        ?>
      </ul>
    </div>
    <?php
    }
    ?>
    </article>
  </body>
</html>
