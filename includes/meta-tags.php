<?
switch($page){
	
	case 'contato':
		$tit = $_metas['titulo contato'];
		$desc = $_metas['descricao contato'];
	break;

	case 'institucional':
		switch($ancora){
			case 'ideologia':
				$tit = $_metas['titulo ideologia'];
				$desc = $_metas['descricao ideologia'];
			break;
			case 'veryx':
				$tit = $_metas['titulo veryx'];
				$desc = $_metas['descricao veryx'];
			break;
			case 'certificacoes':
				$tit = $_metas['titulo certificacoes'];
				$desc = $_metas['descricao certificacoes'];
			break;
			case 'clientes':
				$tit = $_metas['titulo clientes'];
				$desc = $_metas['descricao clientes'];
			break;
			default:
				$tit = $_metas['titulo institucional'];
				$desc = $_metas['descricao institucional'];
			break;
		}
	break;

	case 'instituto':
		$tit = $_metas['titulo instituto'];
		$desc = $_metas['descricao instituto'];
	break;

	case 'localizacao':
		$tit = $_metas['titulo localizacao'];
		$desc = $_metas['descricao localizacao'];
	break;

	case 'novidades':
		if($slug == '' && $tag == ''){
			$tit = $_metas['titulo novidades'];
			$desc = $_metas['descricao novidades'];
		}
		elseif($slug != '' && $tag == ''){
			$tit = $categoria->titulo.' - '.$_metas['titulo novidades'];
			#$desc = $_metas['descricao novidades'];
			$desc = str_replace('[categoria]',$categoria->titulo,$_metas['descricao novidades-categoria']);
		}
		elseif($slug == '' && $tag != ''){

			if($noticia->meta_titulo != ''){
				$tit = $noticia->meta_titulo.' - '.$_metas['titulo novidades'];
			} else {
				$tit = $noticia->titulo.' - '.$_metas['titulo novidades'];
			}
			if($noticia->meta_descricao != ''){
				$desc = $noticia->meta_descricao;
			} else {

				$_desc = $noticia->breve;
				$_desc = html_entity_decode($_desc,ENT_NOQUOTES,'UTF-8');
				$_desc = (strlen($_desc) >= 155) ? substrWord($_desc,155) : $_desc;

				$desc = $_desc;
			}
		}

	break;

	case 'portal-cliente':
		$tit = $_metas['titulo portal-cliente'];
		$desc = $_metas['descricao portal-cliente'];
	break;

	case 'portal-colaborador':
		$tit = $_metas['titulo portal-colaborador'];
		$desc = $_metas['descricao portal-colaborador'];
	break;

	case 'produtos':
		if($slug == '' && $tag == ''){
			$tit = $_metas['titulo produtos'];
			$desc = $_metas['descricao produtos'];
		}
		elseif($slug != '' && $tag == ''){
			$tit = $categoria->titulo.' - '.$_metas['titulo produtos'];
			$desc = str_replace('[categoria]',$categoria->titulo,$_metas['descricao produto-categoria']);
		}
		elseif($slug != '' && $tag != ''){

			if($produto->meta_titulo != ''){
				$tit = $produto->meta_titulo.' - '.$_metas['titulo produtos'];
			} else {
				$tit = $produto->titulo_completo.' - '.$_metas['titulo produtos'];
			}

			if($produto->meta_descricao != ''){
				$desc = $produto->meta_descricao;
			} else {

				$_desc = $produto->descricao;
				$_desc = strip_tags($_desc);
				$_desc = nl2br_reverso($_desc);
				$_desc = (strlen($_desc) >= 155) ? substrWord($_desc,155) : $_desc;

				$desc = $_desc;
			}
		}
	break;

	case 'representantes':
		$tit = $_metas['titulo representantes'];
		$desc = $_metas['descricao representantes'];
	break;

	case 'revista':
		$tit = $_metas['titulo revista'];
		$desc = $_metas['descricao revista'];
	break;

	case 'simposio-inscricoes':
		$tit = $_metas['titulo simposio-inscricoes'];
		$desc = $_metas['descricao simposio-inscricoes'];
	break;

	case 'simposio':
		$tit = $_metas['titulo simposio'];
		$desc = $_metas['descricao simposio'];
	break;

	case 'trabalhe-conosco':
		$tit = $_metas['titulo trabalhe-conosco'];
		$desc = $_metas['descricao trabalhe-conosco'];
	break;

	case 'orcamento':
		$tit = $_metas['titulo orcamento'];
		$desc = $_metas['descricao orcamento'];
	break;

	default:
		$tit = $_metas['titulo home'];
		$desc = $_metas['descricao home'];
	break;

}
?>

<title><?=$tit?></title>
<? if($page != 'orcamento'){ ?>
<meta name="robots" content="index,follow" />
<? } else { ?>
<meta name="robots" content="noindex,nofollow" />
<? } ?>
<meta name="description" content="<?=$desc?>" />
