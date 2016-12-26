<?
session_start();
require '_common.php';

session_destroy();
req_redirect("member","login");	

