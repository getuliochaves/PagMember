<?php
global $wpdb;
$tipoEnvio = $_GET['tipoEnvio'];
$acao = $_GET['acao'];
$txtCad = 'Cadastrando Método de Envio';
$msgenvio = 'Método de Envio Gravado com Sucesso. Estamos redirecionamento para a lista de Métodos Cadastrados.';

if($tipoEnvio == 'MailJet'){

	$dadosTipoEnvio = $_POST;
	//var_dump($dadosTipoEnvio);
$nomeEnvio = $dadosTipoEnvio['nomeEnvio'];

$msgInicial = base64_encode(stripslashes($_POST['msgInicial']));
$atualizacaoAcesso = base64_encode(stripslashes($_POST['atualizacaoAcesso']));
$cancelamentoAcesso = base64_encode(stripslashes($_POST['cancelamentoAcesso']));
$msgFinal = base64_encode(stripslashes($_POST['msgFinal']));

$dadosTipoEnvio['msgInicial'] = $msgInicial;
$dadosTipoEnvio['atualizacaoAcesso'] = $atualizacaoAcesso;
$dadosTipoEnvio['cancelamentoAcesso'] = $cancelamentoAcesso;
$dadosTipoEnvio['msgFinal'] = $msgFinal;
$dadosTipoEnvio['codificado'] = 'sim';

$serMetodoEnvioPag = serialize($dadosTipoEnvio);

$nomeMetodoEnvio = 'dadosFormEnvioPag#'.$nomeEnvio;

if($acao == 'edit'){
	$txtCad = 'Atualizando Método de Envio';
	$meta_id = $_GET['meta_id'];

	$pegaDadosEnvio = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$meta_id'");
	$itemData = unserialize($pegaDadosEnvio);
	$nomeMetodo = $itemData['nomeMetodo'];


	$idMetodo = $itemData['idMetodo'];
	$grava = $wpdb->query("UPDATE $wpdb->postmeta SET meta_value = '$serMetodoEnvioPag' WHERE meta_id = '$idMetodo'");
	$msgenvio = 'Método de Atualizado com Sucesso. Estamos redirecionamento para a lista de Métodos Cadastrados.';
}

if($acao == 'gravar'){
	$grava = $wpdb->insert($wpdb->postmeta, array('meta_key' => $nomeMetodoEnvio,'meta_value' => $serMetodoEnvioPag));
	$idMetodo = $wpdb->get_var("SELECT meta_id FROM $wpdb->postmeta WHERE meta_key = '$nomeMetodoEnvio'");

	$geraMetodo1 = array(
	"tipoMetodo" => "MailJet",
	"idMetodo" => $idMetodo,
	"nomeMetodo" => $nomeEnvio,
	);

	$serGeraMetododo = serialize($geraMetodo1);
	$grava = $wpdb->insert($wpdb->postmeta, array('meta_key' => 'metodoEnvioPag','meta_value' => $serGeraMetododo));

	//var_dump($serGeraMetododo);
}

}

