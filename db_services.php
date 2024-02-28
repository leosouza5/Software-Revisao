<?php 

	require_once "conexao.php";

	/*$cadprodu_services = new ProdutoService();

 
		if (isset($_GET['metodo']) && method_exists($cadprodu_services, $_GET['metodo'])) {

			$campo = isset($_GET['campo']) ? $_GET['campo'] : null;
			$tabela = isset($_GET['tabela']) ? $_GET['tabela'] : null;
			$where = isset($_GET['where']) ? $_GET['where'] : null;
			$order = isset($_GET['order']) ? $_GET['order'] : null;

		    $cadprodu_services->{$_GET['metodo']}($campo,$tabela,$where,$order);


		} else {
		    echo "Método não encontrado!";
		}*/
	

	Class DbService {

		public function __construct() {
			$this->conexao = (new Conexao())->conectar();
		}


		


		public function inserir($sql) {


			try {

				
				$conexao = new Conexao();
				$pdo = $conexao->conectar();



				


				$stmt = $pdo->prepare($sql);
	
				echo $sql;


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



				$sql = "DELETE FROM leonardo." . $tabela;

				if(!empty($where)){
					$sql .= " WHERE $where";
				}

		       echo $sql;


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


		public function personalizado($sql){
			try {

				
				$conexao = new Conexao();
				$pdo = $conexao->conectar();

				
				echo ' to aqui';



				
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





?>