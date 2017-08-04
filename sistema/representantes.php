<? include("include-topo.php") ?>
<div id="conteudo">
	<div class="topo">
		<h1>Representantes</h1>
		<div>
        <? if($acao == ''){ ?>
			<a href="?acao=adicionar" class="adicionar">adicionar</a>
		<? } else { ?>
        	<a href="javascript:history.back()" class="voltar">&laquo; voltar</a>
		<? } ?>
		</div>
	</div>

	<? if($acao == ''){ ?>

		<div class="filtro">
			<span>País:</span>
			<span><?=paises($pais)?></span>
        
			<span>Busca por texto:</span>
			<span>
            	<input type="text" name="busca" id="busca" class="representantes" value="<?=$busca?>" />
			</span>
            <span>
            	<input type="submit" name="filtro-representantes" id="filtro-representantes" value="OK" />
				<? if($filtro == true){ ?><a href="<?=$page?>.php"><img src="../img/sistema/ico-cancelar.png" alt="limpar filtro" class="vimg" /></a><? } ?>
            </span>
        </div>

		<?
		if($filtro == true){
			$w = " where ";
			if($pais != ''){
				$cond .= $w." pais = '".$pais."' ";
				$w = " and ";
			}
			if($busca != ''){
				$cond .= $w." (razao_social like '%".$busca."%' or contato like '%".$busca."%' or email like '%".$busca."%' or telefone like '%".$busca."%' or celular like '%".$busca."%' or area like '%".$busca."%' or endereco like '%".$busca."%' or cidade like '%".$busca."%' or estado like '%".$busca."%' or breve like '%".$busca."%') ";
			}
		}

		$query = mysql_query("select * from ".REPRESENTANTES." ".$cond." order by razao_social asc");

		if(mysql_num_rows($query) == 0){ ?>
			<p>N&atilde;o há itens cadastrados!</p>
		<? } else { ?>
        	<div class="listagem">
                <div class="cabecalho">
                    <span class="titulo">Razão Social</span>
                    <span class="email">E-mail</span>
                    <span class="pais">País</span>
                    <span class="estado">Estado</span>
                    <span class="editar">Editar</span>
					<span class="remover">Remover</span>
					<div class="clear"></div>
				</div>
				<?
                while($rs = mysql_fetch_assoc($query)){
                    $ativo = ($rs['ativo'] == 'S') ? 'ico-ativo-on.png' : 'ico-ativo-off.png';
				?>
                <div class="caixa-representante">
                    <span class="titulo"><?=$rs['razao_social']?></span>
                    <span class="email"><a href="mailto:<?=$rs['email']?>"><?=$rs['email']?></a></span>
                    <span class="pais"><?=$rs['pais']?></span>
                    <span class="estado"><?=$rs['estado']?></span>
                    <span class="editar"><a href="?acao=editar&id=<?=$rs['idrepresentante']?>"><img src="../img/sistema/ico-editar.png" alt="editar" border="0" /></a></span>
                    <span class="remover"><a href="javascript:void(0)" onClick="remover(<?=$rs['idrepresentante']?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>
                </div>
				<? } ?>
			</div>
			<?
		}
	}
	elseif($acao == 'adicionar'){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-representantes.php');
			echo '</div>';
		} else {
			
			$razao_social = seguranca($_POST['razao_social']);
			$slug = montaTag($razao_social);
			$contato = seguranca($_POST['contato']);
			$email = seguranca($_POST['email']);
			$telefone = seguranca($_POST['telefone']);
			$celular = seguranca($_POST['celular']);
			$area = seguranca($_POST['area']);
			$endereco = seguranca($_POST['endereco']);
			$pais = seguranca($_POST['pais']);
			$cidade = seguranca($_POST['cidade']);
			$estado = seguranca($_POST['estado']);
			$cep = seguranca($_POST['cep']);
			$breve = seguranca($_POST['breve']);

			$campos = "razao_social,slug,contato,email,telefone,celular,area,endereco,pais,cidade,estado,cep,breve";
			$valores = "'".$razao_social."','".$slug."','".$contato."','".$email."','".$telefone."','".$celular."','".$area."','".$endereco."','".$pais."','".$cidade."','".$estado."','".$cep."','".$breve."'";
			inserir(REPRESENTANTES,$campos,$valores);

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'editar'){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-representantes.php');
			echo '</div>';
		} else {

			$razao_social = seguranca($_POST['razao_social']);
			$slug = montaTag($razao_social);
			$contato = seguranca($_POST['contato']);
			$email = seguranca($_POST['email']);
			$telefone = seguranca($_POST['telefone']);
			$celular = seguranca($_POST['celular']);
			$area = seguranca($_POST['area']);
			$endereco = seguranca($_POST['endereco']);
			$pais = seguranca($_POST['pais']);
			$cidade = seguranca($_POST['cidade']);
			$estado = seguranca($_POST['estado']);
			$cep = seguranca($_POST['cep']);
			$breve = seguranca($_POST['breve']);

			$dados = "razao_social = '".$razao_social."',
					  slug = '".$slug."',
					  contato = '".$contato."',
					  email = '".$email."',
					  telefone = '".$telefone."',
					  celular = '".$celular."',
					  area = '".$area."',
					  endereco = '".$endereco."',
					  pais = '".$pais."',
					  cidade = '".$cidade."',
					  estado = '".$estado."',
					  cep = '".$cep."',
					  breve = '".$breve."'";

			atualizar(REPRESENTANTES,$dados,"idrepresentante = ".$id);

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'remover'){
		if(is_numeric($id)) deletar(REPRESENTANTES,"where idrepresentante = ".$id);
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
	}
	?>
</div>
<? include("include-rodape.php"); ?>