<?php
require_once('../ContactController.php');

// ダイレクトチェック
if(!empty($_GET['ck']) && $_GET['ck'] === 'e4a48509ae20730e109db151b04d3d87') {
  $contact = new ContactController();
  // DBからデータを取得
  $result = $contact->exportCSV();

  /* PHPExcelを使用してエクセルを出力する */
  require_once('PHPExcel/Classes/PHPExcel.php');

  // メモリ制限
  $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
  $cacheSettings = array('memoryCacheSize' => '256MB');
  PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

  // Excelファイルの新規作成
  $objExcel = new PHPExcel();

  // シートの設定
  $objExcel->setActiveSheetIndex(0);
  $objSheet = $objExcel->getActiveSheet();

  // テーブルを生成する
  // 1レコード目にカラム名を出力
  $objSheet->setCellValue('A1', 'No');
  $objSheet->setCellValue('B1', '参照ページ');
  $objSheet->setCellValue('C1', 'メールアドレス');
  $objSheet->setCellValue('D1', '電話番号');
  $objSheet->setCellValue('E1', '氏名');
  $objSheet->setCellValue('F1', '氏名カナ');
  $objSheet->setCellValue('G1', 'コース番号');
  $objSheet->setCellValue('H1', '性別');
  $objSheet->setCellValue('I1', '国籍');
  $objSheet->setCellValue('J1', '生年月日');
  $objSheet->setCellValue('K1', '郵便番号');
  $objSheet->setCellValue('L1', '住所');
  $objSheet->setCellValue('M1', '建物名');
  $objSheet->setCellValue('N1', '登録日時');
  $objSheet->setAutoFilter('A1:N1');

  // 2レコード以降はデータを出力
  $i = 1;
  while ($row = $result->fetch_assoc()) {
    $i++;
    $objSheet->setCellValue('A'.$i, $row['no']);
    $objSheet->setCellValue('B'.$i, $row['refer_to_page']);
    $objSheet->setCellValue('C'.$i, $row['email']);
    $objSheet->setCellValue('D'.$i, $row['tel']);
    $objSheet->setCellValue('E'.$i, $row['name']);
    $objSheet->setCellValue('F'.$i, $row['name_kana']);
    $objSheet->setCellValue('G'.$i, $row['course']);
    $objSheet->setCellValue('H'.$i, $row['gender']);
    $objSheet->setCellValue('I'.$i, $row['area']);
    $objSheet->setCellValue('J'.$i, $row['birthday']);
    $objSheet->setCellValue('K'.$i, $row['zip']);
    $objSheet->setCellValue('L'.$i, $row['address1']);
    $objSheet->setCellValue('M'.$i, $row['address2']);
    $objSheet->setCellValue('N'.$i, $row['created']);
  }
  $objSheet->getStyle('A'.$i.':N'.$i)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));

  // エクセル出力
  $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
  header('Content-Type: application/octet-stream');
  header("Content-Disposition: attachment;filename=" . "ishin-denshin".date("Ymd").".xlsx");
  $objWriter->save('php://output');

  // メモリ解放
  $objExcel->disconnectWorksheets();
  unset($objWriter);
  unset($objSheet);
  unset($objExcel);
}
else {
  echo "Not Found Page.";
}
