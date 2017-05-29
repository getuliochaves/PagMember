<?php
global $wpdb;
include_once(base64_decode('aW5jX3Nwb3dlci5waHA='));
if($pg3 == 'ativado'){
	echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
  '.$okK.'</div>';
}
?>

<?php
if(($_GET['pg'] == 'produtos' && $_GET['pg2'] == '') or ($_GET['pg'] == '' && $_GET['pg2'] == '')){
 include_once('inc_start.php');
}
?>



<div class="panel panel-primary Geral" style="width:93%;">
	<div class="panel-heading">
    	<h3><strong><?php echo $pmPro.' '.$versaoPlugin; ?></strong> <a href="https://www.youtube.com/watch?v=kxQTshCsoLQ" target="_blank" class="btn btn btn-default"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial de Novidades</a></h3>
    </div>
	<div class="panel-body corpo">
		<ul class="nav nav-tabs" style="margin-bottom:20px !important;">
				<?php
					include_once(base64_decode('aW5jX21lbnVzLnBocA=='));
				?>
		</ul>
		<div class="panel panel-default">
			<div class="panel-body">

            <?php
						/*
			if($_GET['page'] == 'pagmember' && $pg == ['']){

				//Pega Versão do Banco
				$pegaVersaoBanco = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'ultimaVersaoPagMemberPro'");

				if(count($pegaVersaoBanco) == 0 or $pegaVersaoBanco == NULL){
				$versaoPlugin2 = '3.8';
				$gravaVersaoPlugin = $wpdb->insert($wpdb->options, array('option_name' => 'ultimaVersaoPagMemberPro','option_value' => $versaoPlugin2));
				}

				//Inicio Valida versao
				if(count($pegaVersaoBanco) > 0 && $pegaVersaoBanco != $versaoPlugin){
				$atualizaVersaoPlugin = $wpdb->query("UPDATE $wpdb->options SET option_value = '$versaoPlugin' WHERE option_name = 'ultimaVersaoPagMemberPro'");



				include_once('inc_filescli.php');
				removeTreeRec($diretorioRemove);
				copyr($diretorioInicial,$diretorioDestino);

				removeTreeRecH($diretorioRemoveH);
				copyrH($diretorioInicialH,$diretorioDestinoH);

				//Copia Mailjet para Destino PagSeguro
				if(!file_exists($destinoMailjet)){
				$zip = new ZipArchive;
				$zip->open($inicioMailjet);
				if($zip->extractTo($diretorioDestino) == TRUE){

				}
				$zip->close();
				}

				//Copia Mailjet para Destino Hotmart

				if(!file_exists($destinoMailjetH)){
				$zip = new ZipArchive;
				$zip->open($inicioMailjetH);
				if($zip->extractTo($diretorioDestinoH) == TRUE){

				}
				$zip->close();
				}

			};//Fim Valida Versao

			//Valida Tokens
			$pegaDadosToken = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'dadosToken'");
			if($versaoPlugin < 5 && count($pegaDadosToken) == 0){
			$tokenPagSeguro = 'tokenPagMember#'.'PagSeguro';
			$tokenHotmart = 'tokenPagMember#'.'Hotmart';
			$pagSeguro = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = '$tokenPagSeguro'");
			$hotmart = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = '$tokenHotmart'");

			$nomeRedPagSeguro = 'redPagMember#'.'PagSeguro';
			$nomeRedHotmart = 'redPagMember#'.'Hotmart';
			$redPagSeguro = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = '$nomeRedPagSeguro'");
			$redHotmart = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = '$nomeRedHotmart'");

			$token['PagSeguro']['token'] = $pagSeguro;
			$token['PagSeguro']['email'] = '';
			$token['PagSeguro']['pgred'] = $redPagSeguro;

			$token['Hotmart']['token'] = $hotmart;
			$token['Hotmart']['email'] = '';
			$token['Hotmart']['pgred'] = $redHotmart;

			$dadosTokenGrava = serialize($token);
			$grava = $wpdb->insert($wpdb->options, array('option_name' => 'dadosToken','option_value' => $dadosTokenGrava));
			}
			//Fim 	//Valida Tokens
				}
				*/

				if($pg == ''){
					$pg = 'produtos';
					}

            switch($pg){
				case base64_decode('c3RhdHVz'):
				include_once(base64_decode('aW5jX3N0YXR1c3BsdWdpbi5waHA='));
				break;

				case ($pg):
				include_once('inc_'.$pg.'.php');
				break;
				}
			?>



			</div>
		</div>


	</div> <!-- Fim Div Corpo-->
</div> <!-- Fim Div Geral-->
