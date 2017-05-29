<?php
global $wpdb;
if($pg == 'produtos' && $pg2 == ''){
?>
<h2>Produtos Cadastrados</h2>

<?php
$listaPro = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key like '%ProdPagMember%'");
//var_dump($listaPro);
$contaProd = count($listaPro);


?>
<?php
if($contaProd > 0){
?>
<table class="table">
        <thead>
          <tr>
            <th>ID Produto</th>
            <th>Nome do Produto</th>
            <th>Tipo de Produto</th>
            <th>Configurações</th>
          </tr>
        </thead>
        <tbody>

        <?php
		foreach($listaPro as $linhaproduto){
	$prodMetaId = $linhaproduto->meta_id;
	$ProdPag = $linhaproduto->meta_value;
	$nomeCompletoProd = $linhaproduto->meta_key;
	$ProdPag2 = unserialize($ProdPag);
	$nomeProd = $ProdPag2['nomeProd'];
	$idProd = $ProdPag2['idProd'];
	$verificaNome = explode('*idProd#',$nomeCompletoProd);
	$contaNome = count($verificaNome);
	if($contaNome < 2){
		$nomeCompletoProd = $nomeCompletoProd.'*idProd#'.$idProd;
		$grava = $wpdb->query("UPDATE $wpdb->postmeta SET meta_key = '$nomeCompletoProd' WHERE meta_id = '$prodMetaId'");
		}

	$descOff = $ProdPag2['descOff'];
	$tipoProd = $ProdPag2['tipoProd'];
	if($tipoProd == 'hotmart' && $descOff != ''){
		$nomeProd = $nomeProd.'<strong> ['.$descOff.']</strong>';
		}

		?>
          <tr>
            <td><?php echo $ProdPag2['idProd'];?></td>
            <td><?php echo $nomeProd;?></td>
             <td><?php echo $ProdPag2['tipoProd'];?></td>
            <td><a href="admin.php?page=pagmember&pg=produtos&pg2=prod&pg3=edit&prodMetaId=<?php echo $prodMetaId;?>" class="btn btn btn-primary">Editar</a>
            <a href="admin.php?page=pagmember&pg=produtos&pg2=prod&pg3=del&meta_id=<?php echo $prodMetaId;?>" class="btn btn btn-danger">Excluir</a>
            <a href="admin.php?page=pagmember&pg=produtos&pg2=prod&pg3=dup&meta_id=<?php echo $prodMetaId;?>&nomeProd=<?php echo $nomeProd ;?>" class="btn btn btn-warning">Duplicar</a>
            <a href="admin.php?page=pagmember&pg=produtos&pg2=prod&pg3=teste&meta_id=<?php echo $prodMetaId;?>&nomeProd=<?php echo $nomeProd ;?>" class="btn btn btn-success">Testar</a>
            </td>
          </tr>

      <?php
		};
	  ?>
        </tbody>
      </table>


<?php
// Fim Conta Notificação
}else{
$msgnot = 'Você não possui nenhuma Produto Criado. Crie um Produto, clicando nos botões abaixo.';
?>
<div class="alert alert-success"><?php echo $msgnot; ?></div>
<?php
};
?>


<a href="admin.php?page=pagmember&pg=produtos&pg2=prod&pg3=novo" class="btn btn-primary" value="Verificar Formulário">Cadastrar Novo Produto</a>




<?php
};
if($pg = 'produtos' && $pg2 == 'prod'){
switch($pg3){
	case $pg3;
	include_once('produtos/prod'.$pg3.'.php');
}
?>
 <?php
};
 ?>
