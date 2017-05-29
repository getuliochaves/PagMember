<?php
global $wpdb;
$meta_id = $_GET['meta_id'];
$delta = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_id = '$meta_id'");

 
?>

<h3>Excluindo Produto </strong></h3>
<div class="alert alert-success"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Produto Excluido com Sucesso. Redirecionando, Aguarde...</div>

<meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=produtos">
