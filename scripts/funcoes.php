<?
function seguranca($txt){
	$txt = (get_magic_quotes_gpc() == 1) ? stripslashes($txt) : $txt;
	return @mysql_escape_string(trim($txt));
}
function go_url($url){
	if($url){
		echo '<script type="text/javascript">';
		echo 'window.location="'.$url.'";';
		echo '</script>';
	}
	exit;
}
function getExtensao($str){
	$extensao = explode('.',$str);
	$extensao = end($extensao);
	return $extensao;
}
function convertem($term, $tp){
	if($tp == "1") $palavra = strtr(strtoupper($term),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
	elseif($tp == "0") $palavra = strtr(strtolower($term),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
	return $palavra;
}
function retiraAcentos($str){
	$a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
	$b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
	return str_replace($a,$b,$str);
}
function setPosicao($posicao,$id,$campo,$tabela){
	$dados = "posicao = '$posicao'";
	atualizar($tabela,$dados,$campo." = ".$id);
}
function proxPosicao($tabela,$ordenamento,$condicao = false){
	if($ordenamento == 'asc') $ordenamento = 'desc'; else $ordenamento = 'asc';
	if($condicao == true) $condicao = ' where '.$condicao;
	
	$sql  = mysql_query("select posicao from ".$tabela." ".$condicao." order by posicao ".$ordenamento." limit 1");
	$rows = mysql_num_rows($sql);

	if($rows > 0){
		$rs = mysql_result($sql,0,$campo);
		if($ordenamento != 'asc') $retorno = $rs+1; else $retorno = $rs-1;
	}
	elseif($rows == 0){
		$retorno = 0;
	}
	else {
		$retorno = '';	
	}
	return $retorno;
}
function limpaArrays($lista) {
	$lista = preg_replace('/[^\d\;]*/','',$lista);
			
	$array = explode(";",$lista);
	$array = array_filter($array, "limpaArray");
	$array = array_values($array);
	return $array;
}

// Callback da chamada array_filter($array, "limpaArray");
function limpaArray($var){
	return (strlen($var) > 0);
}
function filtrarEmail($var){
	return (preg_match("/^[A-Z0-9\._\%\+\-]+@[A-Z0-9\.\-]+\.[A-Z]{2,4}(\.[A-Z]{2})?$/im",$var) != false);
}
function super_unique($array){
	$result = array_map("unserialize", array_unique(array_map("serialize", $array)));
	foreach($result as $key => $value){
		if(is_array($value)) $result[$key] = super_unique($value);
	}
	return $result;
}
function sortData($dataA,$dataB){
	if ($dataA == $dataB) {
        return 0;
    }
    return ($dataA > $dataB) ? -1 : 1;
}
function limpaString($string,$tipo = ''){
	switch($tipo){
		case 'codigo':		$pattern = '/[^0-9\.\-\/]/';		break;
		case 'numeros':		$pattern = '/[^0-9\.\,]/'; 			break;
		case 'letras': 		$pattern = '/[^a-zA-Z ]/'; 			break;
		case 'email': 		$pattern = '/[^0-9a-zA-Z\.\@\_]/';	break;
		case 'hexadecimal':	$pattern = '/[^0-9a-fA-F]/'; 		break;
		default: 			$pattern = '/[^\_\.\w\t\r\n ]/';
	}
	return preg_replace($pattern, "",$string);
}
function diasemana($data){
	$ano = substr($data,0,4);
	$mes = substr($data,5,-3);
	$dia = substr($data,8,9);

	$diasemana = date("w",mktime(0,0,0,$mes,$dia,$ano));
	switch($diasemana){
		case '0': $diasemana = "dom"; break;
		case '1': $diasemana = "seg"; break;
		case '2': $diasemana = "ter"; break;
		case '3': $diasemana = "qua"; break;
		case '4': $diasemana = "qui"; break;
		case '5': $diasemana = "sex"; break;
		case '6': $diasemana = "sab"; break;
	}
	return $diasemana;
}
function conversao($mes){
	switch($mes){
		case  1: return 'Janeiro';
		case  2: return 'Fevereiro';
		case  3: return 'Março';
		case  4: return 'Abril';
		case  5: return 'Maio';
		case  6: return 'Junho';
		case  7: return 'Julho';
		case  8: return 'Agosto';
		case  9: return 'Setembro';
		case 10: return 'Outubro';
		case 11: return 'Novembro';
		case 12: return 'Dezembro';
	}
}
function abreviaMes($mes){
	switch($mes){
		case  1: return 'Jan';
		case  2: return 'Fev';
		case  3: return 'Mar';
		case  4: return 'Abr';
		case  5: return 'Mai';
		case  6: return 'Jun';
		case  7: return 'Jul';
		case  8: return 'Ago';
		case  9: return 'Set';
		case 10: return 'Out';
		case 11: return 'Nov';
		case 12: return 'Dez';
	}
}
function mesSlug($mes,$troca = true){
	if($troca == false){
		switch($mes){
			case  1: return 'janeiro';
			case  2: return 'fevereiro';
			case  3: return 'marco';
			case  4: return 'abril';
			case  5: return 'maio';
			case  6: return 'junho';
			case  7: return 'julho';
			case  8: return 'agosto';
			case  9: return 'setembro';
			case 10: return 'outubro';
			case 11: return 'novembro';
			case 12: return 'dezembro';
		}
	} else {
		switch($mes){
			case 'janeiro':		return 1;
			case 'fevereiro':	return 2;
			case 'marco':		return 3;
			case 'abril':		return 4;
			case 'maio':		return 5;
			case 'junho':		return 6;
			case 'julho':		return 7;
			case 'agosto':		return 8;
			case 'setembro':	return 9;
			case 'outubro':		return 10;
			case 'novembro':	return 11;
			case 'dezembro':	return 12;
		}
	}
}
function formataValor($valor,$acao = 0){
	if($acao == 1){
		return str_replace(',','.',str_replace('.','',$valor));
	} else {
		return number_format($valor,2,',','.');
	}
}
function formataNumero($data){
	if(strlen($data) == 1){
		return "0".$data;
	} else {
		return $data;
	}
}
function formataData($data){
	if(strlen($data) == 1){
		return "0".$data;
	} else {
		return $data;
	}
}
function converteData($data,$formato){
	if(($data == NULL) || ($data == "")) return NULL;
	switch($formato){
		case "Y-m-d":
			$aux = explode("/",$data);
			$retorno  = $aux[2]."-".$aux[1]."-".$aux[0];
		break;
		case "d/m/Y":
			$aux = explode("-",$data);
			$retorno  = $aux[2]."/".$aux[1]."/".$aux[0];
		break;
		case "Y/m/d":
			$aux = explode("-",$data);
			$retorno  = $aux[0]."/".$aux[1]."/".$aux[2];
		break;
		case "d/m/Y H:i:s":
			list($dat,$hor) = explode(" ",$data);
			list($ano,$mes,$dia) = explode("-",$dat);
			list($hora,$minuto,$segundo) = explode(":",$hor);
			$retorno  = $dia."/".$mes."/".$ano.' '.$hora.':'.$minuto.':'.$segundo;
		break;
		case "H:i:00":	
			$aux = explode("/",$data);
			$retorno  = $aux[0].":".$aux[1].":00";
		break;
		case "H:i":		
			$aux = explode(":",$data);
			$retorno  = $aux[0].":".$aux[1];
		break;
		case "H":		
			$aux = explode(":",$data);
			$retorno  = $aux[0];
		break;
		case "Y":		
			$aux = explode("/",$data);
			$retorno  = $aux[0];
		break;
		case "m":		
			$aux = explode("/",$data);
			$retorno  = $aux[1];
		break;
		case "d":		
			$aux = explode("/",$data);
			$retorno  = $aux[2];
		break;
	}
	return formataData($retorno);
}
function formata_bytes($size) {
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
    return round($size).$units[$i];
}
function formataFloat($valor){
	return number_format($valor,2,",",".");
}
function corrigeNome($texto){
	$texto = html_entity_decode($texto);
	$texto = trim($texto);

	if(strrpos($texto,'.') !== false) {
		$quebraTexto = explode('.',$texto);
		$terminacao = end($quebraTexto);
		if(sizeof($quebraTexto) == 2){
			$texto = $quebraTexto[0];  
		} else {
			array_pop($quebraTexto);
			$texto = join(".",$quebraTexto);
		}
	}
	
    //tirando os acentos
	$texto = preg_replace('/á|à|â|ã|Á|À|Ã|Â|Ä/','a',$texto);
    $texto = preg_replace('/é|è|ê|É|È|Ê|Ë/','e',$texto);
	$texto = preg_replace('/í|ì|î|ï|Í|Ì|Î|Ï/','i',$texto);
    $texto = preg_replace('/ó|ò|õ|ô|ö|Ó|Ò|Ô|Ö|Õ/','o',$texto);
    $texto = preg_replace('/ú|ù|û|ü|Ú|Ù|Û|Ü/','u',$texto);
	
    //parte que tira o cedilha e o ñ
    $texto = preg_replace('/Ç|ç/','c',$texto);
    $texto = preg_replace('/Ñ|ñ/','n',$texto);
    $texto = preg_replace('/\$/','s',$texto);
    //trocando espaço em branco por underline
    $texto = str_replace(' ','_',$texto);
    $texto = str_replace('.','_',$texto);
    //tirando outros caracteres invalidos
	
   	$texto = preg_replace('/[^a-zA-Z0-9\_]/i','',$texto);
    //trocando duplo espaço (underline) por 1 underline só
	$texto = str_replace('__','_',$texto);
	$texto = str_replace('_','-',$texto);
	
    if ($terminacao){
    	return strtolower($texto.'.'.$terminacao);
	} else {
		return strtolower($texto);
	}
}
function montaTag($texto){
	/* função que gera uma texto limpo pra virar URL:
       - limpa acentos e transforma em letra normal
       - limpa cedilha e transforma em c normal, o mesmo com o ñ
       - transforma espaços em hifen (-)
       - tira caracteres invalidos
      by Micox - elmicox.blogspot.com
    */
	#desconvertendo do padrão entitie (tipo &aacute; para á)
    $texto = html_entity_decode($texto);

    #tirando os acentos
	$texto = preg_replace('/á|à|â|ã|Á|À|Ã|Â|Ä/','a',$texto);
    $texto = preg_replace('/é|è|ê|É|È|Ê|Ë/','e',$texto);
	$texto = preg_replace('/í|ì|î|ï|Í|Ì|Î|Ï/','i',$texto);
    $texto = preg_replace('/ó|ò|õ|ô|ö|Ó|Ò|Ô|Ö|Õ/','o',$texto);
    $texto = preg_replace('/ú|ù|û|ü|Ú|Ù|Û|Ü/','u',$texto);
	
	#parte que tira o cedilha e o ñ
	$texto = preg_replace('/Ç|ç/','c',$texto);
	$texto = preg_replace('/Ñ|ñ/','n',$texto);
	$texto = preg_replace('/\$/','s',$texto);
	$texto = preg_replace('/[^a-zA-Z0-9\_]/i',' ',$texto);

	#trocando espaço em branco por underline
	$texto = str_replace('  ',' ',$texto);
	$texto = str_replace(' ','_',$texto);
	$texto = str_replace('__','_',$texto);
	$texto = str_replace('.','_',$texto);
	$texto = str_replace('_','-',$texto);

	return strtolower($texto);
}
function tiraAcentos($texto){
	#tirando os acentos
	$texto = preg_replace('/á|à|â|ã/','a',$texto);
	$texto = preg_replace('/Á|À|Ã|Â|Ä/','A',$texto);
	$texto = preg_replace('/é|è|ê/','e',$texto);
	$texto = preg_replace('/É|È|Ê|Ë/','E',$texto);
	$texto = preg_replace('/í|ì|î|ï/','i',$texto);
	$texto = preg_replace('/Í|Ì|Î|Ï/','I',$texto);
	$texto = preg_replace('/ó|ò|õ|ô|ö/','o',$texto);
	$texto = preg_replace('/Ó|Ò|Ô|Ö|Õ/','O',$texto);
	$texto = preg_replace('/ú|ù|û|ü/','u',$texto);
	$texto = preg_replace('/Ú|Ù|Û|Ü/','U',$texto);

	#parte que tira o cedilha e o ñ
	$texto = preg_replace('/Ç|ç/','c',$texto);
	$texto = preg_replace('/Ñ|ñ/','n',$texto);
	$texto = preg_replace('/\$/','s',$texto);
	return $texto;
}
function separaEmails($emails){
	$emails = str_replace(";",chr(10), $emails);
	$emails = str_replace('\r\n',chr(10), $emails);
	$emails = str_replace('\\r\\n',chr(10), $emails);
	$emails = str_replace(chr(10).chr(10),chr(10), $emails);
	return $emails;
}
function nl2br2($string){
	$string = str_replace(array('\r\n','\r','\n\n','\n'),'<br />',$string);
	return $string;
}
function nl2br_reverso($str){
	$output = str_replace(array("\r\n","\r"),"\n",$str);
	$lines = explode("\n",$output);
	$new_lines = array();

	foreach($lines as $i => $line){
		if(!empty($line)) $new_lines[] = trim($line);
	}
	return implode($new_lines);
}

function substrWord($str,$qtd){
	return substr($str,0,strpos($str,' ',$qtd));
}

function mimetype($filepath){
	if(!preg_match('/\.[^\/\\\\]+$/',$filepath)) {
		$retorno = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filepath);
	}
	switch(strtolower(preg_replace('/^.*\./','',$filepath))) {
        case 'docx': return 'docx';
        case 'docm': return 'docm';
        case 'dotx': return 'dotx';
        case 'dotm': return 'dotm';
        case 'xlsx': return 'xlsx';
        case 'xlsm': return 'xlsm';
        case 'xltx': return 'xltx';
        case 'xltm': return 'xltm';
        case 'xltm': return 'xltm';
        case 'xlam': return 'xlam';
        case 'pptx': return 'pptx';
        case 'pptm': return 'pptm';
        case 'ppsx': return 'ppsx';
        case 'ppsm': return 'ppsm';
        case 'potx': return 'potx';
        case 'potm': return 'potm';
        case 'ppam': return 'ppam';
        case 'sldx': return 'sldx';
        case 'sldm': return 'sldm';
        case 'one': return 'one';
        case 'onetoc2': return 'onetoc2';
		case 'onetmp': return 'onetmp';
		case 'onepkg': return 'onepkg';
		case 'thmx': return 'thmx';
    }
	$retorno = finfo_file(finfo_open(FILEINFO_MIME_TYPE),$filepath);
	$b = explode('/',$retorno);
	$b = end($b);

	return $b;
}

function paises($selected = ''){
	$retorno .= '<select name="pais" id="pais">';
	$retorno .= '<option value="">Selecione</option>';
	$retorno .= '<option value="AF">Afeganistão</option>';
	$retorno .= '<option value="ZA">África do Sul</option>';
	$retorno .= '<option value="AL">Albânia</option>';
	$retorno .= '<option value="DE">Alemanha</option>';
	$retorno .= '<option value="AO">Angola</option>';
	$retorno .= '<option value="SA">Arábia Saudita</option>';
	$retorno .= '<option value="DZ">Argélia</option>';
	$retorno .= '<option value="AR">Argentina</option>';
	$retorno .= '<option value="AM">Armênia</option>';
	$retorno .= '<option value="AU">Austrália</option>';
	$retorno .= '<option value="AT">Áustria</option>';
	$retorno .= '<option value="AZ">Azerbaijão</option>';
	$retorno .= '<option value="BD">Bangladesh</option>';
	$retorno .= '<option value="BS">Bahamas</option>';
	$retorno .= '<option value="BY">Belarus</option>';
	$retorno .= '<option value="BZ">Belize</option>';
	$retorno .= '<option value="BE">Belgica</option>';
	$retorno .= '<option value="BJ">Benim</option>';
	$retorno .= '<option value="BO">Bolívia</option>';
	$retorno .= '<option value="BA">Bósnia Herzegóvina</option>';
	$retorno .= '<option value="BW">Botsuana</option>';
	$retorno .= '<option value="BR">Brasil</option>';
	$retorno .= '<option value="BN">Brunei</option>';
	$retorno .= '<option value="BG">Bulgária</option>';
	$retorno .= '<option value="BF">Burkina Fasso</option>';
	$retorno .= '<option value="BI">Burundi</option>';
	$retorno .= '<option value="BT">Butão</option>';
	$retorno .= '<option value="CM">Camarão</option>';
	$retorno .= '<option value="KH">Camboja</option>';
	$retorno .= '<option value="CA">Canadá</option>';
	$retorno .= '<option value="QA">Catar</option>';
	$retorno .= '<option value="KZ">Cazaquistão</option>';
	$retorno .= '<option value="CN">China</option>';
	$retorno .= '<option value="TD">Chade</option>';
	$retorno .= '<option value="CL">Chile</option>';
	$retorno .= '<option value="CY">Chipre</option>';
	$retorno .= '<option value="PS">Cisjordânia</option>';
	$retorno .= '<option value="CO">Colômbia</option>';
	$retorno .= '<option value="KP">Coréia do Norte</option>';
	$retorno .= '<option value="KR">Coréia do Sul</option>';
	$retorno .= '<option value="CI">Costa do Marfim</option>';
	$retorno .= '<option value="HR">Croácia</option>';
	$retorno .= '<option value="CU">Cuba</option>';
	$retorno .= '<option value="DK">Dinamarca</option>';
	$retorno .= '<option value="EG">Egito</option>';
	$retorno .= '<option value="SV">El Salvador</option>';
	$retorno .= '<option value="AE">Emirados Árabes Unidos</option>';
	$retorno .= '<option value="EC">Equador</option>';
	$retorno .= '<option value="ER">Eritreia</option>';
	$retorno .= '<option value="ES">Espanha</option>';
	$retorno .= '<option value="US">Estados Unidos da América</option>';
	$retorno .= '<option value="EE">Estônia</option>';
	$retorno .= '<option value="ET">Etiópia</option>';
	$retorno .= '<option value="FJ">Fiji</option>';
	$retorno .= '<option value="PH">Filipinas</option>';
	$retorno .= '<option value="FI">Finlândia</option>';
	$retorno .= '<option value="FR">França</option>';
	$retorno .= '<option value="GA">Gabão</option>';
	$retorno .= '<option value="GM">Gâmbia</option>';
	$retorno .= '<option value="GH">Gana</option>';
	$retorno .= '<option value="GE">Georgia</option>';
	$retorno .= '<option value="GR">Grécia</option>';
	$retorno .= '<option value="GL">Groelândia</option>';
	$retorno .= '<option value="GT">Guatemala</option>';
	$retorno .= '<option value="GY">Guiana</option>';
	$retorno .= '<option value="GN">Guiné</option>';
	$retorno .= '<option value="GW">Guiné Bissau</option>';
	$retorno .= '<option value="GQ">Guiné Equatorial</option>';
	$retorno .= '<option value="HT">Haiti</option>';
	$retorno .= '<option value="NL">Holânda</option>';
	$retorno .= '<option value="HN">Honduras</option>';
	$retorno .= '<option value="HU">Hungria</option>';
	$retorno .= '<option value="YE">Iêmen</option>';
	$retorno .= '<option value="FK">Ilhas Falkland</option>';
	$retorno .= '<option value="SB">Ilhas Salomão</option>';
	$retorno .= '<option value="IN">Índia</option>';
	$retorno .= '<option value="ID">Indonésia</option>';
	$retorno .= '<option value="IE">Irlanda</option>';
	$retorno .= '<option value="IR">Irã</option>';
	$retorno .= '<option value="IQ">Iraque</option>';
	$retorno .= '<option value="IL">Israel</option>';
	$retorno .= '<option value="IS">Islândia</option>';
	$retorno .= '<option value="IT">Itália</option>';
	$retorno .= '<option value="JM">Jamaica</option>';
	$retorno .= '<option value="JP">Japão</option>';
	$retorno .= '<option value="DJ">Jibuti</option>';
	$retorno .= '<option value="JO">Jordânia</option>';
	$retorno .= '<option value="_1">Kosovo</option>';
	$retorno .= '<option value="KW">Kuwait</option>';
	$retorno .= '<option value="LA">Laos</option>';
	$retorno .= '<option value="LS">Lesoto</option>';
	$retorno .= '<option value="LV">Letônia</option>';
	$retorno .= '<option value="LB">Líbano</option>';
	$retorno .= '<option value="LR">Libéria</option>';
	$retorno .= '<option value="LY">Líbia</option>';
	$retorno .= '<option value="LT">Lituânia</option>';
	$retorno .= '<option value="LU">Luxemburgo</option>';
	$retorno .= '<option value="MK">Macedônia</option>';
	$retorno .= '<option value="MG">Madagascar</option>';
	$retorno .= '<option value="MY">Malásia</option>';
	$retorno .= '<option value="MW">Malawi</option>';
	$retorno .= '<option value="ML">Mali</option>';
	$retorno .= '<option value="MA">Marrocos</option>';
	$retorno .= '<option value="MR">Mauritânia</option>';
	$retorno .= '<option value="MX">México</option>';
	$retorno .= '<option value="MZ">Moçambique</option>';
	$retorno .= '<option value="MD">Moldávia</option>';
	$retorno .= '<option value="MN">Mongólia</option>';
	$retorno .= '<option value="ME">Montenegro</option>';
	$retorno .= '<option value="MM">Myanmar</option>';
	$retorno .= '<option value="NA">Namíbia</option>';
	$retorno .= '<option value="NP">Nepal</option>';
	$retorno .= '<option value="NI">Nicarágua</option>';
	$retorno .= '<option value="NE">Níger</option>';
	$retorno .= '<option value="NG">Nigéria</option>';
	$retorno .= '<option value="NZ">Nova Zelândia</option>';
	$retorno .= '<option value="NO">Noruega</option>';
	$retorno .= '<option value="NC">Nova Caledónia</option>';
	$retorno .= '<option value="OM">Omã</option>';
	$retorno .= '<option value="PA">Panamá</option>';
	$retorno .= '<option value="PG">Papua Nova Guiné</option>';
	$retorno .= '<option value="PK">Paquistão</option>';
	$retorno .= '<option value="PY">Paraguai</option>';
	$retorno .= '<option value="PL">Polônia</option>';
	$retorno .= '<option value="PR">Porto Rico</option>';
	$retorno .= '<option value="PT">Portugal</option>';
	$retorno .= '<option value="PE">Perú</option>';
	$retorno .= '<option value="KE">Quênia</option>';
	$retorno .= '<option value="KG">Quirguistão</option>';
	$retorno .= '<option value="GB">Reino Unido</option>';
	$retorno .= '<option value="RO">Romênia</option>';
	$retorno .= '<option value="CF">República Centro Africana</option>';
	$retorno .= '<option value="CD">República Democratica do Congo</option>';
	$retorno .= '<option value="CG">República do Congo</option>';
	$retorno .= '<option value="DO">República Dominicana</option>';
	$retorno .= '<option value="CZ">República Tcheca</option>';
	$retorno .= '<option value="_0">República Turca de Chipre do Norte</option>';
	$retorno .= '<option value="RW">Ruanda</option>';
	$retorno .= '<option value="RU">Russia</option>';
	$retorno .= '<option value="_2">Saara Ocidental</option>';
	$retorno .= '<option value="SN">Senegal</option>';
	$retorno .= '<option value="SL">Serra Leoa</option>';
	$retorno .= '<option value="RS">Sérvia e Montenegro</option>';
	$retorno .= '<option value="SY">Síria</option>';
	$retorno .= '<option value="SK">Slováquia</option>';
	$retorno .= '<option value="SI">Slovênia</option>';
	$retorno .= '<option value="SO">Somália</option>';
	$retorno .= '<option value="_3">Somalilândia</option>';
	$retorno .= '<option value="LK">Sri Lanka</option>';
	$retorno .= '<option value="SZ">Suazilândia</option>';
	$retorno .= '<option value="SD">Sudão</option>';
	$retorno .= '<option value="SS">Sudão do Sul</option>';
	$retorno .= '<option value="CH">Suíça</option>';
	$retorno .= '<option value="SE">Suécia</option>';
	$retorno .= '<option value="SR">Suriname</option>';
	$retorno .= '<option value="TH">Tailândia</option>';
	$retorno .= '<option value="TW">Taiwan</option>';
	$retorno .= '<option value="TJ">Tajiquistão</option>';
	$retorno .= '<option value="TZ">Tanzânia</option>';
	$retorno .= '<option value="TF">Terras Austrais e Antárticas Francesas</option>';
	$retorno .= '<option value="TL">Timor Leste</option>';
	$retorno .= '<option value="TG">Togo</option>';
	$retorno .= '<option value="TT">Trindade e Tobago</option>';
	$retorno .= '<option value="TN">Tunísia</option>';
	$retorno .= '<option value="TR">Turquia</option>';
	$retorno .= '<option value="TM">Turquemenistão</option>';
	$retorno .= '<option value="UA">Ucrânia</option>';
	$retorno .= '<option value="UG">Uganda</option>';
	$retorno .= '<option value="UY">Uruguai</option>';
	$retorno .= '<option value="UZ">Uzbequistão</option>';
	$retorno .= '<option value="VU">Vanuatu</option>';
	$retorno .= '<option value="VE">Venezuela</option>';
	$retorno .= '<option value="VN">Vietnã</option>';
	$retorno .= '<option value="ZM">Zâmbia</option>';
	$retorno .= '<option value="ZW">Zimbabue</option>';
	$retorno .= '</select>';
	if (!!$selected){
		$retorno .= '<script>$("#pais").val("'.$selected.'");</script>';
	}
	echo $retorno;
}
?>