<?
include('include-topo.php');

$path = '../img/produtos/galeria/';
$path_p = '../img/produtos/galeria/p/';
$path_temp = '../img/produtos/galeria/temp/';

#titulo
$sql = mysql_fetch_assoc(mysql_query("select * from ".PRODUTOS." where idproduto = '".$idproduto."'"));
$tit = 'Produto &raquo; '.$sql['titulo'];
?>
<div id="conteudo">
	<div class="topo">
		<h1><?=$tit?></h1>
        <div>
			<? if($acao != 'remover'){ ?>
			<a href="produtos-imgs.php?acao=adicionar&idproduto=<?=$idproduto?>" class="adicionar">adicionar imagens</a>
			<a href="javascript:history.back()" class="voltar">&laquo; voltar</a>
			<? } ?>
        </div>
	</div>

	<? if($acao == 'adicionar' && $idproduto != ''){ ?>

		<p>
		1) Selecione as imagens desejadas - <span style="color:#d00">800px de largura x 600px de altura</span>;<br />
		2) Clique em enviar imagens para efetuar o envio;<br />
		3) Após o envio você terá acesso a listagem com as imagens cadastradas.
		</p>
		<br />

		<form id="fileupload-produtos" action="" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="idproduto" id="idproduto" value="<?=$idproduto?>" />

			<div class="fileupload-buttonbar">
                <div class="col-lg-7">
                    <span class="btn btn-success fileinput-button">
                        <span>Selecionar imagens...</span>
                        <input type="file" name="files[]" multiple>
                    </span>
                    <button type="submit" class="btn btn-primary start">
                        <span>Enviar Imagens</span>
                    </button>
                    <button type="reset" class="btn btn-warning cancel">
                        <span>Cancelar envio</span>
                    </button>

					<span class="fileupload-loading"></span>
                </div>
                <div class="col-lg-5 fileupload-progress fade">
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-success"></div>
                    </div>
                    <div class="progress-extended">&nbsp;</div>
                </div>
            </div>
            <table role="presentation" class="table table-striped">
                <tbody class="files"></tbody>
            </table>
        </form>

		<script id="template-upload" type="text/x-tmpl">
        {% for(var i = 0, file; file = o.files[i]; i++){ %}
            <tr class="template-upload fade">
                <td>
                    <span class="preview"></span>
                </td>
                <td>
                    <p class="name">{%=file.name%}</p>
                    {% if(file.error){ %}
                        <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                    {% } %}
                </td>
                <td>
                    <p class="size">{%=o.formatFileSize(file.size)%}</p>
                    {% if(!o.files.error){ %}
                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
                    {% } %}
                </td>
                <td class="botoes">
                    {% if(!o.files.error && !i && !o.options.autoUpload){ %}
                        <button class="btn btn-primary start">
                            <span>Start</span>
                        </button>
                    {% } %}
                    {% if(!i){ %}
                        <button class="btn btn-warning cancel">
                            <span>Cancelar</span>
                        </button>
                    {% } %}
                </td>
            </tr>
        {% } %}
		</script>
        <script id="template-download" type="text/x-tmpl">
        {% for(var i = 0, file; file = o.files[i]; i++){ %}
            <tr class="template-download fade">
                <td>
                    <span class="preview">
                        {% if(file.thumbnailUrl){ %}
                            <a href="{%=file.url%}" title="{%=file.name%}" class="fancybox"><img src="{%=file.thumbnailUrl%}"></a>
                        {% } %}
                    </span>
                </td>
                <td>
                    <p class="name">
                        {% if(file.url){ %}
                            <a href="{%=file.url%}" title="{%=file.name%}" class="fancybox">{%=file.name%}</a>
                        {% } else { %}
                            <span>{%=file.name%}</span>
                        {% } %}
                    </p>
                    {% if(file.error) { %}
                        <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                    {% } %}
                </td>
                <td>
                    <span class="size">{%=o.formatFileSize(file.size)%}</span>
                </td>
                <td class="botoes">
                    {% if(file.deleteUrl){ %}
                        <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}">
                            <span>Deletar</span>
						</button>
                    {% } else { %}
                        <button class="btn btn-warning cancel">
                            <span>Cancelar</span>
                        </button>
                    {% } %}
                </td>
            </tr>
        {% } %}
        </script>
        <?
	}
	elseif($acao == 'listar' && $idproduto != ''){

		$query = mysql_query("select * from ".PRODUTOS_IMGS." where idproduto = '".$idproduto."' order by posicao desc");

		if($idproduto == ''){
		?>
		<div class="formulario">
			<?
            $acao = 'adicionar';
			include('form/form-produtos-imgs.php');
			?>
		</div>
		<hr size="1" />
		<? } ?>

		<? if(mysql_num_rows($query) == 0){ ?>
        	<p>N&atilde;o há imagens cadastradas, adicione imagens clicando no link superior!</p>
		<? } else { ?>

		<div class="listagem">
			<div id="sortable" class="img">
            	<input type="hidden" name="tabela" id="tabela" value="<?=PRODUTOS_IMGS?>" />
                <input type="hidden" name="campo" id="campo" value="idimg" />
				<input type="hidden" name="idproduto" id="idproduto" value="<?=$rs['idproduto']?>" />
                
				<?
				while($rs = mysql_fetch_assoc($query)){
					$ativo = ($rs['ativo'] == 'S') ? 'ico-ativo-on.png' : 'ico-ativo-off.png';
					?>
                    <div class="caixa-cat-img posiciona" data-id="<?=$rs['idimg']?>">
						<span class="preview"><a href="<?=$path.$rs['imagem']?>" class="fancybox" rel="galeria" title="<?=$rs['titulo']?>"><img src="<?=$path_p.$rs['imagem']?>" border="0" /></a></span>
						<span class="acoes">
                        	<span class="ativo"><img src="../img/sistema/<?=$ativo?>" longdesc="<?=PRODUTOS_IMGS?>-<?=$rs['idimg']?>-idimg" class="ativo cursor vimg" /></span>
                            <span class="editar"><a href="?acao=editar&id=<?=$rs['idimg']?>&idproduto=<?=$rs['idproduto']?>"><img src="../img/sistema/ico-editar.png" alt="editar" border="0" class="vimg" /></a></span>
                            <span class="remover"><a href="javascript:void(0)" onClick="removerIMGP(<?=$rs['idimg']?>,<?=$idproduto?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" class="vimg" /></a></span>
							<span class="posicao"><img src="../img/sistema/ico-ordenar.png" alt="ordenar" border="0" class="vimg" /></span>
                        </span>
                    </div>
				<? } ?>
			</div>
		</div>
		<?
		}
	}
	elseif($acao == 'editar' && $idproduto != ''){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-produtos-imgs.php');
			echo '</div>';
		} else {

			$idproduto = seguranca($_POST['idproduto']);
			$idimg = seguranca($_POST['idimg']);
			$imagem = $_FILES['imagem'];
			$hidden = seguranca($_POST['hidden']);
			
			$legendaBR = seguranca($_POST['legendaBR']);
			$legendaEN = seguranca($_POST['legendaEN']);
			$legendaES = seguranca($_POST['legendaES']);
			
			atualizar(PRODUTOS_IMGS,"legendaBR = '".$legendaBR."',legendaEN = '".$legendaEN."',legendaES = '".$legendaES."'","idimg = ".$id);

			if($imagem['name'] != ''){

				if(is_file($path.$hidden)) unlink($path.$hidden);
				if(is_file($path_p.$hidden)) unlink($path_p.$hidden);
				if(is_file($path_temp.$hidden)) unlink($path_temp.$hidden);

				$img = $id.'-'.corrigeNome($imagem['name']);
				move_uploaded_file($imagem['tmp_name'],$path_temp.$img);

				$tamanho = getimagesize($path_temp.$img);
				if($tamanho[0] > 800){
					$imgg = new canvas($path_temp.$img);
					$imgg->redimensiona(800,'');
					$imgg->grava($path_temp.$img,90);
				}

				$imgg = new canvas($path_temp.$img);
				$imgg->hexa('#fff');
				$imgg->redimensiona(800,600,'preenchimento');
				$imgg->grava($path.$img,90);

				$imgg = new canvas($path_temp.$img);
				$imgg->hexa('#fff');
				$imgg->redimensiona(293,220,'preenchimento');
				$imgg->grava($path_p.$img,90);

				atualizar(PRODUTOS_IMGS,"imagem = '".$img."',crop = 'N'","idimg = ".$id);
				$crop = true;
			}

			if($crop){
				echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=?acao=crop&id=$id&idproduto=$idproduto'>";
			} else {
				echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=?atualizado=true&acao=listar&idproduto=$idproduto'>";
			}
		}
	}
	elseif($acao == 'crop'){
		if(!$_POST){

			$sql = mysql_query("select * from ".PRODUTOS_IMGS." where idproduto = '".$idproduto."' and crop = 'N'");
			?>
			<div class="conteudo">
				<form name="" id="" action="?acao=crop" method="post" enctype="multipart/form-data">
					<p>Dicas de utilização:</p>
                    <p>1) Arraste o pontilhado até a área que você deseja na imagem (a imagem será recortada nesse ponto, sendo exibida no site);</p>
                    <p>2) Clique no botão 'Salvar' abaixo da imagem.</p>
                    <?
                    $contador = 0;
                    while($rs = mysql_fetch_assoc($sql)){
                        $tamanho = getimagesize($path_temp.$rs['imagem']);
    
                        #eu sei que fazer assim fica uma droga, mas não tinha opções, eu juro - maicon
                        $hidden .= '
						<input type="hidden" name="imagem-'.$contador.'" id="imagem-'.$contador.'" value="'.$rs['imagem'].'" />

                        <input type="hidden" name="x-'.$contador.'" id="x-'.$contador.'" value="0" />
                        <input type="hidden" name="y-'.$contador.'" id="y-'.$contador.'" value="0" />
                        <input type="hidden" name="x2-'.$contador.'" id="x2-'.$contador.'" value="0" />
                        <input type="hidden" name="y2-'.$contador.'" id="y2-'.$contador.'" value="0" />
                        <input type="hidden" name="w-'.$contador.'" id="w-'.$contador.'" value="0" />
                        <input type="hidden" name="h-'.$contador.'" id="h-'.$contador.'" value="0" />';

                        $jq .= "
                        $('#img-".$contador."').Jcrop({
							onChange : preview".$contador.",
                            onSelect : preview".$contador.",
                            minSize : [293,220],
							setSelect : [0,0,293,220],
                            aspectRatio : 293/220
						});";

						$js .= "
                        function preview".$contador."(p){
                            $('#x-".$contator."').val(p.x);
                            $('#y-".$contador."').val(p.y);
                            $('#x2-".$contador."').val(p.x2);
                            $('#y2-".$contador."').val(p.y2);
                            $('#w-".$contador."').val(p.w);
                            $('#h-".$contador."').val(p.h);
                        }";
                    ?>

                    <div class="crop">
                    	<img src="<?=$path_temp.$rs['imagem']?>" id="img-<?=$contador?>" />
                        <div class="caption">
                        	<input type="hidden" name="idimg_<?=$contador?>" value="<?=$rs['idimg']?>" />
                        	<span>
                            	<label>Legenda - Português:</label>
                                <input type="text" name="legendaBR[]" />
                            </span>
                        	<span>
                            	<label>Legenda - Inglês:</label>
                                <input type="text" name="legendaEN[]" />
                            </span>
                        	<span>
                            	<label>Legenda - Espanhol:</label>
                                <input type="text" name="legendaES[]" />
                            </span>
                        </div>
                    </div>
                    <?
                    $contador++;
                    }
                    ?>
					<input type="hidden" name="idproduto" id="idproduto" value="<?=$idproduto?>" />
                    <input type="hidden" name="total" id="total" value="<?=$contador?>" />
                    <?=$hidden?>
                    <script type="text/javascript">
                        $(window).load(function(){ <?=$jq?> });
                        <?=$js?>
                    </script>
					<br />
                    <div><input type="submit" name="btn-crop" id="btn-crop" value="Salvar" /></div>
                </form>
			</div>
		<?
		} else {

			$idproduto = seguranca($_POST['idproduto']);
			$total = seguranca($_POST['total']);

			for($i = 0; $i <= $total; $i++){

				$img = seguranca($_POST['imagem-'.$i]);
				
				$legendaBR = seguranca($_POST['legendaBR'][$i]);
				$legendaEN = seguranca($_POST['legendaEN'][$i]);
				$legendaES = seguranca($_POST['legendaES'][$i]);

				$x = intval($_POST['x-'.$i]);
				$y = intval($_POST['y-'.$i]);
				$w = intval($_POST['w-'.$i]);
				$h = intval($_POST['h-'.$i]);

				if($img != ''){

					$imgg = new canvas($path_temp.$img);
					$imgg->posicaoCrop($x,$y);
					$imgg->redimensiona($w,$h,'crop');
					$imgg->grava($path_temp.$img,100);

					$imgg = new canvas($path_temp.$img);
					$imgg->redimensiona(800,600);
					$imgg->grava($path.$img,90);
					
					$imgg = new canvas($path_temp.$img);
					$imgg->redimensiona(293,220);
					$imgg->grava($path_p.$img,90);

					atualizar(PRODUTOS_IMGS,"legendaBR = '".$legendaBR."',legendaEN = '".$legendaEN."',legendaES = '".$legendaES."',crop = 'S'","crop = 'N'");
					if(is_file($path_temp.$img)) unlink($path_temp.$img);
				}
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=?acao=listar&idproduto=$idproduto'>";
		}
	}
	else if($acao == 'remover'){
		if(is_numeric($id)){

			$img = mysql_fetch_assoc(mysql_query("select * from ".PRODUTOS_IMGS." where idimg = ".$id));

			if(is_file($path.$img['imagem'])) unlink($path.$img['imagem']);
			if(is_file($path_p.$img['imagem'])) unlink($path_p.$img['imagem']);
			if(is_file($path_temp.$img['imagem'])) unlink($path_temp.$img['imagem']);

			deletar(PRODUTOS_IMGS,"where idimg = ".$id);
		}

		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=produtos-imgs.php?acao=listar&idproduto=$idproduto'>";
	}
	?>
</div>
<? include('include-rodape.php') ?>