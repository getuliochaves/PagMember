<?php
global $wpdb;
global $wp_roles;

$caminhoLoader = plugins_url().'/PagMember/assets/imagens/ajax-loader.gif';


$prodMetaId = $_GET['meta_id'];
$listaPro = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$prodMetaId'");
$pegaProd = unserialize($listaPro);


$nomeProd = $pegaProd['nomeProd'];
$tipoProd = $pegaProd['tipoProd'];
$idProd = $pegaProd['idProd'];
$valorProd = $pegaProd['valorProd'];
$nomeOff = $pegaProd['nomeOff'];

$tipoProd = strtolower($tipoProd);
$linkNot = 'notificacao'.$tipoProd;


switch($tipoProd){
	case 'pagseguro':
	$tipoProd = 'PagSeguro';
	break;

	default:
	$tipoProd = ucwords($tipoProd);
	break;
}




$linkNotifica = get_bloginfo('url').'/'.$linkNot.'/';



$pegaDadosToken = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'dadosToken'");
$listaToken = unserialize($pegaDadosToken);

//var_dump($listaToken);

$dadosToken = $listaToken[$tipoProd];

//var_dump($dadosToken);

//var_dump($tipoProd);

$token = $dadosToken['token'];
$emailConta = $dadosToken['email'];

//var_dump($token);

$pegaDadosGeral = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'dadosGeralPagMember'");
$listaDadosGeral = unserialize($pegaDadosGeral);
$emailtestes = $listaDadosGeral['EmailTestes'];

?>
<h3>Modo de Teste do Produto <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> <?php echo $pegaProd['nomeProd']; ?></h3>
<br />

<form class="form-horizontal" role="form" method="post" action="javascript:func()" id="formularioProd" name="formularioProd">

	<div class="form-group">
	    <label for="inputText" class="col-sm-2 control-label">Nome Cliente Teste:</label>

	    <div class="col-sm-6">
				<input type="text" class="form-control nomeCli" required placeholder="Ex: Getulio Chaves" value="" name="nomeCli">
	    </div>
	  </div>

		<div class="form-group">
			<label for="inputText" class="col-sm-2 control-label">Email para Teste:</label>
			<div class="col-sm-6">
					<input type="text" class="form-control emailCli" required placeholder="Ex: seu-email@gmail.com" value="<?php echo $emailtestes;?>" name="emailCli">
			</div>
		</div>

		<div class="form-group">
		    <label for="inputText" class="col-sm-2 control-label">Status de Teste:</label>

		    <div class="col-sm-6">
		      <select class="form-control statusTrasacao" name="statusTrasacao">
		      	<option selected="selected" value="3">Aprovado</option>
						<option value="1">Aguardando Pagamento</option>
						<option value="6">Cancelada</option>
		       </select>
		    </div>
		  </div>

			<div class="form-group">
			    <label for="inputText" class="col-sm-2 control-label">ID Transacao:</label>

			    <div class="col-sm-6">
			      <input type="text" class="form-control idTransacao" required placeholder="Ex: 22446688" value="22446688" name="idTransacao">
			    </div>
			  </div>

				<input type="hidden" value="<?php echo $nomeProd; ?>" class="nomeProd" name="nomeProd"/>
				<input type="hidden" value="<?php echo $idProd; ?>" class="idProd" name="idProd"/>
				<input type="hidden" value="<?php echo $token; ?>" class="token" name="token"/>
				<input type="hidden" value="<?php echo $tipoProd; ?>" class="tipoProd" name="tipoProd"/>
				<input type="hidden" value="<?php echo $linkNotifica; ?>" class="linkNotifica" name="linkNotifica"/>
				<input type="hidden" value="<?php echo $valorProd; ?>" class="valorProd" name="valorProd"/>
				<input type="hidden" value="<?php echo $nomeOff; ?>" class="nomeOff" name="nomeOff"/>


				<input type="hidden" value="testeLocal" class="testeLocal" name="testeLocal"/>


				<div class="form-group">
				    <div class="col-sm-offset-6 col-sm-6">
				      <button type="submit" class="btn btn-primary btn-lg testarProd">Testar Produto</button>
				    </div>
				  </div>

</form>

<div class="recebedados alert alert-success" style="padding:20px; display:none;"></div>

<script>
$a = jQuery.noConflict();
$a(document).ready(function(){


	$a('#formularioProd').submit(function(){

		$a('.recebedados').show();
		$a(".recebedados").html("<p align='center'><img src='<?php echo $caminhoLoader; ?>' alt='Enviando' /><br/>Aguarde, Executando Dados</p>");
		var nomeCli = $a('.nomeCli').val();
		var emailCli = $a('.emailCli').val();
		var statusTrasacao = $a('.statusTrasacao').val();
		var idTransacao = $a('.idTransacao').val();
		var valorProd = $a('.valorProd').val();

		var token = $a('.token').val();
		var tipoProd = $a('.tipoProd').val();
		var nomeProd = $a('.nomeProd').val();
		var idProd = $a('.idProd').val();
		var nomeOff = $a('.nomeOff').val();


		var linkNotifica = $a('.linkNotifica').val();
		var linkTeste = linkNotifica + 'index.php';
		var testeLocal = 'testeLocal';
		var notificationType = 'transaction';


		var dadosGrava = {nomeOff : nomeOff, notificationType : notificationType, testeLocal : testeLocal, nomeCli : nomeCli, emailCli : emailCli, statusTrasacao : statusTrasacao,	idTransacao : idTransacao, token : token, tipoProd : tipoProd, nomeProd : nomeProd, idProd : idProd, valorProd : valorProd};

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
