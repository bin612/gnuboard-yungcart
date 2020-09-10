<?php
include_once('./_common.php');

// if(!$is_admin)
//     alert('접근 권한이 없습니다.', G5_URL);

$tmp_array = array();
$tmp_array = $_GET['od_id'];
$tmp_array1 = $_GET['mb_id'];
// $chk_count = count($tmp_array);

$article_t = 0;

$article__a = array();

include_once(G5_LIB_PATH.'/PHPExcel.php');

$headers = array('주문번호','상품명','수량','옵션금액');
$widths  = array(40,40,40);
$header_bgcolor = 'EFEFEF';
$last_char = column_char(count($headers) - 1);
// 검색하고자 하는 쿼리 생성 (단일(od_id) 전체(mb_id) 다운로드 조건변수명으로 주기)

if($_GET['od_id']){
    $where = "od_id = '{$tmp_array}' ";
}else if($_GET['mb_id']) {
    $where = "mb_id = '{$tmp_array1}' ";
}
    $sql = "select * from your_table where $where ORDER BY ct_id DESC ";
    $result = sql_query($sql);

    for($i=0; $row=sql_fetch_array($result); $i++){

    $od_id = $row['od_id'];
    $od_name = $row['it_name'];
    $od_qty = $row['ct_qty'];
    $od_price = $row['ct_price'] * $row['ct_qty'] ;
    $article__a[] = array( 
        $od_id,
        $od_name,
        $od_qty,
        $od_price
    );

    $article_t++;

    }


$data = array_merge(array($headers), $article__a);

$excel = new PHPExcel();

$excel->setActiveSheetIndex(0)->getStyle( "A1:${last_char}1" )->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($header_bgcolor);
$excel->setActiveSheetIndex(0)->getStyle( "A:$last_char" )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(true);
foreach($widths as $i => $w)
	$excel->setActiveSheetIndex(0)->getColumnDimension( column_char($i) )->setWidth($w);

$excel->getActiveSheet()->fromArray($data,NULL,'A1');

$bo_table = ($_GET['od_id']) ? $_GET['od_id'] : $_GET['mb_id'];

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"{$bo_table}.xls\"");
header("Cache-Control: max-age=0");

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
$writer->save('php://output');

function column_char($i) {
	return chr( 65 + $i );
}

