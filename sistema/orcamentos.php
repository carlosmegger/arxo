<? include("include-topo.php") ?>
<div id="conteudo">
	<div class="topo">
		<h1>Orçamentos</h1>
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

			<span>Produto principal:</span>
			<span>
				<select name="idproduto" id="idproduto">
					<option value="0">Selecione</option>
					<?
					$sql = mysql_query("select * from ".PRODUTOS." order by titulo asc");
					while($rs = mysql_fetch_assoc($sql)){
						$sel = ($rs['idproduto'] == $idproduto) ? ' selected="selected"' : '';
						echo '<option value="'.$rs['idproduto'].'"'.$sel.'>'.$rs['titulo'].' <em>('.$rs['idioma'].')</em></option>';
					}
					?>
				</select>
			</span>

			<span>Busca por texto:</span>
			<span>
				<input type="text" name="busca" id="busca" class="orcamento" value="<?=$busca?>" />
			</span>
			<span>
				<input type="submit" name="filtro-orcamentos" id="filtro-orcamentos" value="OK" />
				<? if($filtro == true){ ?><a href="<?=$page?>.php"><img src="../img/sistema/ico-cancelar.png" alt="limpar filtro" class="vimg" /></a><? } ?>
			</span>
		</div>
		<?
		if($filtro == true){
			
			$w = " where ";
			if($idioma != ''){
				$cond .= $w." o.idioma = '".$idioma."' ";
				$w = " and ";
			}
			if($idproduto != ''){
				$cond .= $w." o.idproduto = '".$idproduto."' ";
				$w = " and ";
			}
			if($busca != ''){
				$cond .= $w." (o.idorcamento = '".$busca."' or o.nome like '%".$busca."%' or o.email like '%".$busca."%' or o.telefone like '%".$busca."%' or o.mensagem like '%".$busca."%' or o.cnpj_cpf like '%".$busca."%') ";
			}
		}

		$sql = "select distinct
					o.*,
					p.titulo_completo as produto
				from
					".ORCAMENTOS." o
					left join ".PRODUTOS." p on (o.idproduto = p.idproduto)
				order by o.data desc";

		$paginacao = new Paginacao("","",$sql,$pagina,20);
		$query = mysql_query($sql." limit ".$paginacao->getInicio().",20");

		if(mysql_num_rows($query) == 0){ ?>
			<p><?=($filtro == true) ? 'Não há orçamentos para exibir neste filtro!' : 'Não há orçamentos registrados!' ?></p>
		<? } else { ?>
        	<div class="listagem">
				<div class="cabecalho">
					<span class="expande">&nbsp;</span>
                    <span class="numero">Nº</span>
                    <span class="idioma">Idioma</span>
                    <span class="nome">Nome</span>
                    <span class="email">E-mail</span>
					<span class="telefone">Telefone</span>
                    <span class="data">Enviado em</span>
                    <span class="remover">Remover</span>
                    <div class="clear"></div>
                </div>
                <div>
					<?
                    while($rs = mysql_fetch_assoc($query)){

						#adicionais
						$produtos  = mysql_fetch_assoc(mysql_query("select distinct
																		group_concat(p.titulo_completo separator ', ') as adicionais
																	from
																		".PRODUTOS." p
																		left join ".ORCAMENTOS_PRODUTOS." op on (p.idproduto = op.idproduto)
																	where
																		op.idorcamento = '".$rs['idorcamento']."'"));
						?>
                        <div class="caixa-orcamento fecha">
                            <span class="expande"></span>
                    		<span class="numero">#<?=$rs['idorcamento']?></span>
                            <span class="idioma"><img src="../img/sistema/<?=$rs['idioma']?>.png" /></span>
                            <span class="nome"><?=$rs['nome']?></span>
                            <span class="email"><a href="mailto:<?=$rs['email']?>"><?=$rs['email']?></a></span>
                            <span class="telefone"><?=$rs['telefone']?></span>
                            <span class="data"><?=converteData($rs['data'],'d/m/Y H:i:s')?></span>
							<span class="remover"><a href="javascript:void(0)" onClick="remover(<?=$rs['idorcamento']?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>

							<div class="caixa-oculta">
								<div>
									<p><strong>Nome:</strong> <?=$rs['nome']?></p>
									<p><strong>E-mail:</strong> <a href="mailto:<?=$rs['email']?>"><?=$rs['email']?></a></p>
									<p><strong>Telefone:</strong> <?=$rs['telefone']?></p>
									<p><strong>Empresa:</strong> <?=$rs['empresa']?></p>
									<p><strong>CPF/CNPJ:</strong> <?=$rs['cnpj_cpf']?></p>
									<p><strong>Produto:</strong> <?=$rs['produto']?></p>
									<? if($produtos['adicionais'] != ''){ ?>
										<p><strong>Produto(s) Adicional(is):</strong> <?=$produtos['adicionais']?></p>
									<? } ?>
									<p><strong>Mensagem:</strong> <?=nl2br($rs['mensagem'])?></p>
								</div>
							</div>
						</div>
					<? } ?>
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
		if(is_numeric($id)) deletar(ORCAMENTOS,"where idorcamento = ".$id);
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
	}
	?>	
</div>
<? include("include-rodape.php"); ?>