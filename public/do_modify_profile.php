<?php
require '_common.php';
require '../librarys/image_resize/class.image.php';
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
		echo 'JPEG 또는 PNG 이미지만 업로드 가능합니다.';
		exit();
	}//if , inarray
} //if , isset
if ($_FILES['profile']['error'] > 0) {
	echo '<p>파일 업로드 실패 이유: <strong>';
	// 실패 내용 출력
	switch ($_FILES['profile']['error']) {
		case 1:
			echo '업로드 최대용량 초과';
			break;
		case 2:
			echo '업로드 최대용량 초과';
			break;
		case 3:
			echo '파일 일부만 업로드 됨';
			break;
		case 4:
			echo '업로드된 파일이 없음';
			break;
		case 6:
			echo '사용가능한 임시폴더가 없음';
			break;
		case 7:
			echo '디스크에 저장할수 없음';
			break;
		case 8:
			echo '파일 업로드가 중지됨';
			break;
		default:
			echo '시스템 오류가 발생';
			break;
	} // switch

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

echo "프로필 사진이 정상적으로 변경되었습니다.";