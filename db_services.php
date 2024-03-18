<?php 

	require_once "conexao.php";

	
	

	Class DbService {

		private $conexao;

		public function __construct() {
			$this->conexao = (new Conexao())->conectar();
		}



		


		public function inserir($sql) {


			try {

				
				$conexao = new Conexao();
				$pdo = $conexao->conectar();



				


				$stmt = $pdo->prepare($sql);
	
				#echo $sql;


				if($stmt->execute()){

				    return true; 

				}else{
				    
				    print_r($stmt->errorInfo());
				}
					
			} catch (PDOException $e) {
				return $e;
			}
		}





		public function recuperar($campos,$tabela,$where,$order){
			try {

				
				$conexao = new Conexao();
				$pdo = $conexao->conectar();

				$tabela = 'leonardo.' . $tabela;



				$sql = "SELECT $campos FROM $tabela";

				if(!empty($where)){
					$sql .= " WHERE $where";
				}

				if (!empty($order)) {
		            $sql .= " ORDER BY $order";
		        }


		       #echo $sql;


				$stmt = $pdo->prepare($sql);
				#$stmt->bindParam(':campo', $campo);
				#$stmt->bindParam(':id', $id);
				
				if($stmt->execute()){

				     $resultados = $stmt->fetchALL(PDO::FETCH_ASSOC);
				     return $resultados;

				}else{
				    
				    print_r($stmt->errorInfo());
				}

				
			} catch (PDOException $e) {
				return $e;
			}
		}

		public function atualizar($tabela,$set,$where){

			try {
				
				$conexao = new Conexao();
				$pdo = $conexao->conectar();

				$tabela = 'leonardo.' . $tabela;



				$sql = "UPDATE $tabela SET " . $set;

				if(!empty($where)){
					$sql .= " WHERE $where";
				}

				if (!empty($order)) {
		            $sql .= " ORDER BY $order";
		        }


		       #echo $sql;


				$stmt = $pdo->prepare($sql);
				#$stmt->bindParam(':campo', $campo);
				#$stmt->bindParam(':id', $id);
				
				if($stmt->execute()){

				     $resultados = $stmt->fetchALL(PDO::FETCH_ASSOC);
				     return $resultados;

				}else{
				    
				    print_r($stmt->errorInfo());
				}

				
			} catch (PDOException $e) {
				return $e;
			}

		}

		public function remover($tabela,$where){

			try {
				
				$conexao = new Conexao();
				$pdo = $conexao->conectar();

				$tabela = 'leonardo.' . $tabela;



				$sql = "DELETE FROM " . $tabela;

				if(!empty($where)){
					$sql .= " WHERE $where";
				}

		       #echo $sql;


				$stmt = $pdo->prepare($sql);

				
				if($stmt->execute()){

				     $resultados = $stmt->fetchALL(PDO::FETCH_ASSOC);
				     return $resultados;

				}else{
				    print_r($stmt->errorInfo());
				}

				
			} catch (PDOException $e) {
				return $e;

			}


		}


		public function personalizado($sql){
			try {

				
				$conexao = new Conexao();
				$pdo = $conexao->conectar();
				
				$stmt = $pdo->prepare($sql);
				
				if($stmt->execute()){

				     $resultados = $stmt->fetchALL(PDO::FETCH_ASSOC);
				     return $resultados;

				}else{
				    
				    print_r($stmt->errorInfo());
				}

				
			} catch (PDOException $e) {
				return $e;
			}
		}
	}



	if(isset($_GET['metodo']) && $_GET['metodo'] != ''){

		$dados = array();

		$metodo = base64_decode($_GET['metodo']);
		$resultados = explode(';',$metodo);

		foreach($resultados as $resultado){
			list($chave,$valor) = explode(':',$resultado);
			
			$dados[$chave] = $valor;

		}

		#print_r($dados);

		$operacao = $dados['funcao'];

		switch($operacao){
			case 'recuperar' :
				$where = $dados['where'] == 'nada' ? '' : $dados['where'];
				$tabela = $dados['tabela'];
				$campos = $dados['campos'];
				$orderby = $dados['orderby'] == 'nada' ? '' : $dados['orderby'];

				$conexao = new DbService();
				$resultado = json_encode($conexao->recuperar($campos,$tabela,$where,$orderby));
				header('Content-Type: application/json');
				echo $resultado;

				break;
		};


	}




?>