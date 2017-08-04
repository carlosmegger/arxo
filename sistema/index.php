<? include("include-topo.php"); ?>
<div class="login">
    <form id="form-login" name="form-login" method="post" action="<?=$sistema?>autentica.php">
        <span>
            <label for="email">E-mail:</label>
            <input type="text" name="email" id="email" size="35" />
        </span>
        <span>
            <label for="senha">Senha:</label>
			<input type="password" name="senha" id="senha" size="35" />
		</span>
		<span><input type="submit" value="Entrar" /></span>
		<span class="retorno">
			<?
			if($login == 'erro'){
				echo 'Usuário ou senha inválidos!';
			}
			elseif($login == 'expirou'){
				echo 'Você ficou muito tempo sem utilizar o sistema.<br />Faça login novamente!';
			}
			?>
		</span>
    </form>
</div>
<? include("include-rodape.php"); ?>