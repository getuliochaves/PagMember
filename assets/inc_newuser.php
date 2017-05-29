<?php
global $wpdb;
$newUserDados = $_POST;
$user_login = $_POST['user_login'];
$pegaUsuario = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_login = '$user_login'");
$contaUsuario = count($pegaUsuario);
if($contaUsuario == 0){
$user_id = wp_insert_user($newUserDados); 
$pacoteAcesso = $newUserDados['wp_capabilities'];
$grava88 = $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$pacoteAcesso' WHERE user_id = '$user_id' AND meta_key = 'wp_capabilities'");
 
if ( is_wp_error( $user_id ) ) {
echo 'Erro ao criar o usuario';
}
else {
echo 'Usuario Criado com sucesso';
 }
}
?>