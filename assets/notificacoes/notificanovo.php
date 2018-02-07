<?php
global $wpdb;
$acao = $_GET['acao'];
$tipoMetodo = $_GET['tipoMetodo'];
$nomeNot = 'notificacaoPagMember#'.$tipoMetodo;
$nomeMinusculo = strtolower($tipoMetodo);
$PegNot = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = '$nomeNot'");
$diretorio = ABSPATH.$pastanotificacao;
//Funcao Copia Diretorio
function copyr($source, $dest)
{
   // COPIA UM ARQUIVO
   if (is_file($source)) {
      return copy($source, $dest);
   }

   // CRIA O DIRETÓRIO DE DESTINO
   if (!is_dir($dest)) {
      mkdir($dest);
    //  echo "DIRET&Oacute;RIO $dest CRIADO<br />";
   }

   // FAZ LOOP DENTRO DA PASTA
   $dir = dir($source);
   while (false !== $entry = $dir->read()) {
      // PULA "." e ".."
      if ($entry == '.' || $entry == '..') {
         continue;
      }

      // COPIA TUDO DENTRO DOS DIRETÓRIOS
      if ($dest !== "$source/$entry") {
         copyr("$source/$entry", "$dest/$entry");
         //echo "COPIANDO $entry de $source para $dest <br />";
      }
   }

   $dir->close();
   return true;
}

if($PegNot == null && $acao == 'gravar'){
//$nomeRetorno = 'inc_retorno_'.$nomeMinusculo;

$pastanotificacao = 'notificacao'.$nomeMinusculo;
$diretorioDestino = ABSPATH.$pastanotificacao.'/';
$diretorioInicial = ABSPATH.'wp-content/plugins/PagMember/scripts/'.$pastanotificacao;
$dIVersao = ABSPATH.'wp-content/plugins/PagMember/scripts/versao.php';
$dFVersao = $diretorioDestino.'/versao.php';


$destino = '../copia/';
$diretorio = '../scripts/';
copyr($diretorioInicial,$diretorioDestino);

$inicioMailjet = ABSPATH.'wp-content/plugins/PagMember/scripts/Mailjet.zip';
$destinoMailjet = $diretorioDestino.'Mailjet.zip';

if(!file_exists($dFVersao)){
  copy($dIVersao, $dFVersao);
};




if(!file_exists($destinoMailjet)){
$zip = new ZipArchive;
$zip->open($inicioMailjet);
if($zip->extractTo($diretorioDestino) == TRUE){

}
$zip->close();
}

$grava = $wpdb->insert($wpdb->options, array('option_name' => $nomeNot,'option_value' => $pastanotificacao));
?>

<h3>Criando Notificação <?php echo $tipoMetodo; ?></strong></h3>
<div class="alert alert-success"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Notificação <?php echo $tipoMetodo; ?> Criada com Sucesso. Redirecionando, Aguarde...</div>

<meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=notificacoes&atualizou=sim&tipoMetodo=<?php echo $tipoMetodo; ?>">
<?php
}
else{
?>

<h3>Erro ao Criar Notificação </strong></h3>
<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Você já possui Notificação do <?php echo $tipoMetodo; ?> Criada. Exclua esta Notificação e Crie Novamente. Redirecionando, Aguarde...</div>

<meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=notificacoes">

<?php
}
?>
