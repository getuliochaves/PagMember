<?php
global $wpdb;
$tipoMetodo = $_GET['tipoMetodo'];
$acao = $_GET['acao'];
$meta_id = $_GET['meta_id'];
$txtCad = 'Cadastrar Método de Envio';
if($acao == 'edit'){
	$txtCad = 'Atualizar Método de Envio';
	$pegaDadosEnvio = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$meta_id'");

	$itemData = unserialize($pegaDadosEnvio);

	$nomeMetodo = $itemData['nomeMetodo'];

	if($tipoMetodo == 'AutoResponder'){

	$idFormulario = $itemData['idFormulario'];
	$idMetodo = $itemData['idMetodo'];
	$pegaDadosForm = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$idFormulario'");

	$pegaDadosMetodo = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$idMetodo'");
		$dadosMetodo = unserialize($pegaDadosMetodo);



		}



	if($tipoMetodo == 'ServidorSMTP'){
		$idMetodo = $itemData['idMetodo'];
		$pegaDadosMetodo = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$idMetodo'");
		$dadosMetodo = unserialize($pegaDadosMetodo);

		//var_dump($dadosMetodo );


		$msgInicial = $dadosMetodo['msgInicial'];
		$atualizacaoAcesso = $dadosMetodo['atualizacaoAcesso'];
		$cancelamentoAcesso = $dadosMetodo['cancelamentoAcesso'];
		$msgFinal = $dadosMetodo['msgFinal'];
		$codificado = $dadosMetodo['codificado'];

			if($codificado == 'sim'){
					$msgInicial = base64_decode($msgInicial);
					$atualizacaoAcesso = base64_decode($atualizacaoAcesso);
					$cancelamentoAcesso = base64_decode($cancelamentoAcesso);
					$msgFinal = base64_decode($msgFinal);
			};


		$tipoSenha = $dadosMetodo['tipoSenha'];
		$senhaUsu = $dadosMetodo['senhaUsu'];
		if($senhaUsu == ''){
			$tipoSenha = 'senhaAleatoria';
			}
		//var_dump($dadosMetodo);
	}

	if($tipoMetodo == 'SemAutenticacao'){
		$idMetodo = $itemData['idMetodo'];
		$pegaDadosMetodo = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$idMetodo'");
		$dadosMetodo = unserialize($pegaDadosMetodo);

		$msgInicial = $dadosMetodo['msgInicial'];
		$atualizacaoAcesso = $dadosMetodo['atualizacaoAcesso'];
		$cancelamentoAcesso = $dadosMetodo['cancelamentoAcesso'];
		$msgFinal = $dadosMetodo['msgFinal'];
		$codificado = $dadosMetodo['codificado'];

			if($codificado == 'sim'){
					$msgInicial = base64_decode($msgInicial);
					$atualizacaoAcesso = base64_decode($atualizacaoAcesso);
					$cancelamentoAcesso = base64_decode($cancelamentoAcesso);
					$msgFinal = base64_decode($msgFinal);
			};


		$tipoSenha = $dadosMetodo['tipoSenha'];
		$senhaUsu = $dadosMetodo['senhaUsu'];
		if($senhaUsu == ''){
			$tipoSenha = 'senhaAleatoria';
			}
	//	var_dump($dadosMetodo);
	}

	if($tipoMetodo == 'MailJet'){
		$idMetodo = $itemData['idMetodo'];
		$pegaDadosMetodo = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$idMetodo'");
		$dadosMetodo = unserialize($pegaDadosMetodo);

		$msgInicial = $dadosMetodo['msgInicial'];
		$atualizacaoAcesso = $dadosMetodo['atualizacaoAcesso'];
		$cancelamentoAcesso = $dadosMetodo['cancelamentoAcesso'];
		$msgFinal = $dadosMetodo['msgFinal'];
		$codificado = $dadosMetodo['codificado'];

			if($codificado == 'sim'){
					$msgInicial = base64_decode($msgInicial);
					$atualizacaoAcesso = base64_decode($atualizacaoAcesso);
					$cancelamentoAcesso = base64_decode($cancelamentoAcesso);
					$msgFinal = base64_decode($msgFinal);
			};

		$tipoSenha = $dadosMetodo['tipoSenha'];
		$senhaUsu = $dadosMetodo['senhaUsu'];
		if($senhaUsu == ''){
			$tipoSenha = 'senhaAleatoria';
			}
		//var_dump($dadosMetodo);
	}

}
?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<h3><?php echo $txtCad; ?></h3>
<br>
<?php
if($tipoMetodo == 'AutoResponder'){
	//var_dump($dadosMetodo);
?>

<div id="conteudo" style="display:none;"></div>

 <div class="alert alert-danger" id="errorForm"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
 ATENÇÃO: Este método funciona atualmente somente nas seguintes ferramentas: MailChimp, GetResponse e E-Gói
  .</div>

<h4>Antes de Colar o Código HTML do seu autoresponder, retire todas as tags clicando nesse link: <a href="http://geracaodigital.com/wp-content/formularios/removetags/" target="_blank">Validar AutoResponder</a></h4>

<hr>

<div class="form-horizontal" role="form">



<div class="form-group ">
    <label for="inputText" class="col-sm-2 control-label">Indentificação do Método:</label>
    <div class="col-sm-8">
<input type="text" class="form-control cursoOK" <?php if($acao == 'edit'){?> readonly <?php } ?> value="<?php echo $nomeMetodo; ?>" id="nomeFormulario"/>
    </div>
  </div>

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Formulário HTML:</label>
    <div class="col-sm-8">
<textarea class="form-control" rows="14"  id="formEntrada"><?php echo $pegaDadosForm; ?></textarea>
    </div>
  </div>

 <h3>Dados Usuário</h3>
 <hr>


<form method="post" action="admin.php?page=pagmember&pg=envios&pg2=envio&pg3=cad&tipoEnvio=AutoResponder&acao=<?php echo $acao; ?>&meta_id=<?php echo $meta_id; ?>" name="GravaFinalForm" enctype="multipart/form-data">
<textarea class="form-control" style="display:none;" rows="3" id="actionFormSaida" name="actionFormSaida"></textarea>
<textarea class="form-control" style="display:none;" rows="3" id="formSaida" name="formSaida"></textarea>
<textarea class="form-control" style="display:none;" rows="3" id="codigoFormulario" name="codigoFormulario"></textarea>

<div class="form-group ">
    <label for="inputText" class="col-sm-2 control-label">Campo Email:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required value="<?php echo $dadosMetodo['campoEmail']; ?>" id="campoEmail88" name="campoEmail"/>
    </div>
  </div>

<div class="form-group ">
    <label for="inputText" class="col-sm-2 control-label">Senha Padrão:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required value="<?php echo $dadosMetodo['senhaUsu']; ?>" name="senhaUsu"/>
    </div>
  </div>

 <div class="form-group ">
    <label for="inputText" class="col-sm-2 control-label">Página de Acesso:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required value="<?php echo $dadosMetodo['acessoUsu']; ?>" name="acessoUsu"/>
    </div>
  </div>

  <div id="formEnviaFinal" style="display:none;"/>


<div class="form-group">
    <div class="col-sm-12">
    <button type="submit" class="btn btn-primary btn-lg col-sm-10"><?php echo $txtCad; ?></button>
    </div>
  </div>

  </div>

</form>


<div class="form-group">
    <div class="col-sm-12">
    <input type="button" class="btn btn-success btn-lg col-sm-10" id="btVerifica" value="Verificar Formulário HTML"/>
    </div>
  </div>

  <div class="alert alert-success col-sm-10"  style="display:none;" id="okform"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
  Formulário verificado com sucesso. Clique para salvar seu formulário.</div>

  <div class="alert alert-danger col-sm-10" style="display:none;" id="errorForm"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
  Error, Campos inválidos ou vazios. Verifique se o código inserido é HTML.</div>



</div>
<script>
$a = jQuery.noConflict();
$a(document).ready(function(){
	$a('#formEntrada').click(function(){
		$a('#formEnviaFinal').hide();
		$a('#btVerifica').show();
		$a('#okform').hide();
		});

	var novocampo = '';
	$a('#btVerifica').click(function(){
	var formEntrada = $a('#formEntrada').val();
	$a('#conteudo').html(formEntrada);
	var nomeFormulario = $a('#nomeFormulario').val();

	if(formEntrada != '' && nomeFormulario != ''){
$a('#errorForm').hide();

	$a('#formEnviaFinal').show();
	$a('#btVerifica').hide();



	var nomeFormulario = $a('#nomeFormulario').val();
	var nomeFinal = '"nomeFormulario" => "'+nomeFormulario+'",';
	var actionFormSaida = $a('#conteudo form').attr('action');


	var dadosForm = $a( "#conteudo form" ).serialize();
	var campoEmail88 = $a("#conteudo input[type='email']").attr('name');
	$a('#campoEmail88').val(campoEmail88);
	if(dadosForm == ''){
		$a('#errorForm').show();
		$a('#formEnviaFinal').hide();
		$a('#btVerifica').show();


		}else{
		$a('#errorForm').hide();
		$a('#formEnviaFinal').show();
		$a('#okform').show();

		}
	var dadosFormFinal = dadosForm + '&nomeForm='+nomeFormulario;

		/*
		$a('#conteudo input').each(function(index){


			var nomecampo = '';
			var tipocampo = '';
			var valorcampo = '';

			var campo = $a(this);

			nomecampo = campo.attr('name');
			valorcampo = campo.val();
			//$data = array('newUserConfirm'=>'newUserConfirm', 'user_login'=>'setordigital2',
			var arrayFinal = '"'+nomecampo+'" => "'+nomecampo+'",';

			var total = campo.length;

			//alert(arrayFinal);

			if(novocampo != arrayFinal){
				novocampo = novocampo + arrayFinal + '\n';
			}

			if(index == 0){
			$a("#formSaida").html(novocampo);

			}

		if(total <= index){
			$a("#formSaida").html(novocampo);
			}

		if(total < index){

		novocampo = novocampo + nomeFinal + '\n';
		novocampo = novocampo + acaoFinal;
			$a("#formSaida").html(novocampo);
			}


		});

		$a("#codigoFormulario").html(formEntrada);


		var formSaidaFinal = $a('#formSaida').val();
		var formFFF = formSaidaFinal.serialize();
		//var formFFF = formSaidaFinal.toString();
alert(formFFF);

	//	var formFFF = formSaidaFinal.serialize();
//alert(formFFF);
*/

$a("#formSaida").html(dadosFormFinal);
$a("#actionFormSaida").html(actionFormSaida);
$a("#codigoFormulario").html(formEntrada);

		}else{
$a('#errorForm').show();


			}

});


});
</script>

<?php
};

