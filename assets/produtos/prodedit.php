<?php
global $wpdb;
global $wp_roles;
$siteLocal = get_site_url().'/';
$listaPro = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$prodMetaId'");
$pegaProd = unserialize($listaPro);

//var_dump($pegaProd);

$nivelProd0 = $pegaProd['nivelProd'];
$userGratis = $pegaProd['userGratis'];
$idMetodoEnvioAguardaDB = $pegaProd['idMetodoEnvioAguarda'];
$nivelProdAguarda = $pegaProd['nivelProdAguarda'];
$idMetodoEnvioBD = $pegaProd['idMetodoEnvio'];
$tipoProd = $pegaProd['tipoProd'];
$clienteNoSite = $pegaProd['clienteNoSite'];
$nivelProd = $nivelProd0;
if($tipoProd == 'hotmart'){
$displayHot = 'style="display:block;"';
	}else{
$displayHot = 'style="display:none;"';
	}


//var_dump($pegaProd);
?>



<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="admin.php?page=pagmember&pg=produtos&pg2=prod&pg3=upd&prodMetaId=<?php echo $prodMetaId; ?>" name="formularioProd">
<h3>Modo de Edição do Produto <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> <?php echo $pegaProd['nomeProd']; ?></h3>
<hr>
<h3>Dados do Produto</h3>
<br />

<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Tipo de Produto:</label>

    <div class="col-sm-6">
      <select class="form-control" name="tipoProd" id="TipoProdItem">
      <option <?php if($tipoProd == ''){?> selected="selected" <?php };?> value="nao">Onde vai Vender seu Produto?</option>
          <option <?php if($pegaProd['tipoProd'] == 'hotmart'){?> selected="selected" <?php };?> value="hotmart">Produto Hotmart</option>
          <option <?php if($pegaProd['tipoProd'] == 'pagseguro'){?> selected="selected" <?php };?> value="pagseguro">Produto PagSeguro</option>
					<option <?php if($pegaProd['tipoProd'] == 'monetizze'){?> selected="selected" <?php };?> value="monetizze">Produto Monetizze</option>
					<option <?php if($pegaProd['tipoProd'] == 'eduzz'){?> selected="selected" <?php };?> value="eduzz">Produto Eduzz</option>
       </select>
    </div>
  </div>

<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Nome do Produto:</label>
    <div class="col-sm-6">
<input type="text" class="form-control" required placeholder="Ex: Pagmember" value="<?php echo $pegaProd['nomeProd']; ?>" name="nomeProd">
    </div>
  </div>

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">ID do Produto:</label>
    <div class="col-sm-6">
<input type="text" class="form-control" required placeholder="Ex: 103040" value="<?php echo $pegaProd['idProd']; ?>" name="idProd">
    </div>
  </div>

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Valor do Produto:</label>
    <div class="col-sm-6">
<input type="text" class="form-control" placeholder="R$ 450,00" value="<?php echo $pegaProd['valorProd']; ?>" name="valorProd">
    </div>
  </div>

  <div id="itemHotmart" <?php echo $displayHot; ?>>

          <div class="form-group">
            <label for="inputText" class="col-sm-2 control-label">Oferta Hotmart:</label>
            <div class="col-sm-6">
        <input type="text" class="form-control" placeholder="Ex: o90xy" value="<?php echo $pegaProd['nomeOff'];?>" name="nomeOff">
            </div>
          </div>

          <div class="form-group">
            <label for="inputText" class="col-sm-2 control-label">Descrição Oferta Hotmart:</label>
            <div class="col-sm-6">
        <input type="text" class="form-control" placeholder="Ex: Plano Basico" value="<?php echo $pegaProd['descOff'];?>" name="descOff">
            </div>
          </div>

   </div>


  <hr>
<h3>Envio de Dados de Acesso após <strong>Pagamento Confirmado</strong></h3>
<br />





  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Nível de Acesso:</label>

    <div class="col-sm-6">

    <?php
      global $wp_roles;
	  $pega_options = get_option('ws_plugin__optimizemember_options');
		//var_dump($pega_options);
	?>

      <select class="form-control" name="nivelProdEscolhe" id="nivelProdEscolhe">
      <option value="nao">Qual o nível do Aluno?</option>

      <?php


