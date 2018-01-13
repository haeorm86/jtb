<?php
session_start();
require_once('../ContactController.php');
ob_start();

$message = "";
if($_SESSION['contact']) {
  $contact = unserialize($_SESSION['contact']);
  if($contact->regist()) {

    if($contact->sendMail()) {
      unset($_SESSION['contact']);
      $message .= "<p class='message'>ありがとうございました。申し込みが完了しました。<br>";
      $message .= "お申し込みいただきましたメールアドレスに自動返信メールをお送りしました。<br>";
      $message .= "今後のお知らせ等はJTB関東からお申し込みいただいたメールアドレスにお送りしますので忘れずご確認のほどお願い致します。<br>";
      $message .= "もしメールが届いていない場合、迷惑メールボックスに入っていないか今一度ご確認ください。<br>";
      $message .= "それ以外、何かございましたら下記までご連絡ください。<br>";
      $message .= "TEL: 03-6894-0890";
      $message .= "</p>";
    }
    else {
      $message .= "<p class='message'>ありがとうございました。申し込みが完了しました。<br>";
      $message .= "お申し込みいただきましたメールアドレスに自動返信メールをお送りできませんでした。<br>";
      $message .= "今後のお知らせ等はお申し込みいただくメールアドレスにお送りしますので大変お手数ですが下記までご連絡ください。<br>";
      $message .= "TEL: 03-6894-0890";
      $message .= "</p>";
    }
  }
  else {
    $message .= "<p class='message'>申し訳ありません。<br>";
    $message .= "残念ながらサーバ混雑のため、イベントお申し込みができませんでした。<br>";
    $message .= "大変お手数ですが、もう一度お申し込みください。";
    $message .= "</p>";
  }
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
  <meta name="author" content="JTB">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>以心伝心 ISHIN-DENSHIN - イベントお申し込み完了</title>
  <link rel="stylesheet" type="text/css" href="../css/base.css">
  <link rel="stylesheet" type="text/css" href="css/contact.css">
  <link rel="stylesheet" type="text/css" href="css/contact_rwd.css">
</head>
<body>
  <header>
    <h1><img src="img/header_title.png" alt="以心伝心 ヘッダーロゴ"></h1>
  </header>

  <div id="wrapper">
    <article id="contact">
      <h2>お申し込み完了</h2>

      <!-- 完了メッセージ -->
      <article class="message-area">
        <?= $message ?>
        <p class="toplink"><a href="./">トップページへ戻る</a></p>
      </article>


  </div><!-- wrapper -->

  <footer>
    <p>Copyright 2017-2018 JTB All Rights Reserved.</p>
  </footer>
</body>
</html>
