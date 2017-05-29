<?php
global $wpdb;
$tipoToken = $_GET['tipoToken'];
$pg  = $_GET['pg'];
$formasNotificacao = array('PagSeguro','Hotmart','Eduzz','Monetizze');
?>
<h2>Configurações <?php echo $tipoToken; ?> <a href="https://www.youtube.com/watch?v=vwPUkm6XWs4" target="_blank" class="btn btn btn-primary"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial</a></h2>

<br>

<?php
if($pg == 'configuracoes' && $pg2 == ''){
	echo '<div class="alert alert-success">Clique nos botões abaixo, para Realizar as configurações dos Processadores de pagamento.</div>';
}
?>

<?php
foreach ($formasNotificacao as $nt) {
?>
<a href="admin.php?page=pagmember&pg=<?php echo $pg; ?>&pg2=config&pg3=edit&tipoToken=<?php echo $nt; ?>" class="btn btn-primary btn-sm " value="Verificar Formulário"><strong>Alterar Configurações <?php echo $nt; ?></strong></a>
<?php
};
?>
<a href="admin.php?page=pagmember&pg=<?php echo $pg; ?>&pg2=config&pg3=geral" class="btn btn-primary btn-sm" value="Verificar Formulário"><strong>Configurações Gerais</strong></a>
<br>
<br>
<br>
<?php
if($pg = 'configuracoes' && $pg2 == 'config'){
	include_once('configuracoes/confignovo.php');
}
?>
