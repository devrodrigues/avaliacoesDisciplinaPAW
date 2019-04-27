<?php

//classe que vai modelar o estoque
class Estoque{

	private $produtos;


	public function __construct() {
		$this->produtos = array();
	}

	public function addProdutos($produto){
		if(!array_key_exists($produto->descricao(), $this->produtos))
			$this->produtos[$produto->descricao()] = array();
		
		$this->produtos[$produto->descricao()] []= $produto;
	}

	public function removProdutos($descricao){
		return array_shift($this->produtos[$descricao]);
	}

	public function quantidade($descricao) {
		if(!array_key_exists($descricao, $this->produtos))
			return 0;
		
		return count($this->produtos[$descricao]);
	}


}

//classe que representa o produto
class Produto{
	private $descricao;
	private $tipo;
	private $validade;
	private $valor;

	public function __construct($descricao, $tipo, $validade, $valor){
		$this -> descricao = $descricao;
		$this -> tipo = $tipo;
		$this -> validade = $validade;
		$this -> valor = $valor;
    }


	public function altValorUnitario($novoValor){
		$this -> valor  = $novoValor;
	}

	public function descricao(){
		return $this -> descricao;
	}

}

//teste
$cerveja = new Produto('cerveja', 'bebida', 280, 7.99);
$cerveja -> altValorUnitario(8.99);
$detergente = new Produto('detergente', 'produto de limpeza', 365, 2.99);
$detergente2 = new Produto('detergente', 'produto de limpeza', 365, 2.99);
$arroz = new Produto('arroz', 'alimento não perecível', 300, 12.00);
$carne = new Produto('carne', 'alimento perecível', 20, 17.00);
$feijao = new Produto('feijão', 'alimento não perecível', 300, 8.99);

$estoque = new Estoque();
$estoque->addProdutos($cerveja);
$estoque->addProdutos($detergente);
$estoque->addProdutos($detergente2);
$estoque->addProdutos($arroz);
$estoque->addProdutos($carne);
$estoque->addProdutos($feijao);

echo $estoque->quantidade('cerveja');
echo "<br>";
echo $estoque->quantidade('detergente');
echo "<br>";
echo $estoque->quantidade('arroz');
echo "<br>";
echo $estoque->quantidade('carne');
echo "<br>";
echo $estoque->quantidade('feijão');
echo "<br>";
print_r($estoque->removProdutos('detergente'));
echo "<br>";
echo $estoque->quantidade('detergente');
?>