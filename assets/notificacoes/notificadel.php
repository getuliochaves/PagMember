<?php
global $wpdb;
$meta_id = $_GET['meta_id'];
$urlNot = $_GET['url'];



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

?>

<h3>Excluindo Notificação </strong></h3>
<div class="alert alert-success"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Notificação Excluida com Sucesso. Redirecionando, Aguarde...</div>

<meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=notificacoes">
