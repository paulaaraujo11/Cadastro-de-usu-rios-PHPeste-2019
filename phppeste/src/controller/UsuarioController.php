<?php
 declare(strict_types=1);

 class UsuarioController{
 	//CRUD para campo usuario

 	private $conexao;

 	public function __construct(){
 		$this->conexao = (new Conexao) -> abrir();
 	}

 	public function listarAction(): void {

 		$usuarios = $this->conexao->query('SELECT * FROM tb_usuarios')->fetch_all();

 		include_once '../src/view/usuario/listar.phtml';
 	}
 	public function novoAction(): void {
 		if ($_POST) {
 			$nome = $_POST['nome'];
 			$email = $_POST['email'];
 			$senha =password_hash($_POST['senha'],PASSWORD_ARGON2I);//senha criptografada
 			$criado_em = (new DateTime)->format('d/m/Y H:i:s');

 			$this->conexao->query("INSERT INTO tb_usuarios(nome,email,senha, criado_em) VALUES('$nome','$email','$senha','$criado_em');");

 			header('location: /usuarios');
 		}
 		
 		include_once '../src/view/usuario/novo.phtml';
 	}

 	public function excluirAction():void{
 		$id = $_GET['id'];

 		$this->conexao->query("DELETE FROM tb_usuarios WHERE id='$id'");

 		header('location: /usuarios');
 	}

 	public function editarAction():void{
 		$id = $_GET['id'];

 		if ($_POST){
 			$nome = $_POST['nome'];
 			$email = $_POST['email'];

 			$senha = '';
 			if ($_POST['senha'] !== ''){
 				$senha  = password_hash($_POST['senha'],PASSWORD_ARGON2I);
 				$senha = ",senha='{$senha}' ";
 			}

 			$this->conexao->query("UPDATE tb_usuarios SET nome ='{$nome}',
 				email = '{$email}' $senha WHERE id='{$id}' ");

 				header('location: /usuarios');
 		}

 		$resultado = $this->conexao->query("SELECT * FROM tb_usuarios WHERE id='$id'");

 		$usuario = $resultado->fetch_assoc();

 		include_once '../src/view/usuario/editar.phtml';
 	}
 }