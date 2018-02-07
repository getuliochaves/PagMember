<?php
global $wpdb;
//inicia Contanto as configurações
$contaConfigs = 0;
//Define as formas de Pagamento existentes
$formasNotificacao = array('PagSeguro','Hotmart','Eduzz','Monetizze');
$contaFormas = count($formasNotificacao);

//define um array com o dados dos tokens e apis
$dadosTK = array();

//Pega os dados dos tokens e apis
$pegaDadosToken = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'dadosToken'");
$listaToken = unserialize($pegaDadosToken);

$contaTK = 0;
//Inciio Foreach Tokens e Apis
foreach($formasNotificacao as $valorNotificacao){
$token =  $listaToken[$valorNotificacao]['token'];

if($token == null or $token == ''){
  array_push($dadosTK, $valorNotificacao);
  $contaTK++;
};
};//FIm Foreach Tokens e Apis

//Pega as Notirifações
$listaNot = $wpdb->get_results("SELECT * FROM $wpdb->options WHERE option_name like '%notificacaoPagMember#%'");
$contaNot = count($listaNot);

//Inicio Foreach Notificacoes
foreach ($listaNot as $key) {
  $pegaNome1 = $key->option_name;
  $pegaNome0 = explode('#',$pegaNome1);
  $pegaNome = $pegaNome0[1];

  if(in_array($pegaNome, $formasNotificacao)){
    $valorKey = array_search($pegaNome, $formasNotificacao);
    unset($formasNotificacao[$valorKey]);
};
};//Fim Foreach Notificacoes

//Pega os dados do EmailTeste
$pegaConfigs = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'dadosGeralPagMember'");
$pegaConfigs = unserialize($pegaConfigs);
$EmailTeste = $pegaConfigs['EmailTestes'];

//Pega os dados dos Produtos
$listaPro = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key like '%ProdPagMember%'");
$contaProd = count($listaPro);

//Pega os dados das formas de envio
$listaEnvio = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key like '%metodoEnvioPag%'");
$contaEnvios = count($listaEnvio);

if($EmailTeste == null or $EmailTeste == ''){
  $contaConfigs = $contaConfigs + 1;
  $monstraEmail = 'sim';
}

if($contaProd == 0){
  $contaConfigs = $contaConfigs + 1;
  $monstraProd = 'sim';
}

if($contaEnvios == 0){
  $contaConfigs = $contaConfigs + 1;
  $monstraEnvio = 'sim';
}

//Valida se tem configurações a serem feitas
$contaCf = 0;
if(($contaTK > 0) or ($contaNot < $contaFormas) or ($contaConfigs > 0)){
  $contaCf = 1;
}

?>

