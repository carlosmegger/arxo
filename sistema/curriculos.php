<?
include("include-topo.php");
$path = '../arquivos/curriculos/';
?>
<div id="conteudo">
	<div class="topo">
		<h1>Currículos</h1>
		<div><a href="<?=$page?>.php" class="voltar">&laquo; voltar</a></div>
	</div>
	<? if($acao == ''){ ?>
		<div class="filtro">
        	<span>Idioma:</span>
            <span>
            	<select name="idioma" id="idioma">
                	<option value="0">Selecione</option>
                	<option value="br"<?=($idioma == 'br') ? ' selected="selected"' : '' ?>>Português</option>
                	<option value="en"<?=($idioma == 'en') ? ' selected="selected"' : '' ?>>Inglês</option>
                	<option value="es"<?=($idioma == 'es') ? ' selected="selected"' : '' ?>>Espanhol</option>
                </select>
            </span>

			<span>Busca por texto:</span>
			<span>
            	<input type="text" name="busca" id="busca" class="contato" value="<?=$busca?>" />
			</span>
			<span>
				<input type="submit" name="filtro-curriculos" id="filtro-curriculos" value="OK" />
                <? if($filtro == true){ ?><a href="<?=$page?>.php"><img src="../img/sistema/ico-cancelar.png" alt="limpar filtro" class="vimg" /></a><? } ?>
            </span>
        </div>
    	<?
		if($filtro == true){
			$w = " where ";
			if($idioma != ''){
				$cond .= $w." idioma = '".$idioma."'";
				$w = " and ";
			}
			if($busca != ''){
				$cond .= $w." (nome like '%".$busca."%' or email like '%".$busca."%' or telefone like '%".$busca."%') ";
			}
		}

		$paginacao = new Paginacao(CURRICULOS," ".$cond." order by data desc","",$pagina,20);
		$query = mysql_query("select * from ".CURRICULOS." ".$cond." order by data desc limit ".$paginacao->getInicio().",20");

		if(mysql_num_rows($query) == 0){ ?>
			<p>Não há currículos para exibir!</p>
		<? } else { ?>
        	<div class="listagem">
				<div class="cabecalho">
					<span class="expande">&nbsp;</span>
                    <span class="idioma">Idioma</span>
                    <span class="nome">Nome</span>
					<span class="email">E-mail</span>
                    <span class="telefone">Telefone</span>
                    <span class="data">Enviado em</span>
                    <span class="remover">Remover</span>
                    <div class="clear"></div>
                </div>
                <div>
					<? while($rs = mysql_fetch_assoc($query)){ ?>
                        <div class="caixa-curriculo fecha">
                            <span class="expande"></span>
                            <span class="idioma"><img src="../img/sistema/<?=$rs['idioma']?>.png" /></span>
                            <span class="nome"><?=$rs['nome']?></span>
                            <span class="email"><a href="mailto:<?=$rs['email']?>"><?=$rs['email']?></a></span>
                            <span class="telefone"><?=$rs['telefone']?></span>
                            <span class="data"><?=converteData($rs['data'],'d/m/Y H:i:s')?></span>
                            <span class="remover"><a href="javascript:void(0)" onClick="remover(<?=$rs['idcurriculo']?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>
    
							<div class="caixa-oculta">
								<div>
                                	<p><strong>Nome:</strong> <?=$rs['nome']?></p>
									<p><strong>E-mail:</strong> <a href="mailto:<?=$rs['email']?>"><?=$rs['email']?></a></p>
                                    <p><strong>Telefone:</strong> <?=$rs['telefone']?></p>
                                    <p><strong>Arquivo:</strong> <a href="<?=$path.$rs['arquivo']?>" target="_blank"><?=$rs['arquivo']?></a></p>
                                    <p><strong>Mensagem:</strong> <?=nl2br($rs['mensagem'])?></p>
								</div>
							</div>
						</div>
					<?
					}
					?>
				</div>
			</div>
			<?
			if($paginacao->temPaginacao()){
				echo '<div class="paginacao">';
				echo $paginacao->getPaginacao($page.'.php');
				echo '</div>';
			}
		}
	}
	elseif($acao == 'remover'){
		if(is_numeric($id)){
			
			$sql = mysql_fetch_assoc(mysql_query("select * from ".CURRICULOS." where idcurriculo = '".$id."'"));
			if(is_file($path.$sql['arquivo'])) unlink($path.$sql['arquivo']);

			deletar(CURRICULOS,"where idcontato = ".$id);
			
		}
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
	}
	?>	
</div>
<? include("include-rodape.php"); ?>