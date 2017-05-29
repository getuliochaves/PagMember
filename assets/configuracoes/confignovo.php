<?php
global $wpdb;
if($_GET['pg3'] != 'geral'){
$tipoToken = $_GET['tipoToken'];
$pegaDadosToken = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'dadosToken'");
$listaToken = unserialize($pegaDadosToken);
$dadosToken = $listaToken[$tipoToken];
$emailConta = $dadosToken['email'];
$pgred = $dadosToken['pgred'];
$token = $dadosToken['token'];
$scripts = $dadosToken['scripts'];
$scripts = base64_decode($scripts);
$scripts = stripcslashes($scripts);

switch ($tipoToken) {
  case 'PagSeguro':
  $urlIn = 'https://pagseguro.uol.com.br/preferencias/integracoes.jhtml';
  break;
  case 'Hotmart':
  $urlIn = 'https://app-vlc.hotmart.com/tools/notifications';
  break;

  case 'Eduzz':
  $urlIn = 'https://my.eduzz.com/content/produtor';
  break;

  case 'Monetizze':
  $urlIn = 'https://app.monetizze.com.br/ferramentas/postback';
  break;

  default:
  $urlIn = '';
  break;
}

?>
<?php
if($_GET['pg3'] == 'edit'){
?>
<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="admin.php?page=pagmember&pg=configuracoes&pg2=config&pg3=grava&tipoToken=<?php echo $tipoToken;?>" name="formularioEnvio" id="formularioEnvio">

<hr/>
  <h3>Configurações de Token (Obrigatório)</h3>

<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Tokem <?php echo $tipoToken; ?>:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Digite seu Token <?php echo $tipoToken; ?>" value="<?php echo $token; ?>" name="token">

<a href="<?php echo $urlIn; ?>" class="btn btn-success btn-sm" target="_blank" value="Pegar Token"><strong>Pegar Token de Integração no site do <?php echo $tipoToken; ?></strong></a>
</br>
</br>
<div class="alert alert-danger"> ATENÇÃO: Este mesmo token deve ser conlocado nas configurações do <strong>PagMemberCliente</strong> para funcionar Corretametne.</div>
    </div>
  </div>

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Email da Conta <?php echo $tipoToken; ?>:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: seuemail@gmail.com" value="<?php echo $emailConta; ?>" name="emailconta">
    </div>
  </div>

<?php
if($tipoToken == 'PagSeguro'){
 ?>
  <hr/>
  <h3>Configurações Adicionais (Opcional)</h3>
<br>


  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Página de Redirecionamento Fixo <?php echo $tipoToken; ?>:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" placeholder="Ex: http://seusite.com/obrigado" value="<?php echo $pgred; ?>" name="pgred">
    </div>
  </div>
<?php
};
 ?>
  <!--

  <hr/>
  <h3>Códigos e Scripts (Opcional)</h3>
<br>

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Códigos Facebook, inclua a tag <\script>:</label>
    <div class="col-sm-8">
    <textarea name="scripts" class="form-control" style="height:200px;" placeholder="Insira seu código aqui com as tags <script> </script>"><?php echo $scripts; ?></textarea>
    </div>
  </div>

-->

<div class="form-group">
    <div class="col-sm-12">

      <button type="submit" class="btn btn-primary btn-lg col-sm-10" id="btnCad">Salvar Alterações</button>
    </div>
  </div>
 </form>
 <script>
$a = jQuery.noConflict();
$a(document).ready(function(){
		$a('input[name=token], input[name=emailconta], input[name=pgred]').keyup(function(){
			$a(this).val($a(this).val().trim());

	});


});
</script>
<?php
};
if($_GET['pg3'] == 'grava'){
	$token = $_POST['token'];
	$emailconta = $_POST['emailconta'];
	$pgred = $_POST['pgred'];
	$scripts = $_POST['scripts'];
	$scripts = base64_encode($scripts);

	$listaToken[$tipoToken]['token'] = $token;
	$listaToken[$tipoToken]['email'] = $emailconta;
	$listaToken[$tipoToken]['pgred'] = $pgred;
	$listaToken[$tipoToken]['scripts'] = $scripts;
	$listaToken[$tipoToken]['emailtestes'] = $emailtestes;


	$dadosTokenGrava = serialize($listaToken);

	if(count($pegaDadosToken) == 0){
	$wpdb->insert($wpdb->options, array('option_name' => 'dadosToken','option_value' => $dadosTokenGrava));
	}else{
	$wpdb->query("UPDATE $wpdb->options SET option_value = '$dadosTokenGrava' WHERE option_name = 'dadosToken'");
	}

	$msgenvio = 'Alterações Gravadas Sucesso. Estamos redirecionamento, aguarde.';
	echo '<div class="alert alert-success">'.$msgenvio.'</div>';
	echo '<meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=configuracoes&pg2=config&pg3=edit&tipoToken='.$tipoToken.'">';
}

}
if($_GET['pg3'] == 'geral'){
$pegaDadosGeral = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'dadosGeralPagMember'");
$listaDadosGeral = unserialize($pegaDadosGeral);
$emailtestes = $listaDadosGeral['EmailTestes'];
?>
<h3>Configurações Gerais</h3>
<br>
<?php
if(!isset($_GET['grava'])){
?>

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="admin.php?page=pagmember&pg=configuracoes&pg2=config&pg3=geral&grava=sim" name="formularioEnvio" id="formularioEnvio">
<hr/>



   <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">(Opcional)Email para Testes de Envio de Dados de Acesso e Criação de Usuário:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" placeholder="Ex: emaiteste@seusite.com" value="<?php echo $emailtestes; ?>" name="emailtestes">
<div class="alert alert-danger">ATENÇÃO: Este Email não deve estar cadastrado na sua área de membros, nem no seu autoresponder.</div>
    </div>
  </div>



<div class="form-group">
    <div class="col-sm-12">

      <button type="submit" class="btn btn-primary btn-lg col-sm-10" id="btnCad">Salvar Alterações</button>
    </div>
  </div>
 </form>

<?php
};
if($_GET['grava'] == 'sim'){
	$emailtestes = $_POST['emailtestes'];
	$gravaEmailTeste['EmailTestes'] = $emailtestes;
	$dadosGeral = serialize($gravaEmailTeste);
	//var_dump($gravaEmailTeste);


	if(count($pegaDadosGeral) == 0){
	$wpdb->insert($wpdb->options, array('option_name' => 'dadosGeralPagMember','option_value' => $dadosGeral));
	}else{
	$wpdb->query("UPDATE $wpdb->options SET option_value = '$dadosGeral' WHERE option_name = 'dadosGeralPagMember'");
	}

	$msgenvio = 'Alterações Gravadas Sucesso. Estamos redirecionamento, aguarde.';
	echo '<div class="alert alert-success">'.$msgenvio.'</div>';
	echo '<meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=configuracoes&pg2=config&pg3=geral">';
	};
};
?>
