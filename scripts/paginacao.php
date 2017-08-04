<?
class Paginacao {

	private $pagina;
	private $maximo;
	private $anterior;
	private $prox;
	private $inicio;
	private $total;

	public function __construct($tabela,$param = '',$query = '',$pagina = 1,$maximo = 20){
		
		// Declaraçao da página inicial 
		if($pagina == "") { 
			$this->pagina = "1";
		} else { 
			$this->pagina = intval($pagina);
		}
		// Máximo de registros por página 
		$this->maximo = intval($maximo);
		// Calculando o registro inicial
		$this->inicio =  $this->pagina - 1;
		$this->inicio *= $this->maximo;
		
		// Calculando pagina anterior 
		$this->anterior = $this->pagina - 1;
		
		// Calculando pagina posterior 
		$this->prox = $this->pagina + 1;
		if($query){
			$this->total = mysql_num_rows(mysql_query($query));
		} else {
			$this->total = contar($tabela,$param);
		}
		
		//listando as páginas
		$pgs = $this->total / $this->maximo;
		$this->formatado = ceil($pgs);
	}
	public function setTotal($total){
		$this->total = intval($total);
		$pgs = $this->total / $this->maximo; 
		$this->formatado = ceil($pgs);
	}
	public function getInicio(){
		return $this->inicio;
	}
	public function getTotal(){
		return $this->total;
	}
	public function getContador(){
		$resultados  = ($this->inicio > 0) ? $this->inicio : 0;
		$resultados .= " de ";
		$resultados .= ($this->total > 0) ? $this->total : 0;
		
		return $resultados." registros";
	}
	
	public function getPaginacao($page, $vars = ''){
		if ($this->formatado > 1){
			if($this->total > $this->maximo) {
				$x = $this->maximo;
				$i = 1;
				$campos = "<strong>Paginação:</strong>&nbsp;";
				//se não for a primeira página, coloca este link
				if(($this->pagina != NULL) && ($this->pagina != 1)){
					$campos .= '<a href="'.$page.'?pagina=1'.$vars.'">&laquo;</a>&nbsp;';
				}

				while ($x < $this->total + $this->maximo){ // Calcula o número de cada página
					if($i == $this->pagina){
						$campos .= '<span class="atual">'.$i.'</span>&nbsp;';
						//páginas antes e depois da atual
					}
					elseif(($i >= ($this->pagina - 4)) && (($i <= ($this->pagina + 4)))) {
						$campos .= '<a href="'.$page.'?pagina='.$i.$vars.'">'.$i.'</a>&nbsp;';
					}
					$x += $this->maximo;
					$i++;
				}
				
				//se não for a última página, coloca este link
				if($this->pagina != ($i-1)){
					$campos .= '<a href="'.$page.'?pagina='.($i-1).$vars.'">&raquo;</a>';
				}
				return $campos;
			}
		}
	}

	public function temPaginacao(){
		return ($this->formatado > 1);
	}
}
?>