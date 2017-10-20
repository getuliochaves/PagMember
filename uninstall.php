<?php
global $wpdb;
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
  die();
/*
delete_option('siteexterno');
delete_option('sucesspag');
delete_option('tokemHotmart');
delete_option('tokemPagSeguro');
delete_option('vd_pagmember');
*/

$deleta1 = $wpdb->query("DELETE FROM $wpdb->options WHERE option_name = 'vd_pagmember'");
$deleta2 = $wpdb->query("DELETE FROM $wpdb->options WHERE option_name = 'siteexterno'");
$deleta3 = $wpdb->query("DELETE FROM $wpdb->options WHERE option_name = 'sucesspag'");
$deleta4 = $wpdb->query("DELETE FROM $wpdb->options WHERE option_name = 'successpag'");

$listaProd = mysql_query("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'produtoPagMember'");
$contaProd = mysql_num_rows($listaProd);
if($contaProd > 0){
	while($linhaProd = mysql_fetch_array($listaProd)){
		$idProd = $linhaProd['post_id'];
		$deltaProd = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id = '$idProd'");
		}

}


$listaNot = mysql_query("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'notificacoes'");
$contaNotificacoes = mysql_num_rows($listaNot);
if($contaNotificacoes > 0){
	while($linhaNotificacao = mysql_fetch_array($listaNot)){
		$idNot = $linhaNotificacao['post_id'];
		$pastaNot = $linhaNotificacao['meta_value'];

		unlink(ABSPATH.$pastaNot.'/PHPMailer/class.phpmailer.php');
unlink(ABSPATH.$pastaNot.'/PHPMailer/class.pop3.php');
unlink(ABSPATH.$pastaNot.'/PHPMailer/class.smtp.php');
rmdir(ABSPATH.$pastaNot.'/PHPMailer');
unlink(ABSPATH.$pastaNot.'/index.php');
if(file_exists(ABSPATH.$pastaNot.'/tokemPagSeguro.php')){
	unlink(ABSPATH.$pastaNot.'/tokemPagSeguro.php');
}
if(file_exists(ABSPATH.$pastaNot.'/error_log')){
	unlink(ABSPATH.$pastaNot.'/error_log');
}

rmdir(ABSPATH.$pastaNot);

$deltaNot = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id = '$idNot'");
	}
};




?>
