<?php
// 関数ファイル読み込み
include('functions.php');
$pdo = connectToDb();

//入力チェック(受信確認処理追加)
if (
  !isset($_POST['task']) || $_POST['task'] == '' ||
  !isset($_POST['deadline']) || $_POST['deadline'] == ''
) {
  exit('ParamError');
}

//POSTデータ取得
$id = $_POST['id'];
$task = $_POST['task'];
$deadline = $_POST['deadline'];
$comment = $_POST['comment'];


//DB接続します(エラー処理追加)
$dbn = 'mysql:dbname=gsacfd04_13;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = '';

try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  exit('dbError:' . $e->getMessage());
}

//データ登録SQL作成

$sql = 'UPDATE php02_table SET task=:a1,deadline=:a2,comment=:a3 WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $task, PDO::PARAM_STR);
$stmt->bindValue(':a2', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':a3', $comment, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//4．データ登録処理後
if ($status == false) {
  showSqlErrorMsg($stmt);
} else {
  header('Location:select.php');
  exit;
}
