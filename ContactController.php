<?php
// DB接続用
// define("HOST", "localhost");
// define("USERNAME", "sqluser");
// define("PASSWORD", "dev@999");
// define("DATABASE", "jtbfes");

define("HOST", "sddb0040214334.cgidb");
define("USERNAME", "sddbMTg5NjU5");
define("PASSWORD", '$R4MU8mR');
define("DATABASE", "sddb0040214334");

class ContactController {

  private $data;
  private $lastId;
  private $validate = array(
    'course',
    'name',
    'name_kana',
    'gender',
    'area',
    'birthday',
    'zip',
    'address',
    'email',
    'tel'
  );
  private $mysqli = null;
  private $stmt = null;

  // POSTデータを返す
  public function getData() {
    return $this->data;
  }

  // POSTデータをセットする
  public function setData($data) {
    $this->data = $data;
  }

  // エラーメッセージを返す
  public function getErrorMessage() {
    return $this->validate;
  }

  // POSTデータをDBに登録する
  public function regist() {
    $result = false;

    try {
      $this->mysqli = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
      if ($this->mysqli->connect_error) {
        return $result;
      }
      $this->mysqli->set_charset("utf8");

      $sql = "";
      $sql .= "INSERT INTO ";
      $sql .= "entries (";
      $sql .= "refer_to_page,";
      $sql .= "course,";
      $sql .= "name,";
      $sql .= "name_kana,";
      $sql .= "gender,";
      $sql .= "area,";
      $sql .= "birthday,";
      $sql .= "zip,";
      $sql .= "address1,";
      $sql .= "address2,";
      $sql .= "email,";
      $sql .= "tel,";
      $sql .= "created";
      $sql .= ") ";
      $sql .= "VALUES (";
      $sql .= "?,";
      $sql .= "?,";
      $sql .= "?,";
      $sql .= "?,";
      $sql .= "?,";
      $sql .= "?,";
      $sql .= "?,";
      $sql .= "?,";
      $sql .= "?,";
      $sql .= "?,";
      $sql .= "?,";
      $sql .= "?,";
      $sql .= "?";
      $sql .= ")";

      // bind_param用変数にセットする（bind_paramに値や関数を直接渡すとエラーとなるため）
      $refer_to_page = basename(dirname($_SERVER['SCRIPT_NAME']));
      $course = substr($this->data['course'],0,5);
      $name = $this->data['name_sei'] ." ". $this->data['name_mei'];
      $name_kana = $this->data['name_sei_kana'] ." ". $this->data['name_mei_kana'];
      $birthday = $this->data['birth-year'] ."-". $this->data['birth-month'] ."-". $this->data['birth-day'];
      $zip = $this->data['zip1'] . $this->data['zip2'];
      $created = date("Y-m-d H:i:s");

      // プリペアドステートメントで値をバインドして実行する
      $this->stmt = $this->mysqli->prepare($sql);
      $this->stmt->bind_param(
        "sssssssssssss",
        $refer_to_page,
        $course,
        $name,
        $name_kana,
        $this->data['gender'],
        $this->data['area'],
        $birthday,
        $zip,
        $this->data['address1'],
        $this->data['address2'],
        $this->data['email'],
        $this->data['tel'],
        $created
      );
      $result = $this->stmt->execute();
      $this->lastId = $this->mysqli->insert_id;
    }
    catch (Exception $e) {
      return $result;
    }
    finally {
      $this->stmt->close();
      $this->mysqli->close();
    }

    return $result;
  }

  // ツアー申込者に対して自動返信メールを送信する
  public function sendMail() {
    $result = false;

    mb_language("Japanese");
    mb_internal_encoding("UTF-8");

    $to = $this->data['email'];
    $subject = "【自動返信】以心伝心マニラツアーのお問い合わせ有難う御座います。";
    $body = $this->data['name_sei'] ." ". $this->data['name_mei'] ." 様";
    $body .= "\n\n";
    $body .= "このたびは「以心伝心マニラツアー」にお問い合わせ頂き、ありがとうございます。\n";
    $body .= "お客様が入力された内容は下記の通りです。万一誤入力等ございましたら、お手数ですがお電話にてお問い合わせください。\n";
    $body .= "（TEL：03-6894-0890）\n";
    $body .= "\n";
    $body .= "----------------------------------------\n";
    $body .= "\n";
    $body .= "お申し込み番号: " .sprintf('%03d',$this->lastId). "\n";
    $body .= "コース番号: " .$this->data['course']. "\n";
    $body .= "氏名: " .$this->data['name_sei'] ." ". $this->data['name_mei']. "\n";
    $body .= "氏名カナ: " .$this->data['name_sei_kana'] ." ". $this->data['name_mei_kana']. "\n";
    $body .= "性別: " .$this->data['gender']. "\n";
    $body .= "国籍: " .$this->data['area']. "\n";
    $body .= "生年月日: " .$this->data['birth-year'] ."-". $this->data['birth-month'] ."-". $this->data['birth-day']. "\n";
    $body .= "郵便番号: 〒" .$this->data['zip1'] . $this->data['zip2']. "\n";
    $body .= "住所: " .$this->data['address1'] ." ". $this->data['address2']. "\n";
    $body .= "メールアドレス: " .$this->data['email']. "\n";
    $body .= "電話番号: " .$this->data['tel']. "\n";
    $body .= "\n";
    $body .= "----------------------------------------\n";
    $body .= "なお、このご入力フォームはお申込みでは御座いません。\n";
    $body .= "ご入力いただきましたメールアドレスに以心伝心ツアーデスクよりご旅行パンフレット、お申込書、ご旅行条件書が届きます。\n";
    $body .= "\n";
    $body .= "大変お手数お掛け致しますが、ご旅行パンフレット・ご旅行条件書をご確認いただいた後、お申込書を下記の「以心伝心ツアーデスク」までメール、FAX、郵送のいずれかにてお送りいただきますよう、よろしくお願い申し上げます。\n";
    $body .= "\n";
    $body .= "メールが受け取れない場合、書類をダウンロード出来ない場合、その旨を下記のツアーデスクまでお手数お掛け致しますがご連絡いただければと思います。\n";
    $body .= "以心伝心ツアーデスクより郵送にて資料をお送りさせていただきます。\n";
    $body .= "\n";
    $body .= "※このメールアドレスは送信専用です。本メールへ返信頂いても対応はできかねます。\n";
    $body .= "\n";
    $body .= "------------------------------------------------\n";
    $body .= "「以心伝心マニラツアー」ツアーデスク\n";
    $body .= "住所：〒170-0013　東京都豊島区東池袋3-23-14　ダイハツ・ニッセイ池袋ビル6階\n";
    $body .= "【TEL】03-6894-0890　【FAX】03-5950-5193\n";
    $body .= "【E-MAIL】ishindenshin-manira@jbn.jtb.jp\n";
    $body .= "営業時間：月～金／10：00～17：30 ※土日祝祭日を除く\n";
    $body .= "------------------------------------------------\n";

    $from = "From: ".mb_encode_mimeheader("「以心伝心マニラツアー」ツアーデスク")."<ishindenshin@monde-luce.tokyo>";
    $from .= "\n";
    $from .= "Bcc: ishindenshin@monde-luce.tokyo,kurosawa-k@monde-luce.tokyo";
    // $from .= "Bcc: b2040360@gmail.com";

    $result = mb_send_mail($to, $subject, $body, $from);

    return $result;
  }

