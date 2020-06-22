<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once(G5_LIB_PATH.'/youtube.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<div class="wrap">
    
        <div class="cont cont1">
            <div class="view cd">
                <div class="video left">
                    <iframe src="" frameborder="0"></iframe>
                </div>
                <form name="fboardlist"  id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
                    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
                    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                    <input type="hidden" name="stx" value="<?php echo $stx ?>">
                    <input type="hidden" name="spt" value="<?php echo $spt ?>">
                    <input type="hidden" name="sst" value="<?php echo $sst ?>">
                    <input type="hidden" name="sod" value="<?php echo $sod ?>">
                    <input type="hidden" name="page" value="<?php echo $page ?>">
                    <input type="hidden" name="sw" value="">
                <div class="text right">
                    <h2>Title</h2>
                    <p><span>가수이름 </span><?php echo $list[$i]['wr_1']?></p>
                    <p><span>노래이름 </span><?php echo $list[$i]['wr_2']?></p>
                    <p><span>제작사   </span><?php echo $list[$i]['wr_3']?></p>
                    <p><span>영상주소 </span><?php echo $list[$i]['wr_4']?></p>
                </div>
            </div>
            <ul class="video_list cd" id="gall_ul">
            
            <?php for ($i=0; $i<count($list); $i++) {

                $classes = array();

                $classes[] = 'gall_li';
                $classes[] = 'col-gn-'.$bo_gallery_cols;

                if( $i && ($i % $bo_gallery_cols == 0) ){
                    $classes[] = 'box_clear';
                }

                if( $wr_id && $wr_id == $list[$i]['wr_id'] ){
                    $classes[] = 'gall_now';
                }
                ?>

                 <li>
                     <div class="img_box">
                     <?php
                    if ($list[$i]['is_notice']) { // 공지사항  ?>
                        <span class="is_notice">공지</span>
                    <?php } else {
                        $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, true);

                        if($thumb['src']) {
                            $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$board['bo_gallery_width'].'" height="'.$board['bo_gallery_height'].'">';
                        } else {
                            $img_content = '<span class="no_image">no image</span>';
                        }

                        //youtube thumbnail code
                        $youtube_thumbnail = get_youtube_thumbnail(get_youtube_id($list[$i]['wr_link1']));
                        if($youtube_thumbnail) {
                            $img_content = '<img src="'.$youtube_thumbnail.'" width="'.$board['bo_gallery_width'].'" height="'.$board['bo_gallery_height'].'">';
                        }
                        //view code
                        echo $img_content;
                    }
                        ?>
                     </div>
                     <h3 class="data_title"><?php echo $list[$i]['wr_subject']?></h3>
                     <p>content</p>
                     <h6 class="data">
                        <?php echo $img_content?>
                     </h6>
                 </li>
                <?php } ?>
             <!-- 반복 -->
             <?php if (count($list) == 0) { echo "<li class=\"empty_list\" datano='no'>게시물이 없습니다.</li>"; } ?>
             </ul>
             <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn"><i class="fa fa-pencil" aria-hidden="true"></i>  글쓰기</a></li><?php } ?>

        <!-- 페이지 -->
             <nav class="pg_wrap">
                <span class="pg">
                    <?php echo $write_pages;?>
                </span>
            </nav>	
        <!-- 페이지 -->

            </form> <!--form end-->
             <div class="more point_bg">
                VIEW MORE
             </div>
        </div>
        
    </div>


<!-- 페이지 클릭시 더보기-->
<span id="page_n" style="display:none;">2</span>
<script type="text/javascript">

$( document ).ready(function(){

$( ".more point_bg" ).click(function(){
    $( this ).html( '<i class="fa fa-spinner fa-spin"></i>' );
    


    var disp_li_length = $( "#gallery_json > li" ).length;

    var page_n = $('#page_n').html();
    $.get( "<?=G5_URL?>/bbs/board.php?bo_table=<?=$bo_table?>&ajax_ck=1&sca=<?php echo urlencode($sca) ?>&page="+page_n, function( data ) {
        var append_data = $( data ).find('#gall_ul').html();
        var cking = $( data ).find('.empty_list').attr("datano");
      
                

        if(cking != "no"){
            $('#page_txt').html('');
            $('#gall_ul').append(append_data);
            $('#page_n').html(parseInt(page_n)+1);
            
            $( ".more point_bg" ).html( 'VIEW MORE' );

        } else {
            alert( '게시물이 존재하지 않습니다.' );
            $( ".more point_bg" ).html( 'VIEW MORE' );
        }
    });
});

});
// 페이지 클릭시 더보기-->
</script>






<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == 'copy')
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
