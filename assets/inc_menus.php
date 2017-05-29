<?php
global $wpdb;
?>        
<li <?php if($pg == 'produtos' or $pg == ''){ ?>class="active" <?php }; ?>><a href="admin.php?page=pagmember&pg=produtos">Produtos</a></li>  
<li <?php if($pg == 'envios'){ ?>class="active" <?php }; ?>><a href="admin.php?page=pagmember&pg=envios">Formas de Envio</a></li>  
<li <?php if($pg == 'notificacoes'){ ?>class="active" <?php }; ?>><a href="admin.php?page=pagmember&pg=notificacoes">URL Notificações</a></li>
<li <?php if($pg == 'configuracoes'){ ?>class="active" <?php }; ?>><a href="admin.php?page=pagmember&pg=configuracoes">Configurações</a></li>
<li <?php if($pg == 'status'){ ?>class="active" <?php }; ?>><a href="admin.php?page=pagmember&pg=status">Status</a></li>  
<li <?php if($pg == 'relatorios'){ ?>class="active" <?php }; ?>><a href="admin.php?page=pagmember&pg=relatorios">Relatórios</a></li>  
<li <?php if($pg == 'transacoes'){ ?>class="active" <?php }; ?>><a href="admin.php?page=pagmember&pg=transacoes">Transações</a></li> 
<li <?php if($pg == 'reset'){ ?>class="active" <?php }; ?>><a href="admin.php?page=pagmember&pg=reset">Resetar Plugin</a></li>  