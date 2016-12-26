<?php
require '_common.php';
if($_SESSION['u_id'] != NULL && $_SESSION['login'] == true) {
		page_redirect("./index.php");
}
# Common components
$headerFiles = array(
	// '/assets/css/_normalize.css',
	'/assets/semantic/dist/semantic.min.css',
	CSS.'load.css',
	'<!--[if lt IE 9]><script src="/assets/js/ie9.min.js"></script><![endif]-->',
	'<!--[if lt IE 9]><script src="/node_modules/html5shiv/dist/html5shiv.min.js"></script><![endif]-->',
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

$view->load->page('common/_header');
$view->load->page('pages/tpl_join');
$view->load->page('common/_footer');