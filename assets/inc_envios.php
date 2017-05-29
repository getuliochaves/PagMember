<?php
global $wpdb;
if($pg == 'envios' && $pg2 == ''){
?>
<h2>Formas de Envio</h2>
<?php



$listaForm = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key like '%metodoEnvioPag%'");
//var_dump($listaForm);

$contaForm = count($listaForm);
?>
<?php
if($contaForm > 0){
?>

<div class="alert alert-success">
<h4>Cadastre novas formas para enviar o acesso para seu cliente, clicando nos botões abaixo.</h4>



<div class="container-fluid">
	<div class="row">
		<div class="col-md-3">
			<a href="admin.php?page=pagmember&pg=envios&pg2=envio&pg3=novo&tipoMetodo=SemAutenticacao&acao=gravar" class="btn btn-block btn-primary btn-sm">
				Cadastrar Envio pelo Wordpress
			</a>
		</div>
		<div class="col-md-3">

        <a href="admin.php?page=pagmember&pg=envios&pg2=envio&pg3=novo&tipoMetodo=ServidorSMTP&acao=gravar" class="btn btn-block btn-primary btn-sm">
				Cadastrar Envio SMTP Hospedagem
			</a>

		</div>
		<div class="col-md-3">

        <a href="admin.php?page=pagmember&pg=envios&pg2=envio&pg3=novo&tipoMetodo=AutoResponder&acao=gravar" class="btn btn-block btn-primary btn-sm">
				Cadastrar Envio AutoResponder
			</a>

		</div>
		<div class="col-md-3">

        <a href="admin.php?page=pagmember&pg=envios&pg2=envio&pg3=novo&tipoMetodo=MailJet&acao=gravar" class="btn btn-block btn-primary btn-sm">
				Cadastrar Envio SMTP MailJet
			</a>

		</div>
	</div>
</div>

</div>


<table class="table table-bordered">
        <thead>
          <tr class="success">
            <th>ID do Metodo</th>
            <th>Nome do Metodo</th>
            <th>Tipo de Metodo</th>
            <th>Operações</th>
          </tr>
        </thead>
        <tbody>




        <?php
		foreach($listaForm as $linhaEnvio){
	$envioMetaId = $linhaEnvio->meta_id;
	$envioPag = $linhaEnvio->meta_value;
	$envioPag2 = unserialize($envioPag);
	$tipoMetodo = $envioPag2['tipoMetodo'];
	if($tipoMetodo == 'SemAutenticacao'){
		$tipoParaEnviar = 'EnvioWordpress';
		}else{
		$tipoParaEnviar = 	$tipoMetodo;
		}
		?>
          <tr>
            <td><?php echo $envioMetaId;?></td>
            <td><?php echo $envioPag2['nomeMetodo'];?></td>
             <td><?php echo $tipoParaEnviar;?></td>

            <td><a href="admin.php?page=pagmember&pg=envios&pg2=envio&pg3=novo&tipoMetodo=<?php echo $tipoMetodo; ?>&acao=edit&meta_id=<?php echo $envioMetaId; ?>" class="btn btn btn-primary">Editar</a>
            <a href="admin.php?page=pagmember&pg=envios&pg2=envio&pg3=del&meta_id=<?php echo $envioMetaId;?>" class="btn btn btn-danger">Excluir</a>
            <?php
            if($tipoMetodo != 'AutoResponder'){
            ?>
             <a href="admin.php?page=pagmember&pg=envios&pg2=envio&pg3=teste&meta_id=<?php echo $envioMetaId;?>" class="btn btn btn-success">Testar</a>
            <?php
            };
             ?>
            </td>
          </tr>

      <?php
		};
	  ?>
        </tbody>
      </table>




<?php
// Fim Conta Notificação
}
?>

<div class="row">
  <!-- Inicio Painel accordion -->
<div class="panel-group" id="accordion">
  <!-- Inicio Coluna 1 -->
  <div class="col-md-12" >
    <!-- Primeiro Panel -->
    <div class="panel panel-primary">
        <div class="panel-heading">
             <h4 class="panel-title teste"
                 data-toggle="collapse"
                 data-target="#collapseOne">
                 Vídeos Tutoriais Sobre as Formas de Envio (<span class="ocultar">Clique para Ocultar os Detalhes</span>)
             </h4>
        </div>



        <div class="panel-collapse formasEnvio99" id="collapseOne">
            <div class="col-md-6 " >

          <h4>Criando Email de Suporte para Envio  <a href="https://www.youtube.com/watch?v=ca2ncAcNF4E" target="_blank" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial</a></h4>
          <h4>Criando Conta MailJet e Validando Domínio <a href="https://www.youtube.com/watch?v=z8bGySghzf4" target="_blank" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial</a></h4>
          <h4>Cadastrando SMTP maijet no seu Wordpress <a href="https://www.youtube.com/watch?v=Nj3hlXPhtaw" target="_blank" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial</a></h4>
          <h4>Cadastrando Envio MailJet <a href="https://www.youtube.com/watch?v=bMMH1V3TTx0" target="_blank" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial</a></h4>





            </div>

              <div class="col-md-6" >
                <h4>Cadastrando Envio SMTP da Hospedagem <a href="https://www.youtube.com/watch?v=hdy0xH9HcgE" target="_blank" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial</a></h4>
                <h4>Cadastrando Envio MailChimp <a href="https://www.youtube.com/watch?v=DrXGf3kmGBE" target="_blank" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial</a></h4>
                <h4>Cadastrando Envio GetResponse <a href="https://www.youtube.com/watch?v=Kq2ebJs25lI" target="_blank" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial</a></h4>

              </div>
        </div>


    </div><!-- Fim Panel -->


  </div>   <!-- Fim Coluna 1 -->

</div> <!-- FIm Painel accordion -->

</div> <!-- Fim da Linha -->

<?php
};
if($pg = 'envios' && $pg2 == 'envio'){
switch($pg3){
	case $pg3;
	include_once('envios/envio'.$pg3.'.php');
}
?>
 <?php
};
 ?>
<style>
.panel-heading{cursor: pointer;}
.formasEnvio99 h4{
  font-size: 16px !important;
}
</style>
<script type="text/javascript">
$a = jQuery.noConflict();
$a(document).ready(function(){
  var ativa = false;
  $a('#collapseOne').show();


  $a('.teste').click(function(){
    if(ativa == true){
      $a('#collapseOne').show();
      $a('.ocultar').html('Clique para Ocultar os Detalhes');
      ativa = false;
    }else{
      ativa = true;
      $a('#collapseOne').hide();
      $a('.ocultar').html('Clique para Mostrar os Detalhes');
    }
  });
});
</script>
