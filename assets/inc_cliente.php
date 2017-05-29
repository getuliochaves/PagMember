<?php
global $wpdb;
$TipoPagamento = get_the_author_meta('TipoPagamentoPagMember', $user->ID );
$IDTransacao = get_the_author_meta('IDTransacaoPagMember', $user->ID );
$PrecoPagMember = get_the_author_meta('PrecoPagMember', $user->ID );	
echo '<div style="margin:25px 0 25px 0; height:1px; line-height:1px; background:#CCCCCC;"></div>';	
echo '<h3>Informações de Pagamento PagMember</h3>';
echo'
<table class="form-table">
 
        <tr>
            <th><label for="TipoPagamento">Tipo de Pagamento</label></th>
 
            <td>
                <input type="text" name="TipoPagamento" id="TipoPagamento" value="'.$TipoPagamento.'" class="regular-text" /><br />
                <span class="description">Tipo de Pagamento Efetuado pelo Usuário.</span>
            </td>
        </tr>
 
        <tr>
            <th><label for="IDTransacao">ID da Transação:</label></th>
 
            <td>
                <input type="text" name="IDTransacao" id="IDTransacao" value="'.$IDTransacao.'" class="regular-text" /><br />
                <span class="description">ID da Transação do Pagamento Efetuado pelo Usuário.</span>
            </td>
        </tr>   
		
		<tr>
            <th><label for="PrecoPagMember">Preço do Produto:</label></th>
 
            <td>
                <input type="text" name="PrecoPagMember" id="PrecoPagMember" value="R$ '.$PrecoPagMember.'" class="regular-text" /><br />
                <span class="description">Preço do Produto Pago pelo Usuário.</span>
            </td>
        </tr>    
 
    </table>

';
?>