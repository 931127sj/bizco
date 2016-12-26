<?php
require '_common.php';

if($_SESSION['login'] != true && $_SESSION['u_id'] == NULL) {
	// 로그인이 되어있지 않은 상태일때는 로그인 페이지로 리다이렉트 시킨다.
	req_redirect("auth.php");
}
check_login();

$usr = mysql_query("SELECT * FROM  `user` WHERE  `idx` =".$_SESSION["idx"]);
$usr_data = mysql_fetch_array($usr);

# Common components
$headerFiles = array(
	// '/assets/css/_normalize.css',
	'/assets/semantic/dist/semantic_custom.css',
    '<link href="/assets/smarteditor/css/smart_editor2.css" rel="stylesheet" type="text/css">',
    CSS.'load.css',
    '<!--[if lt IE 9]><script src="/assets/js/ie9.min.js"></script><![endif]-->',
    '<!--[if lt IE 9]><script src="/node_modules/html5shiv/dist/html5shiv.min.js"></script><![endif]-->',
    '<script type="text/javascript" src="/assets/smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>',
);
$footerFiles = array(
	'/assets/js/jquery-3.1.0.min.js',
	'/assets/semantic/dist/semantic.min.js',
	JS.'load.js',
	'/node_modules/marked/lib/marked.js',
);

$view->load->setHeaderFiles($headerFiles);
$view->load->setFooterFiles($footerFiles);

$view->load->title = 'Biz CoWork';

//
$menu = substr($_SERVER['PATH_INFO'], 1);

switch($menu) {
	case 'cur_step' : $_SESSION['current_menu'] = 'cur'; break;
	case 'bm_list' : $_SESSION['current_menu'] = 'bm'; break;
    case 'dt_list' : $_SESSION['current_menu'] = 'dt'; break;
	case 'group_user_list' : $_SESSION['current_menu'] = 'user'; break;
	case 'board_list' : $_SESSION['current_menu'] = $_GET['id']; break;
	case 'faq_view' : $_SESSION['current_menu'] = 'faq'; break;
	case 'question_list' : $_SESSION['current_menu'] = 'question'; break;
    case 'manage_join_user' : $_SESSION['current_menu'] = 'manage_join_user'; break;
	case 'manage_user_tools' : $_SESSION['current_menu'] = 'manage_user_tools'; break;
	case 'manage_step' : $_SESSION['current_menu'] = 'manage_step'; break;
	case 'team_list' : $_SESSION['current_menu'] = 'team'; break;
	case '' : $_SESSION['current_menu'] = 'cur'; break;
}

$view->load->page('common/_header');
$view->load->page('pages'.(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO']?$_SERVER['PATH_INFO']:'/cur_step'));
$view->load->page('common/_footer');