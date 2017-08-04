<?
include("include-topo.php");

$path_cv = '../arquivos/simposio/inscricoes/curriculos/';
$path_obras = '../arquivos/simposio/inscricoes/obras/';
?>
<div id="conteudo">
	<div class="topo">
		<h1>Simpósio Inscrições</h1>
		<div><a href="<?=$page?>.php" class="voltar">&laquo; voltar</a></div>
	</div>
	<? if($acao == ''){ ?>
		<div class="filtro">
			<span>Busca por texto:</span>
			<span>
				<input type="text" name="busca" id="busca" class="contato" value="<?=$busca?>" />
			</span>
			<span>
                <input type="submit" name="filtro-inscricoes" id="filtro-inscricoes" value="OK" />
                <? if($filtro == true){ ?><a href="<?=$page?>.php"><img src="../img/sistema/ico-cancelar.png" alt="limpar filtro" class="vimg" /></a><? } ?>
            </span>
        </div>
    	<?
		if($filtro == true){
			$w = " where ";
			if($busca != ''){
				$cond .= $w." (nome like '%".$busca."%' or sobrenome like '%".$busca."%' or email like '%".$busca."%' or telefone like '%".$busca."%' or cpf like '%".$busca."%') ";
			}
		}

		$paginacao = new Paginacao(SIMPOSIO_INSCRICOES," ".$cond." order by data_cadastro desc","",$pagina,20);
		$query = mysql_query("select * from ".SIMPOSIO_INSCRICOES." ".$cond." order by data_cadastro desc limit ".$paginacao->getInicio().",20");

		if(mysql_num_rows($query) == 0){ ?>
			<p>Não há itens para exibir!</p>
		<? } else { ?>
        	<div class="listagem">
				<div class="cabecalho">
					<span class="idioma">Idioma</span>
                    <span class="nome">Nome</span>
                    <span class="email">E-mail</span>
					<span class="telefone">Telefone</span>
                    <span class="data">Data de Cadastro</span>
                    <span class="visualizar">Inscrição Completa</span>
                    <span class="remover">Remover</span>
					<div class="clear"></div>
                </div>
                <div>
					<? while($rs = mysql_fetch_assoc($query)){ ?>
                        <div class="caixa-inscricao">
                            <span class="idioma"><img src="../img/sistema/<?=$rs['idioma']?>.png" /></span>
                            <span class="nome"><?=$rs['nome']?></span>
                            <span class="email"><a href="mailto:<?=$rs['email']?>"><?=$rs['email']?></a></span>
                            <span class="telefone"><?=$rs['telefone']?></span>
                            <span class="data"><?=converteData($rs['data_cadastro'],'d/m/Y H:i:s')?></span>
							<span class="visualizar"><a href="?acao=visualizar&id=<?=$rs['idinscricao']?>"><img src="../img/sistema/ico-lupa.png" class="vimg" /></a></span>
							<span class="remover"><a href="javascript:void(0)" onClick="remover(<?=$rs['idinscricao']?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" class="vimg" /></a></span>
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
	elseif($acao == 'visualizar'){

		$sql = mysql_query("select * from ".SIMPOSIO_INSCRICOES." where idinscricao = '".$id."'");
		$rs = mysql_fetch_assoc($sql);
		?>

		<div class="visualizar-inscricao">
			<h2>Informações Pessoais</h2>
            <div>
                <div class="rotulo">Nome:</div>
                <div class="valor"><?=$rs['nome']?></div>
            </div>
            <div>
                <div class="rotulo">Sobrenome:</div>
                <div class="valor"><?=$rs['sobrenome']?></div>
            </div>
            <div>
                <div class="rotulo">Data de Nascimento:</div>
                <div class="valor"><?=converteData($rs['data_nascimento'],'d/m/Y')?></div>
            </div>
            <div>
                <div class="rotulo">Títulos:</div>
                <div class="valor">
					<?
					$arr = json_decode($rs['titulos'],true);
					echo implode(', ',$arr);
					?>
				</div>
            </div>
            <div>
                <div class="rotulo">Sexo:</div>
                <div class="valor"><?=($rs['sexo'] == 'F') ? 'Feminino' : 'Masculino' ?></div>
            </div>
            <div>
                <div class="rotulo">Nacionalidade:</div>
                <div class="valor"><?=$rs['nacionalidade']?></div>
            </div>
            <div>
                <div class="rotulo">Passaporte ou CPF Nº:</div>
                <div class="valor"><?=$rs['documento']?></div>
            </div>
            <div>
                <div class="rotulo">Validade:</div>
                <div class="valor"><?=$rs['validade']?></div>
            </div>
            <div>
                <div class="rotulo">Endereço:</div>
                <div class="valor"><?=$rs['endereco']?></div>
            </div>
            <div>
                <div class="rotulo">Telefone:</div>
                <div class="valor"><?=$rs['telefone']?></div>
            </div>
            <div>
                <div class="rotulo">Celular:</div>
                <div class="valor"><?=$rs['celular']?></div>
            </div>
            <div>
                <div class="rotulo">País:</div>
                <div class="valor"><?=$rs['pais']?></div>
            </div>
            <div>
                <div class="rotulo">Cod. Postal:</div>
                <div class="valor"><?=$rs['cod_postal']?></div>
            </div>
            <div>
                <div class="rotulo">E-mail:</div>
                <div class="valor"><?=$rs['email']?></div>
            </div>
            <div>
                <div class="rotulo">Website:</div>
                <div class="valor"><?=($rs['website'] != '' && $rs['website'] != 'http://') ? '<a href="'.$rs['website'].'" target="_blank">'.$rs['website'].'</a>' : '-' ?></div>
            </div>
    
            <h2>Informação Biográfica</h2>
            <div>
                <div class="rotulo">Cidade/País:</div>
                <div class="valor"><?=$rs['cidade_pais']?></div>
            </div>
            <div>
                <div class="rotulo">Ocupação:</div>
                <div class="valor"><?=$rs['ocupacao']?></div>
            </div>
            <div>
                <div class="rotulo">Currículo:</div>
                <div class="valor"><a href="<?=$path_cv.$rs['curriculo']?>" target="_blank"><?=$rs['curriculo']?></a></div>
            </div>
    
            <h2>Recentes Trabalhos</h2>
            <h3>1) Trabalho</h3>
            <div>
                <div class="rotulo">Nome da ilustração:</div>
                <div class="valor"><?=$rs['trabalho1']?></div>
            </div>
            <div>
                <div class="rotulo">Mais infos. sobre a arte:</div>
                <div class="valor"><?=$rs['mais1']?></div>
            </div>
            <div>
                <div class="rotulo">Imagem da obra de arte:</div>
                <div class="valor"><a href="<?=$path_obras.$rs['arquivo1']?>" target="_blank"><?=$rs['arquivo1']?></a></div>
            </div>
    
            <h3>2) Trabalho</h3>
            <div>
                <div class="rotulo">Nome da ilustração:</div>
                <div class="valor"><?=$rs['trabalho2']?></div>
            </div>
            <div>
                <div class="rotulo">Mais infos. sobre a arte:</div>
                <div class="valor"><?=$rs['mais2']?></div>
            </div>
            <div>
                <div class="rotulo">Imagem da obra de arte:</div>
                <div class="valor"><a href="<?=$path_obras.$rs['arquivo1']?>" target="_blank"><?=$rs['arquivo2']?></a></div>
            </div>
    
            <h3>3) Trabalho</h3>
            <div>
                <div class="rotulo">Nome da ilustração:</div>
                <div class="valor"><?=$rs['trabalho3']?></div>
            </div>
            <div>
                <div class="rotulo">Mais infos. sobre a arte:</div>
                <div class="valor"><?=$rs['mais3']?></div>
            </div>
            <div>
                <div class="rotulo">Imagem da obra de arte:</div>
                <div class="valor"><a href="<?=$path_obras.$rs['arquivo1']?>" target="_blank"><?=$rs['arquivo3']?></a></div>
            </div>
           
            <h2>Participantes Informações de Obras de Arte</h2>
            <div>
                <div class="rotulo">Título da Obra:</div>
                <div class="valor"><?=$rs['titulo_obra']?></div>
            </div>
            <div>
                <div class="rotulo">Tamanho (em metro) - Mínimo 2,0m / Máximo 2,5m:</div>
                <div class="valor"><?=$rs['tamanho_obra']?></div>
            </div>
            <div>
                <div class="rotulo">Tipo de metal:</div>
                <div class="valor"><?=$rs['metal_obra']?></div>
            </div>
            <div>
                <div class="rotulo">Clarificação da ideia (por favor esclarecer a sua ideia de trabalho em menos de 100 palavras):</div>
                <div class="valor"><?=$rs['descricao_obra']?></div>
            </div>
            <div>
                <div class="rotulo">Projeto de design (tamanho máximo do arquivo 5MB):</div>
				<div class="valor"><a href="<?=$path_obras.$rs['arquivo_obra']?>" target="_blank"><?=$rs['arquivo_obra']?></a></div>
            </div>
		</div>

		<?
	}
	elseif($acao == 'remover'){
		if(is_numeric($id)){

			$arq = mysql_fetch_assoc(mysql_query("select * from ".SIMPOSIO_INSCRICOES." where idinscricao = '".$id."'"));
			if(is_file($path_cv.$arq['curriculo'])) unlink($path_cv.$arq['curriculo']);
			if(is_file($path_obras.$arq['arquivo1'])) unlink($path_obras.$arq['arquivo1']);
			if(is_file($path_obras.$arq['arquivo2'])) unlink($path_obras.$arq['arquivo2']);
			if(is_file($path_obras.$arq['arquivo3'])) unlink($path_obras.$arq['arquivo3']);

			deletar(SIMPOSIO_INSCRICOES,"where idinscricao = ".$id);
		}
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
	}
	?>	
</div>
<? include("include-rodape.php"); ?>