foreach($wp_roles->roles as $key=>$value){
	$retonarlevel2 = explode('_',$key);
	$retonarlevel = $retonarlevel2[1];
	//var_dump($retonarlevel2);
	if($retonarlevel != null){
		$pegalevel = $pega_options[$retonarlevel.'_label'];

		?>
		<option <?php if($nivelProd == $key){?> selected="selected" <?php };?> value="<?php echo $key; ?>"><?php echo $pegalevel; ?></option>
		<?php
	}else{
		?>
        <option <?php if($nivelProd == $key){?> selected="selected" <?php };?> value="<?php echo $key; ?>"><?php echo $value['name']; ?></option>
		<?php
		}

	}

?>

       </select>
    </div>
  </div>




   <input type="hidden" name="nivelProd" value="<?php echo $nivelProd; ?>">

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Ou Digite o Nível do Aluno:</label>
    <div class="col-sm-6">
<input type="text" class="form-control" placeholder="Ex: 360" value="<?php echo $nivelProd; ?>" id="nivelProdDigita">
    </div>
  </div>













  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Forma de Envio:</label>

    <div class="col-sm-6">
      <select class="form-control" name="idMetodoEnvio">
      <option <?php if($envioProd == ''){?> selected="selected" <?php };?> value="">Como vai enviar os dados de Acesso?</option>

      <?php
      $listaEnvios = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key like '%metodoEnvioPag%'");
		$contaEnvios = count($listaEnvios);

		foreach($listaEnvios as $linhaEnvio){
		$idMetodoEnvio = $linhaEnvio->meta_id;
		$envioPag = $linhaEnvio->meta_value;
		$envioPag2 = unserialize($envioPag);
		$nomeEnvio = $envioPag2['nomeMetodo'];

		?>


          <option <?php if($idMetodoEnvioBD == $idMetodoEnvio){?> selected="selected" <?php };?> value="<?php echo $idMetodoEnvio; ?>"><?php echo $nomeEnvio; ?></option>


          <?php

		};


		  ?>
       </select>
    </div>
  </div>






  <hr>
<h3>Envio de Dados de Acesso enquanto <strong>Aguarda Pagamento</strong></h3>
<br />

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Ativar Usuário Grátis?</label>

    <?php
    if($userGratis == ''){
		$userGratis = 'naoPermitir';
		}

	    if($userGratis == 'Permitir'){
		$botaoPermitir = 'btn-success';
		$display = 'style="display:block;"';
		}else{
		$botaoNPermitir = 'btn-success';
		$display = 'style="display:none;"';
			}


    ?>

    <input type="hidden" name="userGratis" id="userGratis" value="<?php echo $userGratis;?>">

    <div class="col-sm-6">
     <input type="button" id="PermitirUserFree" class="btn <?php echo $botaoPermitir; ?> btn" name="PermitirUserFree" value="Permitir Criar Usuário Grátis"/>
     <input type="button" id="NaoPermitirUserFree" class="btn <?php echo $botaoNPermitir; ?> btn active" name="NaoPermitirUserFree" value="Não Permitir Criar Usuário Grátis"/>
    </div>
  </div>

  <div id="permitirUsu" <?php echo $display; ?>>


  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Nível de Acesso:</label>

    <div class="col-sm-6">

    <?php
      global $wp_roles;
	  $pega_options = get_option('ws_plugin__optimizemember_options');
	?>

      <select class="form-control" name="nivelProdEscolheAg" id="nivelProdEscolheAg">
      <option value="nao">Qual o nível do Aluno?</option>

      <?php


foreach($wp_roles->roles as $key=>$value){
	$retonarlevel2 = explode('_',$key);
	$retonarlevel = $retonarlevel2[1];
	//var_dump($retonarlevel2);
	if($retonarlevel != null){
		$pegalevel = $pega_options[$retonarlevel.'_label'];

		?>
		<option <?php if($nivelProdAguarda == $key){?> selected="selected" <?php };?> value="<?php echo $key; ?>"><?php echo $pegalevel; ?></option>
		<?php
	}else{
		?>
        <option <?php if($nivelProdAguarda == $key){?> selected="selected" <?php };?> value="<?php echo $key; ?>"><?php echo $value['name']; ?></option>
		<?php
		}

	}

