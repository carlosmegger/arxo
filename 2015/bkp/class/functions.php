<?php
require_once('mysql.php');
class Functions {
	
	public static function corrigeNome($texto){
		//desconvertendo do padrão entity (tipo &aacute; para á)
		$texto = html_entity_decode($texto);
	
		if(strrpos($texto,'.') != false) {
			$quebraTexto = explode('.',$texto);
			$terminacao = end($quebraTexto); 
			$texto = $quebraTexto[0];  
		}
		//tirando os acentos
		$texto = self::tiraAcento($texto);
		//trocando espaço em branco por underline
		$texto = preg_replace('/ /','_',$texto);
		$texto = preg_replace('/--/','',$texto);
		//tirando outros caracteres invalidos
		$texto = preg_replace('/[^a-zA-Z0-9_\-]/i','',$texto);
		//trocando duplo espaço (underline) por 1 underline só
		while (preg_match('/__/',$texto) > 0){
			$texto = preg_replace('/__/','_',$texto);
		}
		$texto = DB::anti_injection($texto);
	
		if (isset($terminacao)){
			return strtolower($texto.'.'.$terminacao);
		} else {
			return strtolower($texto);
		}
	}
	
	public static function montaTag($texto){
		//desconvertendo do padrão entitie (tipo &aacute; para á)
		$texto = html_entity_decode($texto);
	
		$texto = self::tiraAcento($texto);
	   
		$texto = preg_replace('/[^a-zA-Z0-9\_\-\s]+/','',$texto);
		$texto = trim($texto);
		//trocando espaço em branco por underline
		$texto = str_replace('  ',' ',$texto);
		$texto = str_replace(' ','-',$texto);
		$texto = str_replace('/','-',$texto);
		//trocando duplo espaço (underline) por 1 underline só
		$texto = str_replace('--','-',$texto);
	
		return strtolower($texto);
	}
	
	public static function tiraAcento($texto){
		//tirando os acentos
		$texto = str_replace(array('Á','À','Ã','Â','Ä'),'A',$texto);
		$texto = str_replace(array('á','à','ã','â'),'a',$texto);
		
		$texto = str_replace(array('É','Ê','È','Ë'),'E',$texto);
		$texto = str_replace(array('é','è','ê','ë'),'e',$texto);
		
		$texto = str_replace(array('Í','Î','Ï'),'I',$texto);
		$texto = str_replace(array('í','î','ï'),'i',$texto);
		
		$texto = str_replace(array('Ó','Õ','Ô'),'O',$texto);
		$texto = str_replace(array('õ','ó','ô'),'o',$texto);
		
		$texto = str_replace('Ú','U',$texto);
		$texto = str_replace(array('û','ú'),'u',$texto);
		
		$texto = str_replace('ç','c',$texto);
		$texto = str_replace('Ç','C',$texto);
		$texto = str_replace('ñ','n',$texto);
		$texto = str_replace('Ñ','N',$texto);
		$texto = str_replace('$','S',$texto);
		$texto = str_replace("'",'&#039',$texto);
	
		return $texto;
	}

	public static function formataNumero($data){
		if (strlen($data) == 1){
			return '0'.$data;
		} else {
			return $data;
		}
	}

	public static function converteData($data,$formato){
		if (($data == NULL) || ($data == '')){
			return NULL;
		}
		$data = str_replace(array('/','.'),'-',$data);
		$aux = date_parse($data);
		$retorno = '';
		$expr = array('a','à','A','À');
		
		for ($i = 0; $i < strlen($formato); $i++){
			if ($formato[$i] == 'Y'){
				$retorno .= $aux['year'];
			} else if ($formato[$i] == 'y'){
				$retorno .= substr($aux['year'],2);
			} else if ($formato[$i] == 'm'){
				$retorno .= self::formataNumero($aux['month']);
			} else if ($formato[$i] == 'd'){
				$retorno .= self::formataNumero($aux['day']);
			} else if ($formato[$i] == 'H'){
				$retorno .= self::formataNumero($aux['hour']);
			} else if ($formato[$i] == 'i'){
				$retorno .= self::formataNumero($aux['minute']);
			} else if ($formato[$i] == 's'){
				if (!in_array($formato[$i-1],$expr)){
					$retorno .= self::formataNumero($aux['second']);
				} else {
					$retorno .= $formato[$i];
				}
			} else {
				$retorno .= $formato[$i];
			}
		}
		
		return $retorno;
	}

	public static function filterEmail($email){
		return filter_var($email,FILTER_SANITIZE_EMAIL);
	}
}