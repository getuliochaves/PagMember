<?php
global $wpdb;
$pg = 'notificacoes';
if($pg == 'notificacoes' && $pg2 == ''){
?>
<h2>Links de Notificações <a href="https://www.youtube.com/watch?v=WOduB8oRTys" target="_blank" class="btn btn btn-primary"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial</a></h2>
<?php
$formasNotificacao = array('PagSeguro','Hotmart','Eduzz','Monetizze');
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

            if($idN != '' or $idN != null){
              $linkNot = 'notificacao'.strtolower($notificacao);
              $urlNotFinal = get_site_url().'/'.$linkNot.'/';
              $linkAcao = '<a href="admin.php?page=pagmember&pg='.$pg.'&pg2=notifica&pg3=del&meta_id='.$idN.'&url='.$linkNot.'" class="btn btn btn-danger">Excluir</a> <a href="'.$urlNotFinal.'index.php?teste=sim" target="_blank" class="btn btn btn-success">Testar</a> ';

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