<?php
//Se existir configurações, ele mostra o painel
if($contaCf >= 1){
?>
<!-- Inicio da DIV alert -->
<div class="alert alert-warning" style="width:93%;" role="alert">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<h4><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
<span class="sr-only">Erro:</span>
Configurações Pendentes</h4>

<!-- Inicio da Linha -->
<div class="row">
  <!-- Inicio Painel accordion -->
<div class="panel-group" id="accordion">
  <!-- Inicio Coluna 1 -->
  <div class="col-md-12" >

    <?php
    //Inicio Tokens e Api
    if($contaTK > 0){
    ?>
    <!-- Primeiro Panel -->
    <div class="panel panel-danger">
        <div class="panel-heading">
             <h4 class="panel-title"
                 data-toggle="collapse"
                 data-target="#collapseOne">
                 Cadastro de API Key e Tokens (Clique para ver os Detalhes)
             </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
          <ol style="padding:10px;">
            <?php
            //Inicio Foreach Tokens e Api
            foreach($dadosTK as $TToken){
             ?>
            <li>
              <a href="admin.php?page=pagmember&pg=configuracoes&pg2=config&pg3=edit&tipoToken=<?php echo $TToken; ?>" class="">
              <strong>Token <?php echo $TToken; ?>: </strong>Cadastre o Token <?php echo $TToken; ?>, Gerado na sua conta <?php echo $TToken; ?>.
              </a>
            </li>
            <?php
          };//Fim Foreach Tokens e Api
            ?>
          </ol>
        </div>
    </div><!-- Fim Panel -->
    <?php
      };//Fim Tokens e Api

      //Inicio Notificacoes
    if($contaNot < $contaFormas){
    ?>

    <!-- Primeiro Panel -->
    <div class="panel panel-danger">
        <div class="panel-heading">
             <h4 class="panel-title"
                 data-toggle="collapse"
                 data-target="#collapse2">
                Cadastro da Página de Notificações (Clique para ver os Detalhes)
             </h4>
        </div>
        <div id="collapse2" class="panel-collapse collapse">
          <ol style="padding:10px;">
            <?php
            //Inicio Foreach Notificacoes
            foreach($formasNotificacao as $Tpagamento){
             ?>
            <li>
              <a href="admin.php?page=pagmember&pg=notificacoes&pg2=notifica&pg3=novo&tipoMetodo=<?php echo $Tpagamento; ?>&acao=gravar" class="">
              <strong>Notificação <?php echo $Tpagamento; ?>: </strong>Cadastre uma notificação <?php echo $Tpagamento; ?>, para gerar um link, que você deve colocar na sua conta <?php echo $Tpagamento; ?>.
              </a>
            </li>

            <?php
            };//Fim Foreach Notificacoes
            ?>

          </ol>
        </div>
    </div><!-- Fim Panel -->
    <?php
    };//Fim Notificacoes

      //Inicio Outras Configurações
      if($contaConfigs > 0){
    ?>
    <!-- Primeiro Panel -->
    <div class="panel panel-danger">
        <div class="panel-heading">
             <h4 class="panel-title"
                 data-toggle="collapse"
                 data-target="#collapse3">
                Outras Configurações (Clique para ver os Detalhes)
             </h4>
        </div>
        <div id="collapse3" class="panel-collapse collapse">
          <ol style="padding:10px;">
            <?php
              //Inicio Se existe email teste
              if($monstraEmail == 'sim'){
            ?>
            <li>
              <a href="admin.php?page=pagmember&pg=configuracoes&pg2=config&pg3=geral" class="">
              <strong>Email de Testes: </strong>Configure um Email para testar seu produto, antes de colocá-lo no ar.
              </a>
            </li>
            <?php
              };////Fim Se existe email teste
            ?>

            <?php
              //Inicio Se existe Forma de Envio
              if($monstraEnvio == 'sim'){
            ?>
            <li>
              <a href="admin.php?page=pagmember&pg=envios" class="">
              <strong>Forma de Envio: </strong>Cadastre uma forma de enviar os dados de acesso, para seu cliente após a compra.
              </a>
            </li>
            <?php
          }; //Fim Se existe Forma de Envio
            ?>

            <?php
            //Inicio Se existe Produto
              if($monstraProd == 'sim'){
            ?>
            <li>
              <a href="admin.php?page=pagmember&pg=produtos&pg2=prod&pg3=novo" class="">
              <strong>Produto: </strong>Cadastre um produto, com os mesmos dados do botão ou nome colocado na sua plataforma de vendas(PagSeguro,Hotmart,Monetizze,Eduzz).
              </a>
            </li>
            <?php
            };//Fim Se existe Produto
            ?>
          </ol>
        </div>
    </div><!-- Fim Panel -->

    <?php
      }; ///Fim Outras Configurações
    ?>

  </div>   <!-- Fim Coluna 1 -->

</div> <!-- FIm Painel accordion -->

</div> <!-- Fim da Linha -->

</div> <!-- Fim da DIV alert -->


<?php

//Inicia Verificacao de URL de Notificação Atualizada ou Não
//$pastas = array('Hotmart[notificacaohotmart]','notificacaopagseguro','notificacaomonetize','notificacaoeduzz');
$pastas = array('Hotmart' => 'notificacaohotmart', 'PagSeguro' => 'notificacaopagseguro', 'Monetizze' => 'notificacaomonetizze', 'Eduzz' => 'notificacaoeduzz');

foreach($pastas as $tipoMetodo => $pasta){

  //Var_dump($tipoMetodo);
  $nomeNot = 'notificacaoPagMember#'.$tipoMetodo;
  $idN = $wpdb->get_var("SELECT option_id FROM $wpdb->options WHERE option_name = '$nomeNot'");


	if(file_exists(ABSPATH.$pasta)){
		//echo '<br>pasta existe '.$pasta;

		if(file_exists(ABSPATH.$pasta.'/versao.php')){
      $mostraMSG = 'sim';
			include_once(ABSPATH.$pasta.'/versao.php');

			if($versaoScript < $versaoPlugin){
        ?>
<div class="alert alert-danger" style="width:93%;" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ops... Versão da Notificação <?php echo $tipoMetodo; ?> Desatualizada... Vamos Atualizar as URL de Notificações <?php echo $tipoMetodo; ?>, Aguarde...</div>
<meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=notificacoes&pg2=notifica&pg3=del&meta_id=<?php echo $idN; ?>&url=<?php echo $pasta; ?>&tipoMetodo=<?php echo $tipoMetodo; ?>">

      <?php

			}



		}else{

?>
<div class="alert alert-danger" style="width:93%;" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ops... Arquivo de Notificação <?php echo $tipoMetodo; ?> Não Existe... Vamos Atualizar as URL de Notificações <?php echo $tipoMetodo; ?>, Aguarde...</div>
<meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=notificacoes&pg2=notifica&pg3=del&meta_id=<?php echo $idN; ?>&url=<?php echo $pasta; ?>&tipoMetodo=<?php echo $tipoMetodo; ?>">

<?php
		}

	}

 //echo $pasta;


};



//FIM Verificacao de URL de Notificação Atualizada ou Não

 ?>

<script>
$a = jQuery.noConflict();
$a(document).ready(function(){

  var active = true;

  $a('#collapse-init').click(function () {
      if (active) {
          active = false;
          $a('.panel-collapse').collapse('show');
          $a('.panel-title').attr('data-toggle', '');
          $a(this).text('Enable accordion behavior');
      } else {
          active = true;
          $a('.panel-collapse').collapse('hide');
          $a('.panel-title').attr('data-toggle', 'collapse');
          $a(this).text('Disable accordion behavior');
      }
  });

  $a('#accordion').on('show.bs.collapse', function () {
      if (active) $a('#accordion .in').collapse('hide');
  });

});
</script>

<style>
.panel-heading{cursor: pointer;}
</style>

<?php
}; //Se existir configurações, ele mostra o painel
?>