?>

       </select>
    </div>
  </div>




   <input type="hidden" name="nivelProdAguarda" value="<?php echo $nivelProdAguarda; ?>">

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Ou Digite o Nível do Aluno:</label>
    <div class="col-sm-6">
<input type="text" class="form-control" placeholder="Ex: optimizemember_level1" value="<?php echo $nivelProdAguarda; ?>" id="nivelProdDigitaAg">
    </div>
  </div>



  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Forma de Envio:</label>

    <div class="col-sm-6">
      <select class="form-control" name="idMetodoEnvioAguarda">
      <option <?php if($idMetodoEnvioAguarda == ''){?> selected="selected" <?php };?> value="">Como vai enviar os dados de Acesso?</option>

      <?php
      $listaEnviosAguarda = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key like '%metodoEnvioPag%'");
		$contaEnviosAguarda = count($listaEnviosAguarda);

		foreach($listaEnviosAguarda as $linhaEnvioAguarda){
		$idMetodoEnvioAguarda = $linhaEnvioAguarda->meta_id;
		$envioPagAguarda = $linhaEnvioAguarda->meta_value;
		$envioPag2Aguarda = unserialize($envioPagAguarda);
		$nomeEnvioAguarda = $envioPag2Aguarda['nomeMetodo'];
		?>




          <option <?php if($idMetodoEnvioAguardaDB == $idMetodoEnvioAguarda){?> selected="selected" <?php };?>  value="<?php echo $idMetodoEnvioAguarda; ?>"><?php echo $nomeEnvioAguarda; ?></option>


          <?php
		};
		  ?>
       </select>
    </div>
  </div>


</div>




  <hr>
<h3>Dados Adicionais</h3>
<br />

 <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Pacotes OptimizePress:</label>
    <div class="col-sm-6">
    <?php
    $pacoteProd = $pegaProd['packProd'];
	$pegaProd0 = unserialize($pacoteProd);

	if($pegaProd0[0] != ''){


	$contaArray = count($pegaProd0);
	$a = 1;
	foreach($pegaProd0 as $key => $value){

		if($a < $contaArray){
		$pack .= $value.',';
		}else{
		$pack .= $value;
			}
		$a++;

		}
	}else{
		$pack = '';
		}


	?>
<input type="text" class="form-control" placeholder="Ex: downloadAquivos" value="<?php echo $pack ?>" name="packProd">
    </div>
  </div>


  <?php
  $posCompra = $pegaProd['posCompra'];
  if($tipoProd == 'pagseguro'){
	  $displayPag = 'style="display:block;"';
	  }else{
	   $displayPag = 'style="display:none;"';
	}
    if($posCompra == ''){
		$posCompra = 'naoAtivar';
		}

	    if($posCompra == 'Ativar'){
		$botaoPermitirPos = 'btn-success';
		$display = 'style="display:block;"';
		}else{
		$botaoNPermitirPos = 'btn-success';
		$display = 'style="display:none;"';
			}


    ?>


   <!-- Inicio Pagina Redirecionamento pos compra -->
  <div class="form-group" <?php echo $displayPag; ?> id="redirecionamentoCliente">
    <label for="inputText" class="col-sm-2 control-label">Ativar Redirecionamento Pós Compra?</label>

    <input type="hidden" name="posCompra" id="posCompra" value="naoAtivar">

    <div class="col-sm-8">
     <input type="button" id="PermitirPosCompra" class="btn <?php echo $botaoPermitirPos;?>" name="PermitirPosCompra" value="Ativar Página de Redirecionamento"/>
     <input type="button" id="NaoPermitirPosCompra" class="btn <?php echo $botaoNPermitirPos;?> active" name="NaoPermitirPosCompra" value="Desativar Página de Redirecionamento"/>
    </div>
  </div>

  <div id="permitirPos" <?php echo $display; ?>>



   <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Redirecionar para página pós-compra PagSeguro:</label>
    <div class="col-sm-6">