  // 登録している参加者データをCSVに起こす（ダウンロードするのは前日までのデータ）
  public function exportCSV() {
    $result = array();

    try {
      $this->mysqli = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
      if ($this->mysqli->connect_error) {
        return $result;
      }
      $this->mysqli->set_charset("utf8");

      $sql = "SELECT * FROM entries WHERE created > " .date("Y-m-d");
      $result = $this->mysqli->query($sql);
    }
    catch (Exception $e) {
      return $result;
    }
    finally {
      $this->mysqli->close();
    }

    return $result;
  }

  // POSTデータの入力チェックを行う
  public function validation() {
    $result = true;

    // コース
    if(empty($this->data['course'])) {
      $this->validate['course'] = "コースを選択してください";
      $result = false;
    }

    // 氏名漢字
    if(empty($this->data['name_sei']) || empty($this->data['name_mei'])) {
      $this->validate['name'] = "氏名漢字を入力してください";
      $result = false;
    }

    // 氏名カナ
    if(empty($this->data['name_sei_kana']) || empty($this->data['name_mei_kana'])) {
      $this->validate['name_kana'] = "氏名カナを入力してください";
      $result = false;
    }
    else {
      if(!preg_match("/^[ァ-ヶー]+$/u", $this->data['name_sei_kana']) || !preg_match("/^[ァ-ヶー]+$/u", $this->data['name_mei_kana'])) {
        $this->validate['name_kana'] = "すべてカタカナで入力してください";
        $result = false;
      }
    }

    // 性別
    if(empty($this->data['gender'])) {
      $this->validate['gender'] = "性別を選択してください";
      $result = false;
    }

    // 国籍
    if(empty($this->data['area'])) {
      $this->validate['area'] = "国籍を入力してください";
      $result = false;
    }

    // 生年月日
    if(empty($this->data['birth-year']) && empty($this->data['birth-month']) && empty($this->data['birth-day'])) {
      $this->validate['birthday'] = "生年月日を入力してください";
      $result = false;
    }
    else {
      if(!checkdate($this->data['birth-month'],$this->data['birth-day'],$this->data['birth-year'])) {
        $this->validate['birthday'] = "日付が正しくありません";
        $result = false;
      }
    }

    // 住所チェック 形式：都道府県＋市区町村
    if(empty($this->data['zip1']) || empty($this->data['zip2'])) {
      $this->validate['zip'] = "郵便番号を入力してください";
      $result = false;
    }
    elseif(empty($this->data['address1'])) {
      $this->validate['address'] = "住所を入力してください";
      $result = false;
    }
    else {
      if(!preg_match("/^(東京都|北海道|(?:京都|大阪)府|.{6,9}県)((?:四日市|廿日市|野々市|かすみがうら|つくばみらい|いちき串木野)市|(?:杵島郡大町|余市郡余市|高市郡高取)町|.{3,12}市.{3,12}区|.{3,9}区|.{3,15}市(?=.*市)|.{3,15}市|.{6,27}町(?=.*町)|.{6,27}町|.{9,24}村(?=.*村)|.{9,24}村)(.*)/",$this->data['address1'])) {
        $this->validate['address'] = "住所が正しくありません";
        $result = false;
      }
    }

    // メールアドレスチェック 形式：xxxx@xxxx.xxx
    if(empty($this->data['email'])) {
      $this->validate['email'] = "メールアドレスを入力してください";
      $result = false;
    }
    else {
      if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $this->data['email'])) {
        $this->validate['email'] = "メールアドレスを正しくありません";
        $result = false;
      }
    }

    // 電話番号チェック
    if(empty($this->data['tel'])) {
      $this->validate['tel'] = "電話番号を入力してください";
      $result = false;
    }
    else {
      if(!preg_match("/^(03|06|050|070|080|090)\d{4}\d{4}$/", $this->data['tel']) && !preg_match("/^(03|06|050|070|080|090)-\d{4}-\d{4}$/", $this->data['tel'])) {
        $this->validate['tel'] = "電話番号が正しくありません";
        $result = false;
      }
    }

    return $result;
  }

}
