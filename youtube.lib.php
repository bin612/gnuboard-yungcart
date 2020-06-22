<?php
if (!defined('_GNUBOARD_')) exit;

// 유튜브 ID 가져오기
function get_youtube_id($contents)
{
    if(!$contents)
        return false;

    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $contents, $match);

    return $match[1];
}

// 유튜브 썸네일 링크
// http://webdir.tistory.com/472($thumb_str에 따른 썸네일 크기 및 설명)
function get_youtube_thumbnail($youtube_id, $thumb_str="0"){
    if(!$youtube_id)
        return false;

    return "https://img.youtube.com/vi/".$youtube_id."/".$thumb_str.".jpg";
}