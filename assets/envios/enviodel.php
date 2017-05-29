<?php
global $wpdb;
$meta_id = $_GET['meta_id'];
$pegaDadosEnvio = $wpdb->get_var("SELECT  meta_value FROM $wpdb->postmeta WHERE meta_id = '$meta_id'");
$dadosUnser = unserialize($pegaDadosEnvio);

$idMetodo = $dadosUnser['idMetodo'];
$tipoMetodo = $dadosUnser['tipoMetodo'];

if($tipoMetodo == 'AutoResponder'){
$idFormulario = $dadosUnser['idFormulario'];	
$delta = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_id = '$idFormulario'");
	}
$delta = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_id = '$meta_id'");
$delta = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_id = '$idMetodo'");
 
?>

<h3>Excluindo Método de Envio </strong></h3>
<div class="alert alert-success"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Método de Envio Excluído com Sucesso. Redirecionando, Aguarde...</div>

<meta http-equiv="refresh" content="3; url=admin.php?page=pagmember&pg=envios">