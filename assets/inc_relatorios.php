<?php
global $wpdb;
$idMetaGravaPM = 999999999;
$idMetaGravaUsuario = 999999998;
if($pg == 'relatorios'){
	$relatorioPagMember = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = '$idMetaGravaPM'");
		$relatorioPagMember = unserialize($relatorioPagMember);

		$relatorioPagMember3 = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = '$idMetaGravaUsuario'");
			$relatorioPagMember3 = unserialize($relatorioPagMember3);

?>
<h2>Relatório Geral <a href="https://www.youtube.com/watch?v=84a1DyUSnsU" target="_blank" class="btn btn btn-primary"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial</a></h2>
<h4>Dados do Relatório, toda vez que o Site Recebe um POST, ele é resetado</h4>
<?php
if($pg3 != 'limpa'){
?>
<table class="table table-bordered">
	<thead>
		<tr class="success">
			<th width="30%">Item Teste</th>
			<th width="60%">Resultado</th>
		</tr>
	</thead>

	<tbody>

		<tr>
			<td colspan="2"><strong style="text-align: center;"><h4>Dados do PagMember</h4></strong></td>
		</tr>

		<?php

		if(count($relatorioPagMember)>1){
			foreach($relatorioPagMember as $campo => $resultado2){
		?>
		<tr>
			<td><strong><?php echo $campo; ?></strong></td>
			<td><?php echo $resultado2; ?> </td>
		</tr>
		<?php };
						};
		?>

		<tr>
			<td colspan="2"><strong style="text-align: center;"><h4>Dados do Usuario Criado</h4></strong></td>
		</tr>

		<?php
		if(count($relatorioPagMember3)>1){
			foreach($relatorioPagMember3 as $campo3 => $resultado3){
		?>
		<tr>
			<td><strong><?php echo $campo3; ?></strong></td>
			<td><?php
								if($campo3 == 'pacoteProd'){
									$pacoteProd = base64_decode($resultado3);
									$resultado3 = unserialize($pacoteProd);
									if(count($resultado3)>0){
										foreach($resultado3 as $k => $v){
											echo $v.', ';
										}
									}
								}else{
									echo $resultado3;
								}
			  			?>
			</td>
		</tr>
		<?php };
						};
		?>

	</tbody>
</table>

      <div class="alert alert-success">Clique para Limpar o Relatorio <a href="admin.php?page=pagmember&pg=relatorios&pg3=limpa" class="btn btn-success">Limpar Relatório</a></div>



<?php
};
if($pg3 == 'limpa'){
 echo '<div class="alert alert-success">Limpando o relatório. Aguarde...</div>';
	$deleta = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id = '$idMetaGravaPM'");
	$deleta = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id = '$idMetaGravaUsuario'");
	echo '<meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=relatorios">';
	}

};
 ?>
