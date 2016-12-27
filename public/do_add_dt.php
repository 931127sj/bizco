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


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function uploadImage($param, $dir) {

	$uid = generateRandomString();

	if (isset($_FILES[$param]) && !$_FILES[$param]['error']) {
		//echo "이미지 업로드시작";
		$imageKind = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png');
		if (in_array($_FILES[$param]['type'], $imageKind)) {
			$ex = extraction($_FILES[$param]['name']);
			if (move_uploaded_file ($_FILES[$param]['tmp_name'], "../data/$dir/$uid.$ex")) {
				copy("../data/$dir/$uid.$ex", "../data/$dir/real_$uid.$ex");
			} //if , move_uploaded_file
		} else {
			msg('JPEG 또는 PNG 이미지만 업로드 가능합니다.');
			back();
			exit();
		}//if , inarray
	} //if , isset
	if ($_FILES[$param]['error'] > 0) {
		// 실패 내용 출력
		switch ($_FILES[$param]['error']) {
			case 1:
				$msg = '업로드 최대용량을 초과하였습니다.';
				break;
			case 2:
				$msg ='업로드 최대용량을 초과하였습니다.';
				break;
			case 3:
				$msg ='파일 일부만 업로드 되었습니다.';
				break;
			case 4:
				$msg ='업로드된 파일이 없습니다.';
				break;
			case 6:
				$msg ='사용가능한 임시폴더가 없습니다.';
				break;
			case 7:
				$msg ='디스크에 저장할수 없습니다.';
				break;
			case 8:
				$msg ='파일 업로드가 중지되었습니다.';
				break;
			default:
				$msg ='시스템 오류가 발생하였습니다.';
				break;
		} // switch

		msg($msg);
		back();
		exit();
	} // if

	if (file_exists ($_FILES[$param]['tmp_name']) && is_file($_FILES[$param]['tmp_name']) ) {
		unlink ($_FILES[$param]['tmp_name']);
	}
	$file = "../data/$dir/$uid.$ex";
	$size = getimagesize($file);
	$thumb = new Image($file);
	//가로가 더 긴 경우
	/*
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
	*/

	return $uid.".".$ex;
}

$problem_cause = $_POST['problem_cause'];
$youtube_link = $_POST['youtube_link'];
$link = $_POST['link'];
$idea = $_POST['idea'];
$test = $_POST['test'];
$user_idx = $_SESSION['idx'];
$user_name = $_SESSION['name'];
// 이미지 업로드 처리 구현 필요


$img1 = uploadImage('profile','dt_thumb');
$img2 = uploadImage('img2','dt_thumb');

$result = mysql_query("INSERT INTO  `design_thinking`(
						`user_idx`,
						`problem_cause` ,
						`image` ,
						`image2` ,
						`youtube_link` ,
						`datetime`,
            `user_name`
						)
						VALUES (
						'$user_idx', '$problem_cause',  '$img1', '$img2', '$youtube_link', now(), '$user_name'
						);
						");
$dt_idx = mysql_insert_id();

for($i = 0; $i < count($link); $i++){

	if($link[$i] == ''){
		continue;
	}

	$result = mysql_query("INSERT INTO  `design_thinking_article`(
						`dt_idx`,
						`content` ,
						`type`
						)
						VALUES (
						'$dt_idx', '".$link[$i]."',  'link'
						);
						");
}

for($i = 0; $i < count($idea); $i++){

	if($idea[$i] == ''){
		continue;
	}

	$result = mysql_query("INSERT INTO  `design_thinking_article`(
						`dt_idx`,
						`content` ,
						`type`
						)
						VALUES (
						'$dt_idx', '".$idea[$i]."',  'idea'
						);
						");
}

for($i = 0; $i < count($test); $i++){

	if($test[$i] == ''){
		continue;
	}

	$result = mysql_query("INSERT INTO  `design_thinking_article`(
						`dt_idx`,
						`content` ,
						`type`
						)
						VALUES (
						'$dt_idx', '".$test[$i]."',  'test'
						);
						");
}
req_redirect_js("dt_list");