if($tipoMetodo == 'ServidorSMTP'){
?>

<div class="alert alert-danger" style="display:none;" id="errorForm"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
  Erro ao Cadastrar. Um ou mais campos inválidos ou vazios.</div>

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="admin.php?page=pagmember&pg=envios&pg2=envio&pg3=cad&tipoEnvio=ServidorSMTP&acao=<?php echo $acao; ?>&meta_id=<?php echo $meta_id; ?>" name="formularioEnvio" id="formularioEnvio">

<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Indentificação do Método:</label>
    <div class="col-sm-8">
<input type="text" class="form-control cursoOK" <?php if($acao == 'edit'){?> readonly <?php } ?> required placeholder="Ex: Acesso ao PagMember por SMTP" value="<?php echo $dadosMetodo['nomeEnvio']?>" name="nomeEnvio">
    </div>
  </div>
<hr>
<h3>Dados do Servidor</h3>
<br />



<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Usuário SMTP/Email SMTP:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: contato@seudominio.com" value="<?php echo $dadosMetodo['emailServ']?>" name="emailServ">
    </div>
  </div>

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Senha:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: 123456" value="<?php echo $dadosMetodo['senhaServ']?>" name="senhaServ">
    </div>
  </div>

	<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Tipo de Autenticação:</label>
    <div class="col-sm-8">
			<select name="tipoAutenticacao">
				<option value="ssl" <?php if($dadosMetodo['tipoAutenticacao'] == 'ssl'){?>selected="selected"<?php }; ?>>SSL</option>
				<option value="tls" <?php if($dadosMetodo['tipoAutenticacao'] == 'tls'){?>selected="selected"<?php }; ?>>TLS</option>
				<option value="nao" <?php if($dadosMetodo['tipoAutenticacao'] == 'nao'){?>selected="selected"<?php }; ?>>Sem Autenticação</option>
			</select> Portas SSL(465), Portas TLS(25, 587, 588) ou Verifique seu SMTP
    </div>
  </div>

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Porta SMTP:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" placeholder="EX: 25" value="<?php echo $dadosMetodo['portaServ']?>" name="portaServ">
    </div>
  </div>

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Servidor SMTP:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" placeholder="Ex: mail.seudominio.com" value="<?php echo $dadosMetodo['smtpServ']?>" name="smtpServ">
    </div>
  </div>


  <hr>
<h3>Dados do Cliente</h3>
<br />
<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Email de Envio:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: contato@seudominio.com" value="<?php echo $dadosMetodo['emailEnvioRE']?>" name="emailEnvioRE">
    </div>
  </div>

 <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Remetente:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: Getulio Chaves" value="<?php echo $dadosMetodo['remetenteUsu']?>" name="remetenteUsu">
    </div>
  </div>

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Assunto:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: Dados de Acesso PagMember" value="<?php echo $dadosMetodo['assuntoUsu']?>" name="assuntoUsu">
    </div>
  </div>

  <?php
if($tipoSenha == "senhaAleatoria"){
	$mostraS = 'style="display:none;"';
	$activeA = 'active btn-success';
}else{
	$activeP = 'active btn-success';
	}
?>

  <div class="form-group">
   <label for="inputText" class="col-sm-2 control-label">Escolha o Tipo de Senha:</label>
    <input type="hidden" name="tipoSenha" class="tipoSenha" value="senhaPadrao">

    <div class="col-sm-8">
     <input type="button" class="btn btn senhaAleatoria <?php echo $activeA;?>" name="senhaAleatoria" value="Senha Aleatória"/>
     <input type="button" class="btn btn senhaPadrao <?php echo $activeP;?>" name="senhaPadrao" value="Senha Padrão"/>
    </div>
  </div>



<div class="mostraSenha" <?php echo $mostraS;?> >

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Senha Usuário:</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" placeholder="Ex: 123456" value="<?php echo $dadosMetodo['senhaUsu']?>" name="senhaUsu">
    </div>
  </div>

</div>

<hr>

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Página de Login:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: http://pagmember.com/login" value="<?php echo $dadosMetodo['loginUsu']?>" name="loginUsu">
    </div>
  </div>


  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Mensagem Inicial:</label>
    <div class="col-sm-8">
 <textarea class="form-control" required placeholder="Digite sua mensagem" rows="10" id="msgInicial" name="msgInicial"><?php echo $msgInicial; ?></textarea>
 OBS: Use a tag *nomeCliente* para inserir o nome do Cliente.
    </div>
  </div>

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Mensagem de Atualização de Acesso:</label>
    <div class="col-sm-8">
<textarea class="form-control" required placeholder="Sua assinatura Atualizada. Segue abaixo os dados de acesso continuam os mesmos. Segue o produto que você comprou." id="atualizacaoAcesso" rows="8" name="atualizacaoAcesso"><?php echo $atualizacaoAcesso; ?></textarea>
OBS: Use a tag *nomeCliente* para inserir o nome do Cliente.
    </div>
  </div>

   <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Mensagem de Cancelamento de Acesso:</label>
    <div class="col-sm-8">
<textarea class="form-control" required placeholder="Sua assinatura, ou cadastro foi cancelado. Clique no link abaixo para atualizar seu acesso e continuar na nossa plataforma." id="cancelamentoAcesso" rows="8" name="cancelamentoAcesso"><?php echo $cancelamentoAcesso; ?></textarea>
OBS: Use a tag *nomeCliente* para inserir o nome do Cliente.
    </div>
  </div>

  <hr/>


  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Mensagem Final:</label>
    <div class="col-sm-8">
<textarea class="form-control" required placeholder="Digite sua mensagem" id="msgFinal" rows="10" name="msgFinal"><?php echo $msgFinal; ?></textarea>
    </div>
  </div>
<div class="form-group">
    <div class="col-sm-12">

      <button type="submit" class="btn btn-primary btn-lg col-sm-10" id="btnCad"><?php echo $txtCad; ?></button>
    </div>
  </div>
 </form>

 <script>
 $a = jQuery.noConflict();
 $a(document).ready(function(){



	 var senhaUsu = $a('[name=senhaUsu]').val();


	 if(senhaUsu == ''){
		 $a('.tipoSenha').val('senhaAleatoria');
		 $a('.senhaPadrao').removeClass('active btn-success');
		 $a('.mostraSenha').hide();
		 $a('.senhaAleatoria').addClass('active btn-success');
		 }






	 $a(".senhaAleatoria").click(function(){

		$a('.senhaPadrao').removeClass('active btn-success');
		$a(this).addClass('active btn-success');
		$a('.mostraSenha').hide();
		$a('.tipoSenha').val('senhaAleatoria')
		$a('[name=senhaUsu]').val('');


		});

		$a(".senhaPadrao").click(function(){

		$a('.senhaAleatoria').removeClass('active btn-success');
		$a(this).addClass('active btn-success');
		$a('.mostraSenha').show();
		$a('.tipoSenha').val('senhaPadrao')

		//show(); -> Mostra Elemento
		//hide(); -> Oculta Elemento


		});

	 $a('#msgInicial').keypress(function(event) {
    if (event.keyCode == 13) {
		var conteudoMSG = $a('#msgInicial').val();
		var conteudoNovo = conteudoMSG + '<br>';
		$a("#msgInicial").val(conteudoNovo);
    }
	});


	 $a('#msgFinal').keypress(function(event) {
    if (event.keyCode == 13) {
		var conteudoMSG = $a('#msgFinal').val();
		var conteudoNovo = conteudoMSG + '<br>';
		$a("#msgFinal").val(conteudoNovo);
    }
	});


    $a(".validaFormulario").blur(function(){
     if($a(this).val() == "")
         {
             $a(this).css({"border" : "1px solid #F00", "padding": "2px"});
         }
    });
    $a("#btnCad").click(function(){
	$a('#errorForm').show();
     var cont = 0;
     $a("#formularioEnvio input").each(function(){
         if($a(this).val() == "")
             {
                 $a(this).css({"border" : "1px solid #F00", "padding": "2px"});
                 cont++;
             }
        });
     if(cont == 0)
         {
             $a("#formularioEnvio").submit();
         }
    });
});






</script>

<?php
};
if($tipoMetodo == 'SemAutenticacao'){
?>

<div class="alert alert-danger" style="display:none;" id="errorForm"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
  Erro ao Cadastrar. Um ou mais campos inválidos ou vazios.</div>

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="admin.php?page=pagmember&pg=envios&pg2=envio&pg3=cad&tipoEnvio=SemAutenticacao&acao=<?php echo $acao; ?>&meta_id=<?php echo $meta_id; ?>" name="formularioEnvio" id="formularioEnvio">

<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Indentificação do Método:</label>
    <div class="col-sm-8">
<input type="text" class="form-control cursoOK" <?php if($acao == 'edit'){?> readonly <?php } ?> required placeholder="Ex: Dados de Envio Sem Autenticação" value="<?php echo $dadosMetodo['nomeEnvio']?>" name="nomeEnvio">
    </div>
  </div>
<hr>
<h3>Dados do Envio</h3>
<br />

<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Nome Remetente:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: Getulio Chaves" value="<?php echo $dadosMetodo['remetenteEnvio']?>" name="remetenteEnvio">
    </div>
  </div>


<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Email Rementente:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: contato@seudominio.com" value="<?php echo $dadosMetodo['emailEnvio']?>" name="emailEnvio">
    </div>
  </div>

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Assunto:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: Dados de Acesso PagMember" value="<?php echo $dadosMetodo['assuntoEnvio']?>" name="assuntoEnvio">
    </div>
  </div>

   <hr>
<h3>Dados do Cliente</h3>
<br />
<?php
if($tipoSenha == "senhaAleatoria"){
	$mostraS = 'style="display:none;"';
	$activeA = 'active btn-success';
}else{
	$activeP = 'active btn-success';
	}


?>


 <div class="form-group">
   <label for="inputText" class="col-sm-2 control-label">Escolha o Tipo de Senha:</label>
    <input type="hidden" name="tipoSenha" class="tipoSenha" value="senhaPadrao">

    <div class="col-sm-8">
     <input type="button" class="btn btn senhaAleatoria <?php echo $activeA; ?>" name="senhaAleatoria" value="Senha Aleatória"/>
     <input type="button" class="btn btn <?php echo $activeP; ?> senhaPadrao" name="senhaPadrao" value="Senha Padrão"/>
    </div>
  </div>


<div class="mostraSenha" <?php echo $mostraS;?> >

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Senha Usuário:</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" placeholder="Ex: 123456" value="<?php echo $dadosMetodo['senhaUsu']?>" name="senhaUsu">
    </div>
  </div>

</div>

<hr>



  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Página de Login do Cliente:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: http://pagmember.com/login" value="<?php echo $dadosMetodo['loginUsu']?>" name="loginUsu">
    </div>
  </div>

     <hr>
<h3>Mensagens</h3>
<br />


  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Mensagem de Boas Vindas:</label>
    <div class="col-sm-8">
 <textarea class="form-control" required placeholder="Seja bem vindo ao Curso" rows="8" id="msgInicial" name="msgInicial"><?php echo $msgInicial; ?></textarea>
 OBS: Use a tag *nomeCliente* para inserir o nome do Cliente.
    </div>
  </div>

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Mensagem de Atualização de Acesso:</label>
    <div class="col-sm-8">
<textarea class="form-control" required placeholder="Sua assinatura Atualizada. Segue abaixo os dados de acesso continuam os mesmos. Segue o produto que você comprou." id="atualizacaoAcesso" rows="8" name="atualizacaoAcesso"><?php echo $atualizacaoAcesso; ?></textarea>
OBS: Use a tag *nomeCliente* para inserir o nome do Cliente.
    </div>
  </div>

   <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Mensagem de Cancelamento de Acesso:</label>
    <div class="col-sm-8">
<textarea class="form-control" required placeholder="Sua assinatura, ou cadastro foi cancelado. Clique no link abaixo para atualizar seu acesso e continuar na nossa plataforma." id="cancelamentoAcesso" rows="8" name="cancelamentoAcesso"><?php echo $cancelamentoAcesso; ?></textarea>
OBS: Use a tag *nomeCliente* para inserir o nome do Cliente.
    </div>
  </div>

  <hr/>


  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Mensagem Agradecimento:</label>
    <div class="col-sm-8">
<textarea class="form-control" required placeholder="Qualquer dúvida entre em contato" id="msgFinal" rows="8" name="msgFinal"><?php echo $msgFinal; ?></textarea>
    </div>
  </div>
<div class="form-group">
    <div class="col-sm-12">

      <button type="submit" class="btn btn-primary btn-lg col-sm-10" id="btnCad"><?php echo $txtCad; ?></button>
    </div>
  </div>
 </form>

 <script>
 $a = jQuery.noConflict();
 $a(document).ready(function(){

	 var senhaUsu = $a('[name=senhaUsu]').val();


	 if(senhaUsu == ''){
		 $a('.tipoSenha').val('senhaAleatoria');
		 $a('.senhaPadrao').removeClass('active btn-success');
		 $a('.mostraSenha').hide();
		 $a('.senhaAleatoria').addClass('active btn-success');
		 }






	 $a(".senhaAleatoria").click(function(){

		$a('.senhaPadrao').removeClass('active btn-success');
		$a(this).addClass('active btn-success');
		$a('.mostraSenha').hide();
		$a('.tipoSenha').val('senhaAleatoria')
		$a('[name=senhaUsu]').val('');


		});

		$a(".senhaPadrao").click(function(){

		$a('.senhaAleatoria').removeClass('active btn-success');
		$a(this).addClass('active btn-success');
		$a('.mostraSenha').show();
		$a('.tipoSenha').val('senhaPadrao')

		//show(); -> Mostra Elemento
		//hide(); -> Oculta Elemento


		});

    $a("input").blur(function(){
     if($a(this).val() == "")
         {
             $a(this).css({"border" : "1px solid #F00", "padding": "2px"});
         }
    });
    $a("#btnCad").click(function(){
	$a('#errorForm').show();
     var cont = 0;
     $a("#formularioEnvio input").each(function(){
         if($a(this).val() == "")
             {
                 $a(this).css({"border" : "1px solid #F00", "padding": "2px"});
                 cont++;
             }
        });
     if(cont == 0)
         {
             $a("#formularioEnvio").submit();
         }
    });
});






</script>

<?php
};
if($tipoMetodo == 'MailJet'){
?>

<div class="alert alert-danger" style="display:none;" id="errorForm"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
  Erro ao Cadastrar. Um ou mais campos inválidos ou vazios.</div>

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="admin.php?page=pagmember&pg=envios&pg2=envio&pg3=cad&tipoEnvio=MailJet&acao=<?php echo $acao; ?>&meta_id=<?php echo $meta_id; ?>" name="formularioEnvio" id="formularioEnvio">

<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Indentificação do Método:</label>
    <div class="col-sm-8">
<input type="text" class="form-control cursoOK" <?php if($acao == 'edit'){?> readonly <?php } ?> required placeholder="Ex: Dados de Envio Sem Autenticação" value="<?php echo $dadosMetodo['nomeEnvio']?>" name="nomeEnvio">
    </div>
  </div>
<hr>

<h3>Dados do MailJet - <a style="font-size:14px !important;" href="https://app.mailjet.com/account/setup" target="_blank">Clique para Pegar esses Dados</a></h3>
<br />

<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">API Key (SMTP username):</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: 4d93d3332acd5909384728dec9000" value="<?php echo $dadosMetodo['apikeymailjet']?>" name="apikeymailjet">
    </div>
  </div>


<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Secret Key (SMTP password):</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: sdf0bdasdfergd8b70979b418ef" value="<?php echo $dadosMetodo['secretkeymailjet']?>" name="secretkeymailjet">
    </div>
  </div>



   <hr>


<h3>Dados do Envio</h3>
<br />

<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Nome Remetente:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: Getulio Chaves" value="<?php echo $dadosMetodo['remetenteEnvio']?>" name="remetenteEnvio">
    </div>
  </div>


<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Email Rementente:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: contato@seudominio.com" value="<?php echo $dadosMetodo['emailEnvio']?>" name="emailEnvio">
    </div>
  </div>

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Assunto:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: Dados de Acesso PagMember" value="<?php echo $dadosMetodo['assuntoEnvio']?>" name="assuntoEnvio">
    </div>
  </div>

   <hr>
<h3>Dados do Cliente</h3>
<br />
<?php
if($tipoSenha == "senhaAleatoria"){
	$mostraS = 'style="display:none;"';
	$activeA = 'active btn-success';
}else{
	$activeP = 'active btn-success';
	}


?>


 <div class="form-group">
   <label for="inputText" class="col-sm-2 control-label">Escolha o Tipo de Senha:</label>
    <input type="hidden" name="tipoSenha" class="tipoSenha" value="senhaPadrao">

    <div class="col-sm-8">
     <input type="button" class="btn btn senhaAleatoria <?php echo $activeA; ?>" name="senhaAleatoria" value="Senha Aleatória"/>
     <input type="button" class="btn btn <?php echo $activeP; ?> senhaPadrao" name="senhaPadrao" value="Senha Padrão"/>
    </div>
  </div>


<div class="mostraSenha" <?php echo $mostraS;?> >

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Senha Usuário:</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" placeholder="Ex: 123456" value="<?php echo $dadosMetodo['senhaUsu']?>" name="senhaUsu">
    </div>
  </div>

</div>

<hr>



  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Página de Login do Cliente:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: http://pagmember.com/login" value="<?php echo $dadosMetodo['loginUsu']?>" name="loginUsu">
    </div>
  </div>

     <hr>
<h3>Mensagens</h3>
<br />


  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Mensagem de Boas Vindas:</label>
    <div class="col-sm-8">
 <textarea class="form-control" required placeholder="Seja bem vindo ao Curso" rows="8" id="msgInicial" name="msgInicial"><?php echo $msgInicial; ?></textarea>
 OBS: Use a tag *nomeCliente* para inserir o nome do Cliente.
    </div>
  </div>





   <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Mensagem de Atualização de Acesso:</label>
    <div class="col-sm-8">
<textarea class="form-control" required placeholder="Sua assinatura Atualizada. Segue abaixo os dados de acesso continuam os mesmos. Segue o produto que você comprou." id="atualizacaoAcesso" rows="8" name="atualizacaoAcesso"><?php echo $atualizacaoAcesso; ?></textarea>
OBS: Use a tag *nomeCliente* para inserir o nome do Cliente.
    </div>
  </div>

   <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Mensagem de Cancelamento de Acesso:</label>
    <div class="col-sm-8">
<textarea class="form-control" required placeholder="Sua assinatura, ou cadastro foi cancelado. Clique no link abaixo para atualizar seu acesso e continuar na nossa plataforma." id="cancelamentoAcesso" rows="8" name="cancelamentoAcesso"><?php echo $cancelamentoAcesso; ?></textarea>
OBS: Use a tag *nomeCliente* para inserir o nome do Cliente.
    </div>
  </div>

    <hr/>

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Mensagem Final Agradecimento:</label>
    <div class="col-sm-8">
<textarea class="form-control" required placeholder="Qualquer dúvida entre em contato" id="msgFinal" rows="8" name="msgFinal"><?php echo $msgFinal; ?></textarea>

    </div>
  </div>



<div class="form-group">
    <div class="col-sm-12">

      <button type="submit" class="btn btn-primary btn-lg col-sm-10" id="btnCad"><?php echo $txtCad; ?></button>
    </div>
  </div>
 </form>

 <script>
 $a = jQuery.noConflict();
 $a(document).ready(function(){

	 var senhaUsu = $a('[name=senhaUsu]').val();


	 if(senhaUsu == ''){
		 $a('.tipoSenha').val('senhaAleatoria');
		 $a('.senhaPadrao').removeClass('active btn-success');
		 $a('.mostraSenha').hide();
		 $a('.senhaAleatoria').addClass('active btn-success');
		 }






	 $a(".senhaAleatoria").click(function(){

		$a('.senhaPadrao').removeClass('active btn-success');
		$a(this).addClass('active btn-success');
		$a('.mostraSenha').hide();
		$a('.tipoSenha').val('senhaAleatoria')
		$a('[name=senhaUsu]').val('');

		//show(); -> Mostra Elemento
		//hide(); -> Oculta Elemento


		});

		$a(".senhaPadrao").click(function(){

		$a('.senhaAleatoria').removeClass('active btn-success');
		$a(this).addClass('active btn-success');
		$a('.mostraSenha').show();
		$a('.tipoSenha').val('senhaPadrao')

		//show(); -> Mostra Elemento
		//hide(); -> Oculta Elemento


		});

    $a("input").blur(function(){
     if($a(this).val() == "")
         {
             $a(this).css({"border" : "1px solid #F00", "padding": "2px"});
         }
    });
    $a("#btnCad").click(function(){
	$a('#errorForm').show();
     var cont = 0;
     $a("#formularioEnvio input").each(function(){
         if($a(this).val() == "")
             {
                 $a(this).css({"border" : "1px solid #F00", "padding": "2px"});
                 cont++;
             }
        });
     if(cont == 0)
         {
             $a("#formularioEnvio").submit();
         }
    });




});
</script>

<?php
};
?>
<script>
 $b = jQuery.noConflict();
 $b(document).ready(function(){
//Campo Email Remetente
	  $b('[name=emailEnvio]').keyup(function(){
			 $b(this).val($b(this).val().trim());
		});

	//Campo emailServ
	  $b('[name=emailServ]').keyup(function(){
			$b(this).val($b(this).val().trim());
		});

		//Campo senhaServ
	 $b('[name=senhaServ]').keyup(function(){
			$b(this).val($b(this).val().trim());
		});

		//Campo portaServ
	 $b('[name=portaServ]').keyup(function(){
			$b(this).val($b(this).val().trim());
		});

		//Campo smtpServ
	 $b('[name=smtpServ]').keyup(function(){
			$b(this).val($b(this).val().trim());
		});

		//Campo loginUsu
	 $b('[name=loginUsu]').keyup(function(){
			$b(this).val($b(this).val().trim());
		});

		//Campo campoEmail
	 $b('[name=campoEmail]').keyup(function(){
			$b(this).val($b(this).val().trim());
		});

		//Campo acessoUsu
	 $b('[name=acessoUsu]').keyup(function(){
			$b(this).val($b(this).val().trim());
		});

		//Campo apikeymailjet
	 $b('[name=apikeymailjet]').keyup(function(){
			$b(this).val($b(this).val().trim());
		});

		//Campo secretkeymailjet
	 $b('[name=secretkeymailjet]').keyup(function(){
			$b(this).val($b(this).val().trim());
		});
});
</script>
