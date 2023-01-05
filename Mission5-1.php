<?php
$eName = "";
$eComment = "";
$ePassword = "";
$edit = "";
//MySqlへの接続
$dsn = 'mysql:dbname=tb240544db;host=localhost';
$user = 'tb-240544';
$password = '5ykNNuyHWN';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = "CREATE TABLE IF NOT EXISTS mdata"
    ."("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "password TEXT,"
    . "date TEXT"
    .");";
    $stmt = $pdo->query($sql);
    
    
//パスワード定義
if(isset($_POST["dnumber"])){
    $id = $_POST["dnumber"];
$sql = 'SELECT * FROM mdata WHERE id=:id ';
$stmt = $pdo->prepare($sql);                 
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();                             
$results = $stmt->fetchAll(); 
    foreach ($results as $row){
        $DP = $row["password"];
    }
}
if(isset($_POST["edit"])){
    $id = $_POST["edit"];
$sql = 'SELECT * FROM mdata WHERE id=:id ';
$stmt = $pdo->prepare($sql);                 
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();                             
$results = $stmt->fetchAll(); 
    foreach ($results as $row){
        $EP = $row["password"];
    }
}

    

//記入処理
if(isset($_POST["submit1"]) && empty($_POST["hide"])){
$sql = $pdo -> prepare("INSERT INTO mdata (name, comment, password, date) VALUES (:name, :comment, :password, :date)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':password', $password, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $password = $_POST["password"];
    $date = date("Y年m月d日H:i:s");
    $sql -> execute();
//表記処理
   $sql = 'SELECT * FROM mdata';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['password'].',';
        echo $row['date'].'<br>';
    echo "<hr>";
    }
}

//削除処理
if(isset($_POST["submit2"]) && $_POST["Dpassword"] == $DP){
$id = $_POST["dnumber"];
    $sql = 'delete from mdata where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $sql = 'SELECT * FROM mdata';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['password'].',';
        echo $row['date'].'<br>';
    echo "<hr>";
    }
}
//編集事前処理(変数取得)
if(isset($_POST["submit3"]) && $_POST["Epassword"] == $EP){
    $id = $_POST["edit"];
$sql = 'SELECT * FROM mdata WHERE id=:id ';
$stmt = $pdo->prepare($sql);                 
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();                             
$results = $stmt->fetchAll(); 
    foreach ($results as $row){
        $eName = $row["name"];
        $eComment = $row["comment"];
        $ePassword = $row["password"];
    }
}

//編集処理
if(isset($_POST["submit1"]) && isset($_POST["hide"])){
    $id = $_POST["hide"];
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $password = $_POST["password"];
    $sql = 'UPDATE mdata SET name=:name,comment=:comment, password=:password WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':password', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $sql = 'SELECT * FROM mdata';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['password'].',';
        echo $row['date'].'<br>';
    echo "<hr>";
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = UTF-8>
        <title "Mission_5-1">
        </title>
    </head>
    <body>
      <form action="" method="post">
        <input type="hidden" name="hide" value="<?php if($_POST["edit"] != 0){
        echo $_POST["edit"];}?>">
        <input type="text" name="name" placeholder="名前" value="<?php echo $eName?>">
        <input type="text" name="comment" placeholder="コメント" value="<?php echo $eComment?>">
        <input type="text" name="password" placeholder="パスワード" value="<?php echo $ePassword?>">
        <input type="submit" name="submit1">
        <input type="number" name="dnumber" placeholder="削除対象番号">
        <input type="text" name="Dpassword" placeholder="パスワード">
        <input type="submit" name="submit2" value="削除">
        <input type="number" name="edit" placeholder="編集番号">
        <input type="text" name="Epassword" placeholder="パスワード">
        <input type="submit" name="submit3" value="編集">
      </form>
    </body>
    <span style="font-size:50px">好きな食べ物をコメント欄に書いてください</span><br>
    <span style="font-size:50px">パスワードは何でも大丈夫です</span><br>
    </body>
</html>