<input type="text" class="form-control" placeholder="Ex: http://pagmember.com/acesso" value="<?php echo $pegaProd['redProd']; ?>" name="redProd">
    </div>
  </div>

  </div> <!-- Fim Pagina Redirecionamento pos compra -->

	<!-- Inicio Produto para o Site -->
	  <div class="form-group" id="prodSite">
	    <label for="inputText" class="col-sm-2 control-label">Onde Está sua área de Membros?</label>

	 <input type="hidden" name="siteLocal" id="siteLocal" value="<?php echo $siteLocal; ?>">

	    <div class="col-sm-8">
	     <input type="button" <?php if($siteLocal == $pegaProd['siteProd']){?> selected<?php };?> id="mesmoSite" class="btn btn-success active" name="mesmoSite" value="Neste Mesmo Site"/>
	     <input type="button" <?php if($siteLocal != $pegaProd['siteProd']){?> selected<?php };?> id="siteExterno" class="btn" name="siteExterno" value="Em um Site Externo"/>
	     <strong>Site:</strong> <input type="text" style="border:1px solid #fff; box-shadow: none; webkit-box-shadow: none; background:#fff; width:335px; outline:none" name="siteProd" id="siteProd" value="<?php echo $pegaProd['siteProd']; ?>">
	     <div class="mostraS"></div>
	    </div>
	  </div>
	  <!-- FIM Produto para o Site -->



		<!-- Inicio Div Mostra URl Externa -->
		<div class="mostraUrlExterna" <?php if($siteLocal == $pegaProd['siteProd']){?> style="display:none;" <?php }; ?>>

		<div class="form-group">
			<label for="inputText" class="col-sm-2 control-label">Digite o link da página Inicial do Site Externo, com barra "/" no final</label>
			<div class="col-sm-6">
		<input type="text" class="form-control urlSiteExterno" placeholder="Ex: http://wpages.net/" value="<?php echo $pegaProd['siteProd'];?>" name="urlSiteExterno">
			</div>
		</div>

		</div>
		<!-- FIM Div Mostra URl Externa -->

  <?php
  if($clienteNoSite == 'excluirCliente'){
	  $ativeE = 'btn-danger active';
	  }else{
		$ativeM = 'btn-success active';
		  }
  ?>

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Deseja manter Cliente, como usuário grátis, após compra Cancelada?:</label>
    <div class="col-sm-6">

<input type="hidden" name="clienteNoSite" id="clienteNoSite" value="manterCliente">


     <input type="button" id="manterCliente" class="btn <?php echo $ativeM; ?> " name="manterCliente" value="Manter Cliente"/>
     <input type="button" id="excluirCliente" class="btn <?php echo $ativeE; ?>" name="excluirCliente" value="Excluir Cliente"/>


    </div>
  </div>


     <hr>
<h3>Ativar "Automatic EOT Time"(Prazo da assinatura OptimizePress)</h3>
<br />

<?php
$eotCli = $pegaProd['eotCli'];
$eotProd = $pegaProd['eotProd'];

if($eotCli == 'Ativar'){
$ativeCli = 'btn btn-success active';
$desativaCli = 'btn btn';
$displayEOT = 'style="display:block;"';
}else{
	$ativeCli = 'btn btn';
	$desativaCli = 'btn btn-success active';
	$displayEOT = 'style="display:none;"';
	$eotCli = 'naoAtivar';
}
?>



  <!-- Inicio Automatic EOT Time -->
  <div class="form-group" id="eotCliente">
    <label for="inputText" class="col-sm-2 control-label">Ativar "Automatic EOT Time"</label>

    <input type="hidden" name="eotCli" id="eotCli" value="<?php echo $eotCli; ?>">

    <div class="col-sm-8">
     <input type="button" id="PermitirEOT"  class="<?php echo $ativeCli; ?>" value="Ativar Automatic EOT Time"/>
     <input type="button" id="NaoPermitirEOT" class="btn <?php echo $desativaCli; ?>" value="Desativar Automatic EOT Time"/>
    </div>
  </div>

  <div id="permitirEOTTime" <?php echo $displayEOT; ?>>



   <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Escolha o Tempo:</label>

    <div class="col-sm-6">
      <select class="form-control" id="eotEscolhe">
      <option value="nao" selected>Escolhe um tempo ou Digite no Campo Abaixo:</option>
          <option value="7">7 Dias</option>
           <option value="15">15 Dias</option>
            <option value="30">1 Mês</option>
            <option value="90">3 Meses</option>
            <option value="180">6 Meses</option>
            <option value="360">1 Ano</option>
            <option value="720">2 Anos</option>
             <option value="1800">5 Anos</option>
       </select>
    </div>
  </div>

   <input type="hidden" name="eotProd" value="<?php echo $eotProd; ?>">

  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Ou Digite um Total de dias:</label>
    <div class="col-sm-6">
