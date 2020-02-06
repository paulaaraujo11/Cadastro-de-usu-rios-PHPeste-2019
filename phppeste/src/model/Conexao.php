<?php

declare(strict_types=1);

class Conexao{
	public function abrir(){
		$dados = include '../config/database.php';

		$conexao = new mysqli(
			$dados['host'],
			$dados['user'],
			$dados['pass'],
			$dados['name'],
		);

		if ($conexao->connect_error){
			die('Erro na conexão com o banco de dados');
		}

		return $conexao;
	}
}