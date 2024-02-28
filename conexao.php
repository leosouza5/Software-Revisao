<?php 

	Class Conexao {

		private $conexao;
		private $host = 'localhost';
		private $dbname = 'projeto';
		private $user = 'postgres';
		private $pass = '050623';






		public function conectar(){

			
			

			try {

				$conexao = new PDO(
					"pgsql:host=$this->host;dbname=$this->dbname",
					"$this->user",
					"$this->pass"
				);

				return $conexao;

				
			} catch (PDOException $e) {
				echo "<p>" . $e->getMessage() . "</p>";
			}

		}

		public function getConexao() {
	        return $this->conexao;
	    }


	}
?>