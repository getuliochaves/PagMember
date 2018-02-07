<?php
global $wpdb;
$meta_id = $_GET['meta_id'];
$urlNot = $_GET['url'];
$tipoMetodo = $_GET['tipoMetodo'];
$remover = $_GET['remover'];


$Dir = ABSPATH.$urlNot;

$dir = ABSPATH.$urlNot;
//var_dump($dir);

removeTreeRec($dir);

function removeTreeRec($rootDir)
{
    if (!is_dir($rootDir))
    {
        return false;
    }
    if (!preg_match("/\\/$/", $rootDir))
    {
        $rootDir .= '/';
    }


    $dh = opendir($rootDir);

    while (($file = readdir($dh)) !== false)
    {
        if ($file == '.'  ||  $file == '..')
        {
            continue;
        }


        if (is_dir($rootDir . $file))
        {
            removeTreeRec($rootDir . $file);
        }

        else if (is_file($rootDir . $file))
        {
            unlink($rootDir . $file);
        }
    }

    closedir($dh);

    rmdir($rootDir);

    return true;
}

/*
unlink(ABSPATH.$urlNot.'/PHPMailer/class.phpmailer.php');
unlink(ABSPATH.$urlNot.'/PHPMailer/class.pop3.php');
unlink(ABSPATH.$urlNot.'/PHPMailer/class.smtp.php');
rmdir(ABSPATH.$urlNot.'/PHPMailer');
unlink(ABSPATH.$urlNot.'/index.php');
if(file_exists(ABSPATH.$urlNot.'/error_log')){
	unlink(ABSPATH.$urlNot.'/error_log');
}
*/
//rmdir(ABSPATH.$urlNot);
$deltaNot = $wpdb->query("DELETE FROM $wpdb->options WHERE option_id = '$meta_id'");

if($remover == 'sim'){
?>
<h3>Excluindo URL Notificação <?php echo $tipoMetodo; ?></strong></h3>
<div class="alert alert-success"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Estamos Excluindo a URL Notificação <?php echo $tipoMetodo; ?>, Aguarde...</div>
<meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=notificacoes&atualizou=removeu&tipoMetodo=<?php echo $tipoMetodo; ?>">
<?php
}else{
?>
<h3>Atualizando URL Notificação <?php echo $tipoMetodo; ?></strong></h3>
<div class="alert alert-success"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Estamos atualizando a URL Notificação <?php echo $tipoMetodo; ?>, Aguarde...</div>
<meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=notificacoes&pg2=notifica&pg3=novo&tipoMetodo=<?php echo $tipoMetodo; ?>&acao=gravar">
<?php
};
?>
