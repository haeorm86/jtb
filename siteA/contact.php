<?php
session_start();
require_once('../ContactController.php');
ob_start();

if($_POST) {
  unset($_SESSION['contact']);
  $contact = new ContactController();
  $contact->setData($_POST);

  if(!$contact->validation()) {
    $validate = $contact->getErrorMessage();
    $data = $contact->getData();
  }
  else {
    $_SESSION['contact'] = serialize($contact);
    header("Location: confirm.php", true, 301);
    exit;
  }
}
elseif($_SESSION && $_SESSION['contact']) {
  $contact = unserialize($_SESSION['contact']);
  $data = $contact->getData();
}
else {
  // 初期表示
  unset($_SESSION['contact']);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="keywords" content="以心伝心,ISHIN-DENSHIN,ロックフェス,フェス,イベント,music,ミュージック,音楽">
  <meta name="description" content="以心伝心 2018.2.10-2018.2.11にマニラで開催されるロックフェスイベントツアーの申し込み案内です。">
  <meta name="robots" content="noindex,nofollow">
  <meta name="author" content="JTB Developer">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>以心伝心 ISHIN-DENSHIN - イベントお申し込み</title>
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
        <h2>イベントお申し込みフォーム <small>※前ページのイベント案内をご確認の上、お申し込みください</small></h2>
        <!-- 入力フォーム -->
        <article class="input-area">
          <table>
            <tr>
              <th><label for="course">コース選択</label> <em>＊</em></th>
              <td>
                <select id="course" name="course">
                  <option value="">コース番号を選択してください</option>
                  <option value="HH-01（空港：羽田）" <?php if(!empty($data) && strpos($data['course'],"HH-01")!==false) echo "selected" ?>>HH-01（空港：羽田）</option>
                  <option value="NH-01（空港：成田）" <?php if(!empty($data) && strpos($data['course'],"NH-01")!==false) echo "selected" ?>>NH-01（空港：成田）</option>
                  <option value="KH-01（空港：関西）" <?php if(!empty($data) && strpos($data['course'],"KH-01")!==false) echo "selected" ?>>KH-01（空港：関西）</option>
                </select>
                <?php if(!empty($validate['course'])) echo "<br><em>".$validate['course']."</em>" ?>
              </td>
            </tr>
            <tr>
              <th><label for="name_sei">氏名漢字</label> <em>＊</em></th>
              <td>
                <input id="name_sei" name="name_sei" type="text" placeholder="例）山田" size="15" value="<?php if(!empty($data)) echo $data['name_sei'] ?>">
                <input id="name_mei" name="name_mei" type="text" placeholder="例）太郎" size="15" value="<?php if(!empty($data)) echo $data['name_mei'] ?>">
                <?php if(!empty($validate['name'])) echo "<br><em>".$validate['name']."</em>" ?>
              </td>
            </tr>
            <tr>
              <th><label for="name_sei_kana">氏名カナ</label> <em>＊</em></th>
              <td>
                <input id="name_sei_kana" name="name_sei_kana" type="text" placeholder="例）ヤマダ" size="15" value="<?php if(!empty($data)) echo $data['name_sei_kana'] ?>">
                <input id="name_mei_kana" name="name_mei_kana" type="text" placeholder="例）タロウ" size="15" value="<?php if(!empty($data)) echo $data['name_mei_kana'] ?>">
                <?php if(!empty($validate['name_kana'])) echo "<br><em>".$validate['name_kana']."</em>" ?>
              </td>
            </tr>
            <tr>
              <th><label for="gender">性　別</label> <em>＊</em></th>
              <td>
                <input id="gender" name="gender" type="radio" value="男" <?php if(!empty($data)) {if($data['gender']==="男") echo "checked";} else {echo "checked";} ?>>男
                <input name="gender" type="radio" value="女" <?php if(!empty($data) && $data['gender']==="女") echo "checked" ?>>女
                <?php if(!empty($validate['gender'])) echo "<br><em>".$validate['gender']."</em>" ?>
              </td>
            </tr>
            <tr>
              <th><label for="area">国　籍</label> <em>＊</em></th>
              <td>
                <input id="area" name="area" type="text" placeholder="例）日本" size="25" maxlength="20" value="<?php if(!empty($data)) echo $data['area'] ?>">
                <?php if(!empty($validate['area'])) echo "<br><em>".$validate['area']."</em>" ?>
              </td>
            </tr>
            <tr>
              <th><label for="birth-year">生年月日</label> <em>＊</em></th>
              <td>
                <select id="birth-year" name="birth-year">
                  <option value="">----</option>
                  <option value="1915" <?php if(!empty($data) && $data['birth-year']==1915) echo "selected" ?>>1915</option>
                  <option value="1916" <?php if(!empty($data) && $data['birth-year']==1916) echo "selected" ?>>1916</option>
                  <option value="1917" <?php if(!empty($data) && $data['birth-year']==1917) echo "selected" ?>>1917</option>
                  <option value="1918" <?php if(!empty($data) && $data['birth-year']==1918) echo "selected" ?>>1918</option>
                  <option value="1919" <?php if(!empty($data) && $data['birth-year']==1919) echo "selected" ?>>1919</option>
                  <option value="1920" <?php if(!empty($data) && $data['birth-year']==1920) echo "selected" ?>>1920</option>
                  <option value="1921" <?php if(!empty($data) && $data['birth-year']==1921) echo "selected" ?>>1921</option>
                  <option value="1922" <?php if(!empty($data) && $data['birth-year']==1922) echo "selected" ?>>1922</option>
                  <option value="1923" <?php if(!empty($data) && $data['birth-year']==1923) echo "selected" ?>>1923</option>
                  <option value="1924" <?php if(!empty($data) && $data['birth-year']==1924) echo "selected" ?>>1924</option>
                  <option value="1925" <?php if(!empty($data) && $data['birth-year']==1925) echo "selected" ?>>1925</option>
                  <option value="1926" <?php if(!empty($data) && $data['birth-year']==1926) echo "selected" ?>>1926</option>
                  <option value="1927" <?php if(!empty($data) && $data['birth-year']==1927) echo "selected" ?>>1927</option>
                  <option value="1928" <?php if(!empty($data) && $data['birth-year']==1928) echo "selected" ?>>1928</option>
                  <option value="1929" <?php if(!empty($data) && $data['birth-year']==1929) echo "selected" ?>>1929</option>
                  <option value="1930" <?php if(!empty($data) && $data['birth-year']==1930) echo "selected" ?>>1930</option>
                  <option value="1931" <?php if(!empty($data) && $data['birth-year']==1931) echo "selected" ?>>1931</option>
                  <option value="1932" <?php if(!empty($data) && $data['birth-year']==1932) echo "selected" ?>>1932</option>
                  <option value="1933" <?php if(!empty($data) && $data['birth-year']==1933) echo "selected" ?>>1933</option>
                  <option value="1934" <?php if(!empty($data) && $data['birth-year']==1934) echo "selected" ?>>1934</option>
                  <option value="1935" <?php if(!empty($data) && $data['birth-year']==1935) echo "selected" ?>>1935</option>
                  <option value="1936" <?php if(!empty($data) && $data['birth-year']==1936) echo "selected" ?>>1936</option>
                  <option value="1937" <?php if(!empty($data) && $data['birth-year']==1937) echo "selected" ?>>1937</option>
                  <option value="1938" <?php if(!empty($data) && $data['birth-year']==1938) echo "selected" ?>>1938</option>
                  <option value="1939" <?php if(!empty($data) && $data['birth-year']==1939) echo "selected" ?>>1939</option>
                  <option value="1940" <?php if(!empty($data) && $data['birth-year']==1940) echo "selected" ?>>1940</option>
                  <option value="1941" <?php if(!empty($data) && $data['birth-year']==1941) echo "selected" ?>>1941</option>
                  <option value="1942" <?php if(!empty($data) && $data['birth-year']==1942) echo "selected" ?>>1942</option>
                  <option value="1943" <?php if(!empty($data) && $data['birth-year']==1943) echo "selected" ?>>1943</option>
                  <option value="1944" <?php if(!empty($data) && $data['birth-year']==1944) echo "selected" ?>>1944</option>
                  <option value="1945" <?php if(!empty($data) && $data['birth-year']==1945) echo "selected" ?>>1945</option>
                  <option value="1946" <?php if(!empty($data) && $data['birth-year']==1946) echo "selected" ?>>1946</option>
                  <option value="1947" <?php if(!empty($data) && $data['birth-year']==1947) echo "selected" ?>>1947</option>
                  <option value="1948" <?php if(!empty($data) && $data['birth-year']==1948) echo "selected" ?>>1948</option>
                  <option value="1949" <?php if(!empty($data) && $data['birth-year']==1949) echo "selected" ?>>1949</option>
                  <option value="1950" <?php if(!empty($data) && $data['birth-year']==1950) echo "selected" ?>>1950</option>
                  <option value="1951" <?php if(!empty($data) && $data['birth-year']==1951) echo "selected" ?>>1951</option>
                  <option value="1952" <?php if(!empty($data) && $data['birth-year']==1952) echo "selected" ?>>1952</option>
                  <option value="1953" <?php if(!empty($data) && $data['birth-year']==1953) echo "selected" ?>>1953</option>
                  <option value="1954" <?php if(!empty($data) && $data['birth-year']==1954) echo "selected" ?>>1954</option>
                  <option value="1955" <?php if(!empty($data) && $data['birth-year']==1955) echo "selected" ?>>1955</option>
                  <option value="1956" <?php if(!empty($data) && $data['birth-year']==1956) echo "selected" ?>>1956</option>
                  <option value="1957" <?php if(!empty($data) && $data['birth-year']==1957) echo "selected" ?>>1957</option>
                  <option value="1958" <?php if(!empty($data) && $data['birth-year']==1958) echo "selected" ?>>1958</option>
                  <option value="1959" <?php if(!empty($data) && $data['birth-year']==1959) echo "selected" ?>>1959</option>
                  <option value="1960" <?php if(!empty($data) && $data['birth-year']==1960) echo "selected" ?>>1960</option>
                  <option value="1961" <?php if(!empty($data) && $data['birth-year']==1961) echo "selected" ?>>1961</option>
                  <option value="1962" <?php if(!empty($data) && $data['birth-year']==1962) echo "selected" ?>>1962</option>
                  <option value="1963" <?php if(!empty($data) && $data['birth-year']==1963) echo "selected" ?>>1963</option>
                  <option value="1964" <?php if(!empty($data) && $data['birth-year']==1964) echo "selected" ?>>1964</option>
                  <option value="1965" <?php if(!empty($data) && $data['birth-year']==1965) echo "selected" ?>>1965</option>
                  <option value="1966" <?php if(!empty($data) && $data['birth-year']==1966) echo "selected" ?>>1966</option>
                  <option value="1967" <?php if(!empty($data) && $data['birth-year']==1967) echo "selected" ?>>1967</option>
                  <option value="1968" <?php if(!empty($data) && $data['birth-year']==1968) echo "selected" ?>>1968</option>
                  <option value="1969" <?php if(!empty($data) && $data['birth-year']==1969) echo "selected" ?>>1969</option>
                  <option value="1970" <?php if(!empty($data) && $data['birth-year']==1970) echo "selected" ?>>1970</option>
                  <option value="1971" <?php if(!empty($data) && $data['birth-year']==1971) echo "selected" ?>>1971</option>
                  <option value="1972" <?php if(!empty($data) && $data['birth-year']==1972) echo "selected" ?>>1972</option>
                  <option value="1973" <?php if(!empty($data) && $data['birth-year']==1973) echo "selected" ?>>1973</option>
                  <option value="1974" <?php if(!empty($data) && $data['birth-year']==1974) echo "selected" ?>>1974</option>
                  <option value="1975" <?php if(!empty($data) && $data['birth-year']==1975) echo "selected" ?>>1975</option>
                  <option value="1976" <?php if(!empty($data) && $data['birth-year']==1976) echo "selected" ?>>1976</option>
                  <option value="1977" <?php if(!empty($data) && $data['birth-year']==1977) echo "selected" ?>>1977</option>
                  <option value="1978" <?php if(!empty($data) && $data['birth-year']==1978) echo "selected" ?>>1978</option>
                  <option value="1979" <?php if(!empty($data) && $data['birth-year']==1979) echo "selected" ?>>1979</option>
                  <option value="1980" <?php if(!empty($data) && $data['birth-year']==1980) echo "selected" ?>>1980</option>
                  <option value="1981" <?php if(!empty($data) && $data['birth-year']==1981) echo "selected" ?>>1981</option>
                  <option value="1982" <?php if(!empty($data) && $data['birth-year']==1982) echo "selected" ?>>1982</option>
                  <option value="1983" <?php if(!empty($data) && $data['birth-year']==1983) echo "selected" ?>>1983</option>
                  <option value="1984" <?php if(!empty($data) && $data['birth-year']==1984) echo "selected" ?>>1984</option>
                  <option value="1985" <?php if(!empty($data) && $data['birth-year']==1985) echo "selected" ?>>1985</option>
                  <option value="1986" <?php if(!empty($data) && $data['birth-year']==1986) echo "selected" ?>>1986</option>
                  <option value="1987" <?php if(!empty($data) && $data['birth-year']==1987) echo "selected" ?>>1987</option>
                  <option value="1988" <?php if(!empty($data) && $data['birth-year']==1988) echo "selected" ?>>1988</option>
                  <option value="1989" <?php if(!empty($data) && $data['birth-year']==1989) echo "selected" ?>>1989</option>
                  <option value="1990" <?php if(!empty($data) && $data['birth-year']==1990) echo "selected" ?>>1990</option>
                  <option value="1991" <?php if(!empty($data) && $data['birth-year']==1991) echo "selected" ?>>1991</option>
                  <option value="1992" <?php if(!empty($data) && $data['birth-year']==1992) echo "selected" ?>>1992</option>
                  <option value="1993" <?php if(!empty($data) && $data['birth-year']==1993) echo "selected" ?>>1993</option>
                  <option value="1994" <?php if(!empty($data) && $data['birth-year']==1994) echo "selected" ?>>1994</option>
                  <option value="1995" <?php if(!empty($data) && $data['birth-year']==1995) echo "selected" ?>>1995</option>
                  <option value="1996" <?php if(!empty($data) && $data['birth-year']==1996) echo "selected" ?>>1996</option>
                  <option value="1997" <?php if(!empty($data) && $data['birth-year']==1997) echo "selected" ?>>1997</option>
                  <option value="1998" <?php if(!empty($data) && $data['birth-year']==1998) echo "selected" ?>>1998</option>
                  <option value="1999" <?php if(!empty($data) && $data['birth-year']==1999) echo "selected" ?>>1999</option>
                  <option value="2000" <?php if(!empty($data) && $data['birth-year']==2000) echo "selected" ?>>2000</option>
                  <option value="2001" <?php if(!empty($data) && $data['birth-year']==2001) echo "selected" ?>>2001</option>
                  <option value="2002" <?php if(!empty($data) && $data['birth-year']==2002) echo "selected" ?>>2002</option>
                  <option value="2003" <?php if(!empty($data) && $data['birth-year']==2003) echo "selected" ?>>2003</option>
                  <option value="2004" <?php if(!empty($data) && $data['birth-year']==2004) echo "selected" ?>>2004</option>
                  <option value="2005" <?php if(!empty($data) && $data['birth-year']==2005) echo "selected" ?>>2005</option>
                  <option value="2006" <?php if(!empty($data) && $data['birth-year']==2006) echo "selected" ?>>2006</option>
                  <option value="2007" <?php if(!empty($data) && $data['birth-year']==2007) echo "selected" ?>>2007</option>
                  <option value="2008" <?php if(!empty($data) && $data['birth-year']==2008) echo "selected" ?>>2008</option>
                  <option value="2009" <?php if(!empty($data) && $data['birth-year']==2009) echo "selected" ?>>2009</option>
                  <option value="2010" <?php if(!empty($data) && $data['birth-year']==2010) echo "selected" ?>>2010</option>
                  <option value="2011" <?php if(!empty($data) && $data['birth-year']==2011) echo "selected" ?>>2011</option>
                  <option value="2012" <?php if(!empty($data) && $data['birth-year']==2012) echo "selected" ?>>2012</option>
                  <option value="2013" <?php if(!empty($data) && $data['birth-year']==2013) echo "selected" ?>>2013</option>
                  <option value="2014" <?php if(!empty($data) && $data['birth-year']==2014) echo "selected" ?>>2014</option>
                  <option value="2015" <?php if(!empty($data) && $data['birth-year']==2015) echo "selected" ?>>2015</option>
                </select>
                年
                <select name="birth-month">
                  <option value="">--</option>
                  <option value="1" <?php if(!empty($data) && $data['birth-month']==1) echo "selected" ?>>1</option>
                  <option value="2" <?php if(!empty($data) && $data['birth-month']==2) echo "selected" ?>>2</option>
                  <option value="3" <?php if(!empty($data) && $data['birth-month']==3) echo "selected" ?>>3</option>
                  <option value="4" <?php if(!empty($data) && $data['birth-month']==4) echo "selected" ?>>4</option>
                  <option value="5" <?php if(!empty($data) && $data['birth-month']==5) echo "selected" ?>>5</option>
                  <option value="6" <?php if(!empty($data) && $data['birth-month']==6) echo "selected" ?>>6</option>
                  <option value="7" <?php if(!empty($data) && $data['birth-month']==7) echo "selected" ?>>7</option>
                  <option value="8" <?php if(!empty($data) && $data['birth-month']==8) echo "selected" ?>>8</option>
                  <option value="9" <?php if(!empty($data) && $data['birth-month']==9) echo "selected" ?>>9</option>
                  <option value="10" <?php if(!empty($data) && $data['birth-month']==10) echo "selected" ?>>10</option>
                  <option value="11" <?php if(!empty($data) && $data['birth-month']==11) echo "selected" ?>>11</option>
                  <option value="12" <?php if(!empty($data) && $data['birth-month']==12) echo "selected" ?>>12</option>
                </select>
                月
                <select name="birth-day">
                  <option value="">--</option>
                  <option value="1" <?php if(!empty($data) && $data['birth-day']==1) echo "selected" ?>>1</option>
                  <option value="2" <?php if(!empty($data) && $data['birth-day']==2) echo "selected" ?>>2</option>
                  <option value="3" <?php if(!empty($data) && $data['birth-day']==3) echo "selected" ?>>3</option>
                  <option value="4" <?php if(!empty($data) && $data['birth-day']==4) echo "selected" ?>>4</option>
                  <option value="5" <?php if(!empty($data) && $data['birth-day']==5) echo "selected" ?>>5</option>
                  <option value="6" <?php if(!empty($data) && $data['birth-day']==6) echo "selected" ?>>6</option>
                  <option value="7" <?php if(!empty($data) && $data['birth-day']==7) echo "selected" ?>>7</option>
                  <option value="8" <?php if(!empty($data) && $data['birth-day']==8) echo "selected" ?>>8</option>
                  <option value="9" <?php if(!empty($data) && $data['birth-day']==9) echo "selected" ?>>9</option>
                  <option value="10" <?php if(!empty($data) && $data['birth-day']==10) echo "selected" ?>>10</option>
                  <option value="11" <?php if(!empty($data) && $data['birth-day']==11) echo "selected" ?>>11</option>
                  <option value="12" <?php if(!empty($data) && $data['birth-day']==12) echo "selected" ?>>12</option>
                  <option value="13" <?php if(!empty($data) && $data['birth-day']==13) echo "selected" ?>>13</option>
                  <option value="14" <?php if(!empty($data) && $data['birth-day']==14) echo "selected" ?>>14</option>
                  <option value="15" <?php if(!empty($data) && $data['birth-day']==15) echo "selected" ?>>15</option>
                  <option value="16" <?php if(!empty($data) && $data['birth-day']==16) echo "selected" ?>>16</option>
                  <option value="17" <?php if(!empty($data) && $data['birth-day']==17) echo "selected" ?>>17</option>
                  <option value="18" <?php if(!empty($data) && $data['birth-day']==18) echo "selected" ?>>18</option>
                  <option value="19" <?php if(!empty($data) && $data['birth-day']==19) echo "selected" ?>>19</option>
                  <option value="20" <?php if(!empty($data) && $data['birth-day']==20) echo "selected" ?>>20</option>
                  <option value="21" <?php if(!empty($data) && $data['birth-day']==21) echo "selected" ?>>21</option>
                  <option value="22" <?php if(!empty($data) && $data['birth-day']==22) echo "selected" ?>>22</option>
                  <option value="23" <?php if(!empty($data) && $data['birth-day']==23) echo "selected" ?>>23</option>
                  <option value="24" <?php if(!empty($data) && $data['birth-day']==24) echo "selected" ?>>24</option>
                  <option value="25" <?php if(!empty($data) && $data['birth-day']==25) echo "selected" ?>>25</option>
                  <option value="26" <?php if(!empty($data) && $data['birth-day']==26) echo "selected" ?>>26</option>
                  <option value="27" <?php if(!empty($data) && $data['birth-day']==27) echo "selected" ?>>27</option>
                  <option value="28" <?php if(!empty($data) && $data['birth-day']==28) echo "selected" ?>>28</option>
                  <option value="29" <?php if(!empty($data) && $data['birth-day']==29) echo "selected" ?>>29</option>
                  <option value="30" <?php if(!empty($data) && $data['birth-day']==30) echo "selected" ?>>30</option>
                  <option value="31" <?php if(!empty($data) && $data['birth-day']==31) echo "selected" ?>>31</option>
                </select>
                日
                <?php if(!empty($validate['birthday'])) echo "<br><em>".$validate['birthday']."</em>" ?>
              </td>
            </tr>
            <tr>
              <th><label for="zip1">自宅住所</label> <em>＊</em></th>
              <td>
                〒 <input id="zip1" name="zip1" type="text" size="3" maxlength="3" value="<?php if(!empty($data)) echo $data['zip1'] ?>">
                 -
                <input id="zip2" name="zip2" type="text" size="5" maxlength="4" value="<?php if(!empty($data)) echo $data['zip2'] ?>">
                <input id="address1" name="address1" type="text" placeholder="例）東京都中央区銀座１丁目１−１" size="75" value="<?php if(!empty($data)) echo $data['address1'] ?>">
                <input id="address2" name="address2" type="text" placeholder="アパート・マンション名" size="35" value="<?php if(!empty($data)) echo $data['address2'] ?>"><br>
                <small>※今後、ご案内書類をお送りする際は、こちらにご入力いただいた住所に送付させていただきます。</small>
                <?php if(!empty($validate['zip'])) echo "<br><em>".$validate['zip']."</em>" ?>
                <?php if(!empty($validate['address'])) echo "<br><em>".$validate['address']."</em>" ?>
              </td>
            </tr>
            <tr>
              <th><label for="email">メールアドレス</label> <em>＊</em></th>
              <td>
                <input id="email" name="email" type="email" placeholder="例）rockfes@event.jp" size="50" maxlength="100" value="<?php if(!empty($data)) echo $data['email'] ?>">
                <?php if(!empty($validate['email'])) echo "<br><em>".$validate['email']."</em>" ?>
              </td>
            </tr>
            <tr>
              <th><label for="tel">電話番号</label> <em>＊</em></th>
              <td>
                <input id="tel" name="tel" type="text" placeholder="例）090-1234-5678" size="20" maxlength="13" value="<?php if(!empty($data)) echo $data['tel'] ?>">
                <?php if(!empty($validate['tel'])) echo "<br><em>".$validate['tel']."</em>" ?>
              </td>
            </tr>
          </table>
        </article>

        <p><input id="submit" type="submit" name="submit" value="確認画面へ"></p>
      </form>
    </sction>

    <footer>
      <p>Copyright &copy; 2017-2018 JTB Corp. All Rights Reserved.</p>
    </footer>

  </div><!-- wrapper -->

  <script src="../js/jquery-3.2.1.min.js"></script>
  <script src="//jpostal-1006.appspot.com/jquery.jpostal.js"></script>
  <script>
  $(function () {
    $('#zip').jpostal({
      postcode : [
        '#zip1',
        '#zip2'
      ],
      address : {
        '#address1' : '%3%4%5'
      }
    });
  });
  </script>
</body>
</html>
