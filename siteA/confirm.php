<?php
session_start();
require_once('../ContactController.php');
ob_start();

if($_POST) {
    if($_POST['submit'] === "上記内容で送信") {
      header("Location: complete.php", true, 301);
      exit;
    }
    else {
      header("Location: contact.php", true, 301);
      exit;
    }
}
elseif($_SESSION['contact']) {
  $contact = unserialize($_SESSION['contact']);
  $data = $contact->getData();
}
else {
  header("Location: contact.php", true, 301);
  exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="robots" content="noindex,nofollow">
  <meta name="author" content="JTB Developer">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>以心伝心 ISHIN-DENSHIN - イベントお申し込み確認</title>
  <link rel="stylesheet" type="text/css" href="../css/base.css">
  <link rel="stylesheet" type="text/css" href="css/contact.css">
  <link rel="stylesheet" type="text/css" href="css/contact_rwd.css">
</head>
<body>

  <div id="wrapper">
    <header>
      <h1><img src="img/header_title.png" alt="以心伝心 ヘッダーロゴ"></h1>
    </header>

    <section id="contact">
      <form action="" method="POST">
        <h2>イベントお申し込みフォーム</h2>
        <!-- 入力フォーム -->
        <article class="input-area">
          <table>
            <tr>
              <th>コース選択</th>
              <td>
                <?= $data['course'] ?>
              </td>
            </tr>
            <tr>
              <th>氏名漢字</th>
              <td>
                <?= $data['name_sei'] ?> <?= $data['name_mei'] ?>
              </td>
            </tr>
            <tr>
              <th>氏名カナ</th>
              <td>
                <?= $data['name_sei_kana'] ?> <?= $data['name_mei_kana'] ?>
              </td>
            </tr>
            <tr>
              <th>性　別</th>
              <td>
                <?= $data['gender'] ?>
              </td>
            </tr>
            <tr>
              <th>国　籍</th>
              <td>
                <?= $data['area'] ?>
              </td>
            </tr>
            <tr>
              <th><label for="birth-year">生年月日</label></th>
              <td>
                <?= $data['birth-year'] ?>
                年
                <?= $data['birth-month'] ?>
                月
                <?= $data['birth-day'] ?>
                日
              </td>
            </tr>
            <tr>
              <th><label for="zip1">自宅住所</label></th>
              <td>
                〒 <?= $data['zip1'] ?> - <?= $data['zip2'] ?><br>
                <?= $data['address1'] ?><br>
                <?= $data['address2'] ?>
              </td>
            </tr>
            <tr>
              <th><label for="email">メールアドレス</label></th>
              <td>
                <?= $data['email'] ?>
              </td>
            </tr>
            <tr>
              <th><label for="tel">電話番号</label></th>
              <td>
                <?= $data['tel'] ?>
              </td>
            </tr>
          </table>
        </article>

        <!-- 同意 -->
        <article class="agree-area">
        </article>

        <p>
          <input id="return" type="submit" name="submit" value="入力画面に戻る">
          <input id="submit" type="submit" name="submit" value="上記内容で送信">
        </p>
      </form>
    </sction>

    <footer>
      <p>Copyright &copy; 2017-2018 JTB Corp. All Rights Reserved.</p>
    </footer>

  </div><!-- wrapper -->
</body>
</html>
