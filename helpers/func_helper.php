<?php

/**
 * isset과 값이 참인지 확인해주는 단순한 함수 (PHP 7에서의 ?? 연산자 역할과 동일함)
 */
function is(&$var, $return=false) {
    if ($return)
        return (isset($var) && $var)?$var:false;
    else
        return (isset($var) && $var);
}

/**
 * 이 파일 경로가 js파일인지 확인
 */
function isJsFile($filename) {
    if (preg_match('/\.js$/u' , $filename))
        return $filename;
    return false;
}

/**
 * 이 파일 경로가 css파일인지 확인
 */
function isCssFile($filename) {
    if (preg_match('/\.css$/u' , $filename))
        return $filename;
    return false;
}

/**
 * 링크 태그로 감싸는 함수
 */
function tagLink($val) {
    return '<link rel="stylesheet" type="text/css" href="'.$val.'">';
}

/**
 * 스크립트 태그로 감싸는 함수
 */
function tagScript($val) {
    return '<script type="text/javascript" src="'.$val.'"></script>';
}

/**
 * 헤더, 푸터에 들어가는 에셋파일들 출력
 */
function echoAssets($arr) {
    if (is($arr)) foreach ($arr as $key => $value) {
        if (isJsFile($value)) echo tagScript($value);
        elseif (isCssFile($value)) echo tagLink($value);
        else echo $value;
    }
}

/**
 * SNS처럼 보기 쉬운 날짜 형식으로 변환해주는 함수
 */
function dateToSNSString($datetime) {
    if($_SESSION['lang'] == 'en'){
      $lang_now = "Now";
      $lang_minute = "minute ago";
      $lang_hour = "hour ago";
      $lang_day = "day ago";
      $lang_week = "week ago";
      $lang_month = "month ago";
      $lang_year = "year ago";
    }else{
      $lang_now = "방금";
      $lang_minute = "분 전";
      $lang_hour = "시간 전";
      $lang_day = "일 전";
      $lang_week = "주 전";
      $lang_month = "개월 전";
      $lang_year = "년 전";
    }

    $sec = time() - strtotime($datetime);
    if($sec < 60) return $lang_now;
        $min = $sec / 60;
    if($min < 60) return intval($min) . $lang_minute;
        $hour = $min / 60;
    if($hour < 24) return intval($hour) . $lang_hour;
        $day = $hour / 24;
    if($day < 7) return intval($day) . $lang_day;
        $week = $day / 7;
    if($time < 5) return intval($week) . $lang_week;
        $month = $day / 30;
    if($month < 24) return intval($month) . $lang_month;
        $year = $day / 365;
    return intval($year) . $lang_year;
}


function sendMail($to, $emails, $subject, $content) {
    $bcc = implode(', ', $emails);
    return mail($to, $subject, $content, "Form:" . $to . "\r\nBcc:" . $bcc);
}

/**
 * SmartEditor가 아닌 순수하게 입력 받은 경우의 String을 그나마 안전하게 변환합니다.
 */
function xssHtmlProtect($string) {
    return nl2br(htmlspecialchars(trim($string)));
}
