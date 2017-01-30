<?php
require '_common.php';
require '../librarys/image_resize/class.image.php';

if($_SESSION['lang'] == 'en'){
  $err_image = "Only JPEG or PNG images can be uploaded.";
  $err_msg1 = "The maximum upload capacity has been exceeded.";
  $err_msg2 = "The maximum upload capacity has been exceeded.";
  $err_msg3 = "Only part of the file has been uploaded.";
  $err_msg4 = "No uploaded file.";
  $err_msg5 = "";
  $err_msg6 = "No temporary folders available.";
  $err_msg7 = "Can not save to disk.";
  $err_msg8 = "File upload stopped.";
  $err_msg9 = "A system error has occurred.";
  $lang_msg = "Your profile photo has been changed successfully.";
}else{
  $err_image = "JPEG 또는 PNG 이미지만 업로드 가능합니다.";
  $err_msg1 = "업로드 최대용량을 초과하였습니다.";
  $err_msg2 = "업로드 최대용량을 초과하였습니다.";
  $err_msg3 = "파일 일부만 업로드 되었습니다.";
  $err_msg4 = "업로드된 파일이 없습니다.";
  $err_msg5 = "";
  $err_msg6 = "사용가능한 임시폴더가 없습니다.";
  $err_msg7 = "디스크에 저장할수 없습니다.";
  $err_msg8 = "파일 업로드가 중지되었습니다.";
  $err_msg9 = "시스템 오류가 발생하였습니다.";
  $lang_msg = "프로필 사진이 정상적으로 변경되었습니다.";
}

function extraction($extensions) {
    $return = false;
    if(strlen($extensions) === strcspn($extensions, "\\/:*?\"'<>|\n\t\r\x0\x0B"))  {
        if(false !== strpbrk($extensions, '.')) {
            $return = strtolower(trim(
                         substr($extensions, strcspn($extensions, '.')),
            '. '));
            if(false !== strpbrk($return, '.')) {
                return trim(strrchr($return, '.'), '. ');
            }
        }
    }
    return $return;
 }

$uid = $_SESSION['idx'];
if (isset($_FILES['profile']) && !$_FILES['profile']['error']) {
	$imageKind = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png');
	if (in_array($_FILES['profile']['type'], $imageKind)) {
		$ex = extraction($_FILES['profile']['name']);
		if (move_uploaded_file ($_FILES['profile']['tmp_name'], "../data/profile_thumb/$uid.$ex")) {
		} //if , move_uploaded_file
	} else {
		msg($err_image);
		exit();
	}//if , inarray
} //if , isset
if ($_FILES['profile']['error'] > 0) {
  switch ($_FILES[$param]['error']) {
    case 1:
      $msg = $err_msg1;
      break;
    case 2:
      $msg = $err_msg2;
      break;
    case 3:
      $msg = $err_msg3;
      break;
    case 4:
      $msg = $err_msg4;
      break;
    case 6:
      $msg = $err_msg6;
      break;
    case 7:
      $msg = $err_msg7;
      break;
    case 8:
      $msg = $err_msg8;
      break;
    default:
      $msg = $err_msg9;
      break;
  } // switch
  msg($msg);
  back();
  exit();
} // if

if (file_exists ($_FILES['profile']['tmp_name']) && is_file($_FILES['profile']['tmp_name']) ) {
	unlink ($_FILES['profile']['tmp_name']);
}
$file = "../data/profile_thumb/$uid.$ex";
$size = getimagesize($file);
$thumb = new Image($file);
//가로가 더 긴 경우
if($size[0] > $size[1]) {
	//resize
	$crop = (int)$size[0]/2;
	$thumb = new Image($file);
	$thumb->height(500);
	$thumb->save();

	//crop
	$thumb = new Image($file);
	$thumb->width(500);
	$thumb->height(500);
	$thumb->crop(0,0);
	$thumb->save();
} else {
//세로가 더 긴 경우
	$crop = (int)$size[0]/2;
	$thumb = new Image($file);
	$thumb->width(500);
	$thumb->save();

	//crop
	$thumb = new Image($file);
	$thumb->width(500);
	$thumb->height(500);
	$thumb->crop(0,0);
	$thumb->save();
}
$thumb->save();

//db url 삽입
$rq = mysql_query("UPDATE  `user` SET  `profile` = '$uid.$ex' WHERE  `idx` =$uid;");

msg($lang_msg);
