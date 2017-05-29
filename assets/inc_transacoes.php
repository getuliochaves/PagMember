<?php
global $wpdb;
if($pg == 'transacoes'){
$idMetaGravaTR = 999999997;
$pegaTransacao = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id = $idMetaGravaTR ORDER BY meta_id DESC");
$contaTransacoes = count($pegaTransacao);
$pegaDadosToken = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'dadosToken'");
$listaToken = unserialize($pegaDadosToken);

$caminhoLoader = plugins_url().'/PagMember/assets/imagens/ajax-loader.gif';

//var_dump($pegaTransacao);

?>
<h2>Transações Recebidas <a href="https://www.youtube.com/watch?v=pAj61Ry9JIw" target="_blank" class="btn btn btn-primary"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial</a></h2>

<div class="recebedados"></div>

<style>
.conteudoStatus{
	width:700px;
	height:100px;
	overflow:auto;
	}
</style>
<?php
if($contaTransacoes <= 0){
echo '<div class="alert alert-success">Seu site ainda não recebeu nenhuma transação dos meios de pagamento.</div>';
	}else{
//INICIO DIFENTE DE LIMPA
	if($pg3 != 'limpa'){
	?>

<table class="table table-bordered">
	<thead>

		<tr class="success">
			<th width="10%">Data</th>
			<th width="15%">Nome Cliente</th>
			<th width="16%">Email Cliente</th>
			<th width="17%">IDtransacao</th>
			<th width="5%">Status</th>
			<th width="18%">Nome Produto</th>
			<th width="5%">Valor</th>
			<th width="5%">Pagamento</th>
			<th width="2%"></th>
		</tr>
	</thead>

	<tbody>

		<?php
			//Lista todas as transacoes
			$idUnico = 0;
			foreach ($pegaTransacao as $transacoes) {
				//Pega dados da transacao
				$pegaTr = $transacoes->meta_value;
				$pegaTrID = $transacoes->meta_id;
				$pegaTrMeta = $transacoes->meta_key;
				$pegaTr = unserialize($pegaTr);

				//var_dump($pegaTr);
				?>
				<tr style="font-size:10px;">



<?php

//var_dump($pegaTr);
if(array_key_exists('URLRedireciona',$pegaTr)){
	unset($pegaTr['URLRedireciona']);
};

$exclusoes = array('senhaUsu','idMetodoEnvio','URLRedireciona');
$btEnvia = '';
foreach ($pegaTr as $chaveTr => $valorTr) {
	if($chaveTr == 'senhaUsu'){
		$senhaUsu = base64_decode($valorTr);
		echo '<input type="hidden" class="senhaUsu'.$idUnico.'" value="'.$senhaUsu.'"/>';

	}

	if($chaveTr == 'idMetodoEnvio'){
		$idMetodoEnvio = base64_decode($valorTr);
		echo '<input type="hidden" class="idMetodoEnvio'.$idUnico.'" value="'.$idMetodoEnvio.'"/>';

	}

//se map existir no array exclusoes
	if(!in_array($chaveTr, $exclusoes)){
?>
<td>
	<input type="hidden" class="<?php echo $chaveTr.$idUnico; ?>" value="<?php echo base64_decode($valorTr); ?>"/>
<?php
	echo base64_decode($valorTr);
	if(base64_decode($valorTr) == 'Aprovado' or base64_decode($valorTr) == 'Aguardando pagamento'){
		$btEnvia = 'sim';
	}

	if($chaveTr == 'NomeProduto'){
		$pegaOferta = explode('#',base64_decode($valorTr));
		$nomeOff = $pegaOferta[1];
		echo '<input type="hidden" class="nomeOff'.$idUnico.'" value="'.$nomeOff.'"/>';
	}

	if($chaveTr == 'TipoPagamento'){
		$tipoToken = base64_decode($valorTr);
		$token = $listaToken[$tipoToken]['token'];
		echo '<input type="hidden" class="token'.$idUnico.'" value="'.$token.'"/>';

		$tipoProd = strtolower($tipoToken);
		$linkNot = 'notificacao'.$tipoProd;

		$linkNotifica = get_site_url().'/'.$linkNot.'/';

		echo '<input type="hidden" class="linkNotifica'.$idUnico.'" value="'.$linkNotifica.'"/>';
	}




	if($chaveTr == 'StatusCompra'){
		$statusCompra = base64_decode($valorTr);
		switch ($statusCompra) {
			case 'Aprovado':
				$statusTrasacao = 3;
				break;
				case 'Aguardando pagamento':
					$statusTrasacao = 1;
					break;
					case 'Cancelada':
						$statusTrasacao = 6;
						break;

			default:
				$statusTrasacao = 1;
				break;
		}


		echo '<input type="hidden" class="statusTrasacao'.$idUnico.'" value="'.$statusTrasacao.'"/>';
	}



?>
</td>
<?php
//Fim se nao exisitr no array exclusoes
};
?>

<?php
};//Lista todas as transacoes
?>
<td>
	<a class="btn btn-danger btn-sm" href="admin.php?page=pagmember&pg=transacoes&pg3=limpa&trMeta=<?php echo $pegaTrMeta; ?>&trID=<?php echo $pegaTrID; ?>">Excluir Transação</a>
	<?php
	if($btEnvia == 'sim'){
		echo '<button style="width:100%;" idUnico="'.$idUnico.'"  class="btn btn-success btn-sm reenviaAcesso" value="">Reenviar Acesso</button>';
	}
	 ?>
</td>
<?php
//var_dump($dTr);
 ?>
			</tr>
		<?php
		$idUnico ++;
			};//Pega dados da transacao
		?>

	</tbody>
</table>

<div class="alert alert-success">Clique para Limpar Todas as Transações <a href="admin.php?page=pagmember&pg=transacoes&pg3=limpa" class="btn btn-success">Limpar Transações</a></div>

<?php
		};//FIM nao Limp LIMPA
	};//Fim ELSE
};//Fim TRANSACOES

