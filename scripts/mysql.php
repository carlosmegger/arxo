<?
function ultimoID(){
	$sql = "SELECT LAST_INSERT_ID()";
	$query = mysql_query($sql);
	return mysql_result($query,0);
}
function selecionar($campos,$tabela,$condicao,$debug = false){
	if(($campos == '') || ($campos == NULL)){
		$sql = "SELECT * FROM ".$tabela;
	} else {
		$sql = "SELECT ".$campos." FROM ".$tabela;		
	}
	if($condicao != '') $sql .= " ".$condicao;
	if($debug) echo $sql.'<br>';
	$resultado = mysql_query($sql);
	return $resultado;
}
function deletar($tabela,$condicao,$debug = false){
	if(($tabela == '') || ($condicao == '') || ($tabela == NULL) || ($condicao == NULL)){ // medidas de segurança
		return false;
	}
	$sql = "DELETE FROM ".$tabela ." ".$condicao;
	if ($debug) echo $sql.'<br>';
	mysql_query($sql);
}
function inserir($tabela,$campos,$valores,$debug = false){
	$sql = "INSERT INTO ".$tabela." (".$campos.") VALUES (".$valores.")";
	if($debug) echo $sql.'<br>';
	mysql_query($sql);
}
function atualizar($tabela,$dados,$condicao,$debug = false){
	$sql = "UPDATE ".$tabela." SET ";
	for($i = 0; $i < sizeof($dados); $i++){
		$sql .= $dados;
		if($i < sizeof($dados) -1) $sql .= " AND ";
	}

	if(($condicao == '') || ($condicao == NULL)){ #medidas de segurança
		return false;
	} else {		
		$sql .= " WHERE ".$condicao;
	}
	if($debug == true) echo $sql.'<br>';
	mysql_query($sql);
}
function contar($tabela,$condicao,$debug = false){
	$sql = "SELECT COUNT(*) AS num FROM ".$tabela." ".$condicao;
	if ($debug) echo $sql.'<br>';
	$query = mysql_query($sql);
	$numero = mysql_fetch_assoc($query);
	return $numero["num"];
}
?>