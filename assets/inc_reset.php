<?php
global $wpdb;
if($pg == 'reset'){


?>
<h2>Resetar Plugin <a href="https://www.youtube.com/watch?v=8ZBczbKw-uA" target="_blank" class="btn btn btn-primary"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial</a></h2>

<?php
if($pg3 == 'ok'){
?>
<div class="alert alert-success">Chave do pagmember removida com sucesso.</div>
<?php
};
?>

<?php
if($pg3 != 'limpa'){
?>



      <div class="alert alert-danger">ATENÇÃO: Ao resetar o PagMember, Você terá que colocar a chave novamente..</div>
      <a href="admin.php?page=pagmember&pg=reset&pg3=limpa" class="btn btn-success">Resetar Configurações</a>

<?php
};
	 if($pg3 == 'limpa'){

		echo '<div class="alert alert-success">Resetando Configurações, aguarde...</div>';
		 $deleta = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id = '9999999999'");
$deleta1 = $wpdb->query("DELETE FROM $wpdb->options WHERE option_name = 'vd_pagmember'");
$deleta2 = $wpdb->query("DELETE FROM $wpdb->options WHERE option_name = 'siteexterno'");
$deleta3 = $wpdb->query("DELETE FROM $wpdb->options WHERE option_name = 'sucesspag'");
$deleta4 = $wpdb->query("DELETE FROM $wpdb->options WHERE option_name = 'successpag'");
$deleta5 = $wpdb->query("DELETE FROM $wpdb->options WHERE option_name = 'ultimaVersaoPagMemberPro'");





/*var_dump($deleta);


$idProdutoPagmember = $wpdb->get_results("SELECT meta_id FROM $wpdb->postmeta WHERE meta_key LIKE '%ProdPagMember#%'");
//var_dump($idProdutoPagmember);

foreach($idProdutoPagmember as $mostraID => $iddoPost){
  foreach($iddoPost as $idFinal){
	  $deltaProd = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_id = '$idFinal'");
	  }
}
*/
		echo '<meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=reset&pg3=ok">';
		 }

	 ?>

  <?php
};
  ?>
