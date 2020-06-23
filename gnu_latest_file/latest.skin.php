<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$thumb_width = 297;
$thumb_height = 212;
// $thumb_width = 800;
$board_file_path = G5_DATA_PATH . '/file/' . $bo_table;
$board_file_url = G5_DATA_URL . '/file/' . $bo_table;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<!-- 파일 첨부 이미지로 출력 모든 이미지 변경 가능해야한다. -->
    <?php
    for ($i=0; $i<$list_count; $i++) {  
        $list[$i]['file'] = get_file($bo_table, $list[$i]['wr_id']);

		// 파일 썸네일 보여주는 변수다.
        $thumb1_src = $board_file_url . "/" . thumbnail($list[$i]['file'][0]['file'], $board_file_path, $board_file_path, $thumb_width,'', false,true);
        $thumb2_src = $board_file_url . "/" . thumbnail($list[$i]['file'][1]['file'], $board_file_path, $board_file_path, $thumb_width,'', false,true);

    ?>
<article class="conti1">
				<div>
					<h2 class="subTitle">VISION</h2>
					<!-- img에 첨부한 파일을 thumbnail시켜서 보여준다.  -->
					<div class="imgWrap">
						<img src="<?php echo $thumb1_src?>" alt="">	    
					</div>
					<!-- img에 첨부한 파일을 thumbnail시켜서 보여준다.  -->
					<div class="txtWrap">
						<img src="<?php echo $thumb2_src?>" alt="skylabs">
					</div>	
    <?php }  ?>
  
