<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
global $wpdb;
$vd_pagmember = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'vd_pagmember'");
$conta_vd = count($vd_pagmember);
if($conta_vd > 0){ $datavd = unserialize($vd_pagmember); $vd_dataAtivacao = $datavd['dataAtivacao'];
$vd_dataVefificacao = $datavd['dataVefificacao']; $vd_dataFinal = $datavd['dataFinal']; $vd_key = $datavd['key'];
$vd_status = $datavd['status'];
$vd_dataBloqueio = $vd_dataFinal;
$versaophp = phpversion();
$versaophp = floatval($versaophp);

if($versaophp >= 5.5 && $versaophp <= 5.7){
	$vicon = 'ok text-success';
	$versaophp = strval($versaophp);
	$versaophp = phpversion().' - Sua versão do PHP é compatível com esta versão do pagmember.';
	}else{
		$versaophp = strval($versaophp);
	$vicon = 'remove text-danger';
	$versaophp = phpversion().' - Requer versão 5.6, para funcionar Corretamente. Envie um email para sua hospedagem pedindo para atualizar para a versão 5.6.';
		}
if($vd_status == 0){
	$statusplugin = 'Pendente - <em>Verifique se sua chave está gerada corretamente na área restrita ou se não há plugins bloqueando a ativação do pagmember.</em>';
	$sicon = 'warning-sign text-warning';
	}

if($vd_status == 1){
	$statusplugin = 'Verificado - <em>Seu Plugin está ativado Corretamente.</em>';
	$sicon = 'ok text-success';
	}

if($vd_status == 2){
	$statusplugin = 'Bloqueado - <em>Plugin Bloqueado, devido a um erro de chave. Verifique se a chave está gerada corretamente no site de compra.</em>';
	$sicon = 'remove text-danger';
	}


}
function converteData($data){
       if (strstr($data, "/")){//verifica se tem a barra /
           $d = explode ("/", $data);//tira a barra
           $rstData = "$d[2]-$d[1]-$d[0]";//separa as datas $d[2] = ano $d[1] = mes etc...
           return $rstData;
       }
       else if(strstr($data, "-")){
          $data = substr($data, 0, 10);
          $d = explode ("-", $data);
          $rstData = "$d[2]/$d[1]/$d[0]";
          return $rstData;
       }
       else{
           return '';
      }
}
?>


<?php
if($pg == 'status' && $pg2 == ''){





if(extension_loaded('curl') == true){
	$curlativo = 'sim';
	$cicon = 'ok text-success';
	}else{
	$curlativo = 'Não';
	$cicon = 'remove text-danger';
		}
if(ini_get('allow_url_fopen') == 1){
	$fopenativo = 'sim';
	$ficon = 'ok text-success';
	}else{
	$fopenativo = 'Não';
	$ficon = 'remove text-danger';
		}
?>
<h2>Status do Plugin <a href="https://www.youtube.com/watch?v=oIJ1uR71Ngc" target="_blank" class="btn btn btn-primary"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial</a></h2>

<table class="table table-bordered">
        <thead>
          <tr class="success">
            <th width="30%">Configura&ccedil;&otilde;es</th>
			<th width="60%">Status</th>
			<th></th>
          </tr>
        </thead>
        <tbody>

       <?php
	   $iconok = 'ok text-success';
	   $iconof = 'remove text-danger';


	   $vdicon =  $iconok;
	   $vd_dataAtivacaoicon =  $iconok;
	   $vd_dataVefificacaoicon =  $iconok;
	   $vd_dataBloqueioicon = 'warning-sign text-warning';
       if($vd_key == ''){
		   $vd_key = 'Não Ativado';
		   $vdicon = $iconof;
		   }

		if($vd_dataAtivacao == ''){
		   $vd_dataAtivacao = 'Não Ativado';
		   $vd_dataAtivacaoicon = $iconof;
		   }else{
			$vd_dataAtivacao = converteData($vd_dataAtivacao);
		   }

		   if($vd_dataVefificacao == ''){
		   $vd_dataVefificacao = 'Não Ativado';
		   $vd_dataVefificacaoicon = $iconof;
		   }else{
			$vd_dataVefificacao = converteData($vd_dataVefificacao);
			   }
			if($vd_dataBloqueio == ''){
		   $vd_dataBloqueio = 'Plugin Bloqueado';
		   $vd_dataBloqueioicon = $iconof;
		   }else{
			$vd_dataBloqueio = converteData($vd_dataBloqueio);
			   }


	   ?>
          <tr>
            <td><strong>Vers&atilde;o do pagmember:</strong></td>
            <td><?php echo $versaoPlugin; ?></td>
			<td class="text-center"><span class="glyphicon glyphicon-ok text-success"></span></td>
          </tr>

		  <tr>
            <td><strong>Chave de Ativa&ccedil;&atilde;o:</strong></td>
            <td><?php echo $vd_key; ?></td>
			<td class="text-center"><span class="glyphicon glyphicon-<?php echo $vdicon; ?>"></span></td>
          </tr>

		  <tr>
            <td ><strong>Data de Ativa&ccedil;&atilde;o:</strong></td>
            <td><?php echo $vd_dataAtivacao; ?></td>
			<td class="text-center"><span class="glyphicon glyphicon-<?php echo $vd_dataAtivacaoicon; ?>"></span></td>
          </tr>

		  <tr>
            <td><strong>Data da Verifica&ccedil;&atilde;o:</strong></td>
            <td><?php echo $vd_dataVefificacao; ?></td>
			<td class="text-center"><span class="glyphicon glyphicon-<?php echo $vd_dataVefificacaoicon; ?>"></span></td>
          </tr>

          <?php
          if($vd_status != 1){
		  ?>

           <tr>
            <td><strong>Data do Bloqueio caso não seja ativado:</strong></td>
            <td><?php echo $vd_dataBloqueio; ?></td>
			<td class="text-center"><span class="glyphicon glyphicon-<?php echo $vd_dataBloqueioicon; ?>"></span></td>
          </tr>

          <?php
		  }
		  ?>

		  <tr>
            <td><strong>Status da Chave:</strong></td>
            <td><?php echo $statusplugin; ?></td>
		    <td class="text-center"><span class="glyphicon glyphicon-<?php echo $sicon; ?>"></span></td>
          </tr>

		  <tr>
            <td><strong>CURL Ativo:</strong></td>
            <td><?php echo $curlativo; ?></td>
		    <td class="text-center"><span class="glyphicon glyphicon-<?php echo $cicon; ?>"></span></td>
          </tr>

		   <tr>
            <td><strong>Função 'allow_url_fopen' Ativo:</strong></td>
            <td><?php echo $fopenativo; ?></td>
		    <td class="text-center"><span class="glyphicon glyphicon-<?php echo $ficon; ?>"></span></td>
          </tr>

          <tr>
            <td><strong>Versão do PHP: </strong></td>
            <td><?php echo $versaophp; ?></td>
		    <td class="text-center"><span class="glyphicon glyphicon-<?php echo $vicon; ?>"></span></td>
          </tr>



        </tbody>
      </table>

<?php
};
?>