<input type="text" class="form-control" placeholder="Ex: 360" value="<?php echo $eotProd; ?>" id="eotDigita">
    </div>
  </div>

  </div> <!-- Fim Automatic EOT Time -->





<div class="form-group">
    <div class="col-sm-offset-5 col-sm-6">
      <button type="submit" class="btn btn-primary btn-lg">Atualizar Produto</button>
    </div>
  </div>
 </form>

<script>
$a = jQuery.noConflict();
$a(document).ready(function(){

	//EOT Time
var siteLocal = $a('#siteLocal').val();
   var siteP = $a('#siteProd').val();

	 if(siteLocal == siteP){
		 $a('.mostraUrlExterna').hide();
	   $a('.urlSiteExterno').attr("required", false);
		 $a('#siteExterno').removeClass('active btn-success');
		 $a('#mesmoSite').addClass('active btn-success');
	 }else{
		  $a('.mostraUrlExterna').show();
		 $a('#mesmoSite').removeClass('active btn-success');
		 $a('#siteExterno').addClass('active btn-success');
		 $a('.urlSiteExterno').attr("required", true);
	 }

  $a("#mesmoSite").click(function(){

  $a('#siteExterno').removeClass('active btn-success');
  $a(this).addClass('active btn-success');
  $a('.mostraUrlExterna').hide();
  $a('.urlSiteExterno').attr("required", false);
  $a('#siteProd').val(siteLocal);
  });

$a('#siteExterno').click(function(){
  $a('#mesmoSite').removeClass('active btn-success');
  $a(this).addClass('active btn-success');
  $a('.mostraUrlExterna').show();
  $a('.urlSiteExterno').attr("required", true);
  });

  $a('.urlSiteExterno').keyup(function(){
    var pegaSInicial2 = $a('#siteProd').val($a(this).val().trim());
    //$a('#eotEscolhe option[value="nao"]').attr('selected', 'selected');
  });


	$a('input[name=nomeProd]').focusout(function(){
		var nomeProd = $a(this).val();
		var semEspaco = $a.trim(nomeProd);
		$a(this).val(semEspaco);
	});

	$a('input[name=siteProd]').focusout(function(){
		var siteProd = $a(this).val();
		var semEspacoSite = $a.trim(siteProd);
		$a(this).val(semEspacoSite);
	});

	$a('input[name=redProd]').focusout(function(){
		var redProd = $a(this).val();
		var semEspacoSiteredProd = $a.trim(redProd);
		$a(this).val(semEspacoSiteredProd);
	});

	$a('input[name=redProd]').keyup(function(){
			$a(this).val($a(this).val().trim());

	});

	$a('input[name=siteProd]').keyup(function(){
			$a(this).val($a(this).val().trim());

	});

	$a('input[name=packProd]').keyup(function(){
			$a(this).val($a(this).val().trim());

	});


		$a('input[name=idProd]').keyup(function(){
			$a(this).val($a(this).val().trim());

	});

	$a('input[name=nomeOff]').keyup(function(){
			$a(this).val($a(this).val().trim());
	});



	$a('input[name=descOff]').keyup(function(){
			$a(this).val($a(this).val().trim());
	});


	$a("#TipoProdItem").change(function(){

		var valorItem = $a(this).val();
		if(valorItem == 'hotmart'){
			$a('#itemHotmart').show();
    }else{
      $a('#itemHotmart').hide();
    }

    if(valorItem == 'pagseguro'){
			$a('#redirecionamentoCliente').show();
    }else{
      $a('#redirecionamentoCliente').hide();
    }

	});

	$a("#manterCliente").click(function(){

		$a('#excluirCliente').removeClass('active btn-danger');
		$a(this).addClass('active btn-success');
		$a('#clienteNoSite').val('manterCliente')

	});

	$a("#excluirCliente").click(function(){

		$a('#manterCliente').removeClass('active btn-success');
		$a(this).addClass('active btn-danger');
		$a('#clienteNoSite').val('excluirCliente')

	});

	$a("#PermitirUserFree").click(function(){

		$a('#NaoPermitirUserFree').removeClass('active btn-success');
		$a(this).addClass('active btn-success');
		$a('#permitirUsu').show();
		$a('#userGratis').val('Permitir')

		//show(); -> Mostra Elemento
		//hide(); -> Oculta Elemento


		});

	$a('#NaoPermitirUserFree').click(function(){
		$a('#PermitirUserFree').removeClass('active btn-success');
		$a(this).addClass('active btn-success');
		$a('#permitirUsu').hide();
		$a('#userGratis').val('naoPermitir')

		});



		//Pagina Pos Compra
		$a("#PermitirPosCompra").click(function(){

		$a('#NaoPermitirPosCompra').removeClass('active btn-success');
		$a(this).addClass('active btn-success');
		$a('#permitirPos').show();
		$a('#posCompra').val('Ativar')

		//show(); -> Mostra Elemento
		//hide(); -> Oculta Elemento


		});

	$a('#NaoPermitirPosCompra').click(function(){
		$a('#PermitirPosCompra').removeClass('active btn-success');
		$a(this).addClass('active btn-success');
		$a('#permitirPos').hide();
		$a('#posCompra').val('naoAtivar')

		});

		//EOT Time
		$a("#PermitirEOT").click(function(){

		$a('#NaoPermitirEOT').removeClass('active btn-success');
		$a(this).addClass('active btn-success');
		$a('#permitirEOTTime').show();
		$a('#eotCli').val('Ativar')
		$a('#eotDigita').attr("required", true);

		//show(); -> Mostra Elemento
		//hide(); -> Oculta Elemento


		});

	$a('#NaoPermitirEOT').click(function(){
		$a('#PermitirEOT').removeClass('active btn-success');
		$a(this).addClass('active btn-success');
		$a('#permitirEOTTime').hide();
		$a('#eotCli').val('naoAtivar')
		$a('#eotDigita').attr("required", false);

		});


		//Funcao para Tempo EOT

		$a('#eotEscolhe').change(function(){
		var valorEscolhe = $a(this).val();
		$a('input[name=eotProd]').val(valorEscolhe);
		$a('#eotDigita').val(valorEscolhe);
		});

		$a('#eotDigita').keyup(function(){
			$a('input[name=eotProd]').val($a(this).val().trim());
			$a('#eotEscolhe option[value="nao"]').attr('selected', 'selected');
		});

		$a('#nivelProdEscolhe').change(function(){
		var valorNivelEscolhe = $a(this).val();
		//alert()
		$a('input[name=nivelProd]').val(valorNivelEscolhe);
		$a('#nivelProdDigita').val(valorNivelEscolhe);
		});

		$a('#nivelProdDigita').keyup(function(){
			$a('input[name=nivelProd]').val($a(this).val().trim());
			$a('#nivelProdEscolhe option[value="nao"]').attr('selected', 'selected');
		});

		$a('#nivelProdEscolheAg').change(function(){
		var valorNivelEscolheAg = $a(this).val();
		//alert()
		$a('input[name=nivelProdAguarda]').val(valorNivelEscolheAg);
		$a('#nivelProdDigitaAg').val(valorNivelEscolheAg);
		});

		$a('#nivelProdDigitaAg').keyup(function(){
			$a('input[name=nivelProdAguarda]').val($a(this).val().trim());
			$a('#nivelProdEscolheAg option[value="nao"]').attr('selected', 'selected');
		});


	});

</script>
