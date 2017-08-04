<? include("include-topo.php") ?>

<div id="conteudo">
	<div class="topo">
		<h1>Usuários</h1>
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
			<span>Filtrar por status:</span>
			<span>
				<select name="status" id="status">
                	<option value="0">Selecione</option>
                    <option value="S"<?=($status == 'S') ? ' selected="selected"' : '' ?>>Ativo</option>
                    <option value="N"<?=($status == 'N') ? ' selected="selected"' : '' ?>>Inativo</option>
                </select>
			</span>

			<span>Busca por texto:</span>
			<span>
            	<input type="text" name="busca" id="busca" class="usuarios" value="<?=$busca?>" />
			</span>
			<span>
                <input type="submit" name="filtro-usuarios" id="filtro-usuarios" value="OK" />
                <? if($filtro == true){ ?><a href="<?=$page?>.php"><img src="../img/sistema/ico-cancelar.png" alt="limpar filtro" class="vimg" /></a><? } ?>
            </span>
        </div>
    	<?
		if($filtro == true){
			$w = " where ";
			if($status != ''){
				$cond .= $w." ativo = '".$status."'";
				$w = " and ";
			}
			if($busca != ''){
				$cond .= $w." (nome like '%".$busca."%' or email like '%".$busca."%') ";
			}
		}

		$query = mysql_query("select * from ".USUARIOS." ".$cond." order by nome asc");

		if(mysql_num_rows($query) == 0){ ?>
			<p>N&atilde;o há usuários cadastrados!</p>
		<? } else { ?>
			<div class="listagem">
                <div class="cabecalho">
                    <span class="nome">Nome</span>
                    <span class="email">E-mail</span>
                    <span class="ativo">Ativo</span>
                    <span class="editar">Editar</span>
                    <span class="remover">Remover</span>
					<div class="clear"></div>
				</div>
				<?
                while($rs = mysql_fetch_assoc($query)){
                    $ativo = ($rs['ativo'] == 'S') ? 'ico-ativo-on.png' : 'ico-ativo-off.png';
                ?>
                <div class="caixa-usuario">
                    <span class="nome"><?=$rs['nome']?></span>
                    <span class="email"><?=$rs['email']?></span>
                    <span class="ativo"><img src="../img/sistema/<?=$ativo?>" longdesc="<?=USUARIOS?>-<?=$rs['idusuario']?>-idusuario" class="ativo cursor" /></span>
                    <span class="editar"><a href="?acao=editar&id=<?=$rs['idusuario']?>"><img src="../img/sistema/ico-editar.png" alt="editar" border="0" /></a></span>
                    <span class="remover"><a href="javascript:void(0)" onClick="remover(<?=$rs['idusuario']?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>
                </div>
                <? } ?>
			</div>
			<?
		}
	}
	elseif($acao == 'adicionar'){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-usuarios.php');
			echo '</div>';
		} else {

			$nome = seguranca($_POST['nome']);
			$email = seguranca($_POST['email']);
			$senha = seguranca($_POST['senha']);
			$permissao = $_POST['permissao'];
			$ativo = seguranca($_POST['ativo']);
			$data_cadastro = date('Y-m-d H:i:s');
			$ativo = ($ativo == 'S') ? 'S' : 'N';
			
			#permissões
			if($permissao != '') $permissao = implode(',',$permissao);

			$campos = "nome,email,senha,permissao,ativo,data_cadastro";
			$valores = "'".$nome."','".$email."','".$senha."','".$permissao."','".$ativo."','".$data_cadastro."'";
			inserir(USUARIOS,$campos,$valores);

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";

		}
	}
	elseif($acao == 'editar'){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-usuarios.php');
			echo '</div>';
		} else {
			
			$nome = seguranca($_POST['nome']);
			$email = seguranca($_POST['email']);
			$senha = seguranca($_POST['senha']);
			$permissao = $_POST['permissao'];
			$ativo = seguranca($_POST['ativo']);
			$data_cadastro = date('Y-m-d H:i:s');
			$ativo = ($ativo == 'S') ? 'S' : 'N';
			
			#permissões
			if($permissao != '') $permissao = implode(',',$permissao);

			$dados = "nome = '".$nome."',email = '".$email."',senha = '".$senha."',permissao = '".$permissao."',ativo = '".$ativo."',data_cadastro = '".$data_cadastro."'";
			atualizar(USUARIOS,$dados,"idusuario = ".$id);

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'remover'){
		if(is_numeric($id)) deletar(USUARIOS,"where idusuario = ".$id);
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
	}
	?>
</div>
<? include("include-rodape.php"); ?>