<?php
global $wpdb;
$pg = 'notificacoes';
if($pg == 'notificacoes' && $pg2 == ''){
?>
<h2>Links de Notificações <a href="https://www.youtube.com/watch?v=WOduB8oRTys" target="_blank" class="btn btn btn-primary"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial</a></h2>
<?php
$formasNotificacao = array('PagSeguro','Hotmart','Eduzz','Monetizze');
?>

<?php if(isset($_GET['atualizou'])){
  $tipoMetodoGravado = $_GET['tipoMetodo'];
?>
<div class="alert alert-success" style="width:93%;" role="alert">

<h4><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
<span class="sr-only">Info:</span>
<?php
if($_GET['atualizou'] == 'removeu'){
?>

Notificação do <?php echo $tipoMetodoGravado; ?> Excluida com Sucesso. </h4>

<p>
  Hummm!!! A URL de Notificação foi Excluida com Sucesso.
</p>

<?php
}else{
?>

Notificação do <?php echo $tipoMetodoGravado; ?> Gravada com Sucesso. </h4>

<p>
  Oba!!! A URL de Notificação foi Atualizada com Sucesso. Clique no Botão <strong>Testar</strong> para Verificar se estão funcionando Corretamente...
</p>

<?php
};
?>

</div>
<?php
};
 ?>

<table class="table">
        <thead>
          <tr>
            <th>Tipo Notificação</th>
            <th>Link Notificação</th>
            <th>Onde Colocar</th>
            <th>Operações</th>
          </tr>
        </thead>
        <tbody>
          <?php


          foreach ($formasNotificacao as $notificacao) {

            $nomeNot = 'notificacaoPagMember#'.$notificacao;
            $idN = $wpdb->get_var("SELECT option_id FROM $wpdb->options WHERE option_name = '$nomeNot'");
            $linkNot = 'notificacao'.strtolower($notificacao);




            if($idN != '' or $idN != null){
              $urlNotFinal = get_site_url().'/'.$linkNot.'/';
              $linkAcao = '
              <a href="admin.php?page=pagmember&pg='.$pg.'&pg2=notifica&pg3=del&meta_id='.$idN.'&url='.$linkNot.'&tipoMetodo='.$notificacao.'" class="btn btn btn-warning">Atualizar</a>
              <a href="admin.php?page=pagmember&pg='.$pg.'&pg2=notifica&pg3=del&meta_id='.$idN.'&url='.$linkNot.'&tipoMetodo='.$notificacao.'&remover=sim" class="btn btn btn-danger">Excluir</a>
              <a href="'.$urlNotFinal.'index.php?teste=sim" target="_blank" class="btn btn btn-success">Testar</a> ';


              switch ($notificacao) {
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

            }else{
              $linkAcao = '<a href="admin.php?page=pagmember&pg=notificacoes&pg2=notifica&pg3=novo&tipoMetodo='.$notificacao.'&acao=gravar" class="btn btn btn-primary">Cadastrar</a>';
              $urlNotFinal = '';
            }

          ?>
          <tr>
            <td><?php echo $notificacao;?></td>
             <td><?php echo $urlNotFinal; ?></td>
             <td><a href="<?php echo $urlIn; ?>" target="_blank">Clique para Integrar</a></td>
            <td>
              <?php echo $linkAcao; ?>
            </td>
          </tr>

          <?php
          };
          ?>

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
          <div class="alert alert-danger" style="width:93%;" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ops... Versão da Notificação <?php echo $tipoMetodo; ?> desatualizada... Vamos Atualizar as URL de Notificações <?php echo $tipoMetodo; ?>, Aguarde...</div>
<meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=notificacoes&pg2=notifica&pg3=del&meta_id=<?php echo $idN; ?>&url=<?php echo $pasta; ?>&tipoMetodo=<?php echo $tipoMetodo; ?>">

                <?php

          			}



          		}else{

          ?>
          <div class="alert alert-danger" style="width:93%;" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ops... Arquivo de Notificação <?php echo $tipoMetodo; ?> não existe...  Vamos Atualizar as URL de Notificações <?php echo $tipoMetodo; ?>, Aguarde...</div>
          <meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=notificacoes&pg2=notifica&pg3=del&meta_id=<?php echo $idN; ?>&url=<?php echo $pasta; ?>&tipoMetodo=<?php echo $tipoMetodo; ?>">


          <?php
          		}

          	}

           //echo $pasta;


          };



          //FIM Verificacao de URL de Notificação Atualizada ou Não

           ?>

        </tbody>
      </table>




        <?php
};
if($pg == 'notificacoes' && $pg2 == 'notifica'){
switch($pg3){
	case $pg3;
	include_once($pg.'/'.$pg2.$pg3.'.php');
};
};
?>