if($tipoEnvio == 'AutoResponder'){
$arrayFormularioO = $_POST['formSaida'];
$senhaUsu = $_POST['senhaUsu'];
$acessoUsu = $_POST['acessoUsu'];
$actionFormSaida = $_POST['actionFormSaida'];
$campoEmail = $_POST['campoEmail'];
$codigoFormulario = stripslashes($_POST['codigoFormulario']);

$exp = explode('&',$arrayFormularioO);
$chaves = array('actionForm', 'senhaUsu', 'acessoUsu','campoEmail');
$valores = array($actionFormSaida, $senhaUsu, $acessoUsu, $campoEmail);
foreach($exp as $dados => $mostraTudo){
	$ex2 = explode('=', $mostraTudo);
	array_push($chaves, $ex2[0]);
	array_push($valores, $ex2[1]);
	}
$metodoEnvioPag = array_combine($chaves, $valores);


$nomeFormulario = $metodoEnvioPag['nomeForm'];
$geraMetodo = serialize($geraMetodo1);

$serMetodoEnvioPag = serialize($metodoEnvioPag);


if($acao == 'edit'){
	$txtCad = 'Atualizando Método de Envio';
	$meta_id = $_GET['meta_id'];

	$pegaDadosEnvio = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$meta_id'");
	$itemData = unserialize($pegaDadosEnvio);
	$nomeMetodo = $itemData['nomeMetodo'];

	$idMetodo = $itemData['idMetodo'];
	$idFormulario = $itemData['idFormulario'];
	$grava = $wpdb->query("UPDATE $wpdb->postmeta SET meta_value = '$serMetodoEnvioPag' WHERE meta_id = '$idMetodo'");
	$grava = $wpdb->query("UPDATE $wpdb->postmeta SET meta_value = '$codigoFormulario' WHERE meta_id = '$idFormulario'");

	$msgenvio = 'Método de Atualizado com Sucesso. Estamos redirecionamento para a lista de Métodos Cadastrados.';

}

if($acao == 'gravar'){
	$nomeMetodoEnvio = 'dadosFormEnvioPag#'.$nomeFormulario;
	$grava = $wpdb->insert($wpdb->postmeta, array('meta_key' => $nomeMetodoEnvio,'meta_value' => $serMetodoEnvioPag));
	$idMetodo = $wpdb->get_var("SELECT meta_id FROM $wpdb->postmeta WHERE meta_key = '$nomeMetodoEnvio'");

	$codigoFormPagMember = 'codigoFormPagMember#'.$idMetodo;
	$grava = $wpdb->insert($wpdb->postmeta, array('meta_key' => $codigoFormPagMember,'meta_value' => $codigoFormulario));
	$idFormulario = $wpdb->get_var("SELECT  meta_id FROM $wpdb->postmeta WHERE meta_key = '$codigoFormPagMember'");

	$geraMetodo1 = array(
	"tipoMetodo" => "AutoResponder",
	"idMetodo" => $idMetodo,
	"nomeMetodo" => $nomeFormulario,
	"idFormulario" => $idFormulario
	);

	$serGeraMetododo = serialize($geraMetodo1);
	$grava = $wpdb->insert($wpdb->postmeta, array('meta_key' => 'metodoEnvioPag','meta_value' => $serGeraMetododo));
};
};

if($tipoEnvio == 'ServidorSMTP'){

$dadosTipoEnvio = $_POST;
$nomeEnvio = $dadosTipoEnvio['nomeEnvio'];

$msgInicial = base64_encode(stripslashes($_POST['msgInicial']));
$atualizacaoAcesso = base64_encode(stripslashes($_POST['atualizacaoAcesso']));
$cancelamentoAcesso = base64_encode(stripslashes($_POST['cancelamentoAcesso']));
$msgFinal = base64_encode(stripslashes($_POST['msgFinal']));

$dadosTipoEnvio['msgInicial'] = $msgInicial;
$dadosTipoEnvio['atualizacaoAcesso'] = $atualizacaoAcesso;
$dadosTipoEnvio['cancelamentoAcesso'] = $cancelamentoAcesso;
$dadosTipoEnvio['msgFinal'] = $msgFinal;
$dadosTipoEnvio['codificado'] = 'sim';

$serMetodoEnvioPag = serialize($dadosTipoEnvio);
$nomeMetodoEnvio = 'dadosFormEnvioPag#'.$nomeEnvio;

if($acao == 'edit'){
	$txtCad = 'Atualizando Método de Envio';
	$meta_id = $_GET['meta_id'];

	$pegaDadosEnvio = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$meta_id'");
	$itemData = unserialize($pegaDadosEnvio);
	$nomeMetodo = $itemData['nomeMetodo'];


	$idMetodo = $itemData['idMetodo'];
	$grava = $wpdb->query("UPDATE $wpdb->postmeta SET meta_value = '$serMetodoEnvioPag' WHERE meta_id = '$idMetodo'");
	$msgenvio = 'Método de Atualizado com Sucesso. Estamos redirecionamento para a lista de Métodos Cadastrados.';
}

if($acao == 'gravar'){
	$grava = $wpdb->insert($wpdb->postmeta, array('meta_key' => $nomeMetodoEnvio,'meta_value' => $serMetodoEnvioPag));
	$idMetodo = $wpdb->get_var("SELECT meta_id FROM $wpdb->postmeta WHERE meta_key = '$nomeMetodoEnvio'");

	$geraMetodo1 = array(
	"tipoMetodo" => "ServidorSMTP",
	"idMetodo" => $idMetodo,
	"nomeMetodo" => $nomeEnvio,
	);

	$serGeraMetododo = serialize($geraMetodo1);
	$grava = $wpdb->insert($wpdb->postmeta, array('meta_key' => 'metodoEnvioPag','meta_value' => $serGeraMetododo));
}

};