if($pg3 == 'limpa'){

if($_GET['trID'] == ''){
	echo '<div class="alert alert-success">Limpando as transações, aguarde...</div>';
	$deleta = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id = '$idMetaGravaTR'");
}else{
	$trMeta = $_GET['trMeta'];
	$trID = $_GET['trID'];
	echo '<div class="alert alert-success">Limpando a transações <strong>'.$trMeta.'</strong>, aguarde...</div>';
	$deleta = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id = '$idMetaGravaTR' AND meta_id = '$trID'");
}
	echo '<meta http-equiv="refresh" content="2; url=admin.php?page=pagmember&pg=transacoes">';
}

?>
<script>
$a = jQuery.noConflict();
$a(document).ready(function(){


	$a('.reenviaAcesso').click(function(){

		var idUnico = $a(this).attr('idUnico');
		var nomeCli = $a('.NomeCliente'+idUnico).val();
		var emailCli = $a('.EmailCliente'+idUnico).val();
		var statusTrasacao = $a('.statusTrasacao'+idUnico).val();
		var idTransacao = $a('.IdTransacao'+idUnico).val();
		var nomeProd = $a('.NomeProduto'+idUnico).val();
		var tipoProd = $a('.TipoPagamento'+idUnico).val();
		var valorProd = $a('.ValorProduto'+idUnico).val();
		var nomeOff = $a('.nomeOff'+idUnico).val();

		var token = $a('.token'+idUnico).val();
		var linkNotifica = $a('.linkNotifica'+idUnico).val();
		var linkTeste = linkNotifica + 'index.php';
		var testeLocal = 'testeLocal';
		var notificationType = 'transaction';
		var reenvioAcesso = 'sim';
		var senhaUsu = $a('.senhaUsu'+idUnico).val();
		var idMetodoEnvio = $a('.idMetodoEnvio'+idUnico).val();

		$a(".recebedados").html("<p align='center'><img src='<?php echo $caminhoLoader; ?>' alt='Enviando' /><br/>Aguarde, Executando Dados</p>");

		var dadosGrava = {senhaUsu: senhaUsu, idMetodoEnvio: idMetodoEnvio, reenvioAcesso: reenvioAcesso, nomeOff : nomeOff, notificationType : notificationType, testeLocal : testeLocal, nomeCli : nomeCli, emailCli : emailCli, statusTrasacao : statusTrasacao,	idTransacao : idTransacao, token : token, tipoProd : tipoProd, nomeProd : nomeProd, valorProd : valorProd};

		$a.ajax({
				url: linkTeste,
				type: "POST",
				data: dadosGrava,
				success: function(data){
						$a('.recebedados').html(data);
				}
		});	//Fim do Ajax

	});
});

</script>