if($tipoEnvio == 'SemAutenticacao'){

$dadosTipoEnvio = $_POST;

$nomeEnvio = $dadosTipoEnvio['nomeEnvio'];

$msgInicial = base64_encode(stripslashes($_POST['msgInicial']));
$atualizacaoAcesso = base64_encode(stripslashes($_POST['atualizacaoAcesso']));
$cancelamentoAcesso = base64_encode(stripslashes($_POST['cancelamentoAcesso']));
$msgFinal = base64_encode(stripslashes($_POST['msgFinal']));

$dadosTipoEnvio['msgInicial'] = $msgInicial;
$dadosTipoEnvio['atualizacaoAcesso'] = $atualizacaoAcesso;
$dadosTipoEnvio['cancelamentoAcesso'] = $cancelamentoAcesso;
$dadosTipoEnvio['msgFinal'] = $msgFinal;
$dadosTipoEnvio['codificado'] = 'sim';

$serMetodoEnvioPag = serialize($dadosTipoEnvio);
$nomeMetodoEnvio = 'dadosFormEnvioPag#'.$nomeEnvio;
//var_dump($dadosTipoEnvio);

if($acao == 'edit'){
	$txtCad = 'Atualizando Método de Envio';
	$meta_id = $_GET['meta_id'];

	$pegaDadosEnvio = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$meta_id'");
	$itemData = unserialize($pegaDadosEnvio);
	$nomeMetodo = $itemData['nomeMetodo'];


	$idMetodo = $itemData['idMetodo'];
	$grava = $wpdb->query("UPDATE $wpdb->postmeta SET meta_value = '$serMetodoEnvioPag' WHERE meta_id = '$idMetodo'");
	$msgenvio = 'Método de Atualizado com Sucesso. Estamos redirecionamento para a lista de Métodos Cadastrados.';
}

if($acao == 'gravar'){
	$grava = $wpdb->insert($wpdb->postmeta, array('meta_key' => $nomeMetodoEnvio,'meta_value' => $serMetodoEnvioPag));
	$idMetodo = $wpdb->get_var("SELECT meta_id FROM $wpdb->postmeta WHERE meta_key = '$nomeMetodoEnvio'");

	$geraMetodo1 = array(
	"tipoMetodo" => "SemAutenticacao",
	"idMetodo" => $idMetodo,
	"nomeMetodo" => $nomeEnvio,
	);

	$serGeraMetododo = serialize($geraMetodo1);
	$grava = $wpdb->insert($wpdb->postmeta, array('meta_key' => 'metodoEnvioPag','meta_value' => $serGeraMetododo));
}

};
?>
<h3><?php echo $txtCad; ?></h3>
<div class="alert alert-success"><?php echo $msgenvio; ?></div>
<?php
echo '<meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=envios">';
?>
