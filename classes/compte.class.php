<?php
	//+=======================================================================================+	
	//|						Classe Compte Bancaire						|
	//+=======================================================================================+
	class Compte extends Secret
	{
		private $banque_name;
		private $numero;
		private $type_compte;
		
		//COnstructeur
		public function __construct($id, $titre, $table, $banque_name, $numero, $type_compte)
		{
			parent::__construct($id, $titre, $table);
			$this->banque_name = $banque_name;
			$this->numero = $numero;
			$this->type_compte = $type_compte;
		}
		
		public function __get($attribut)
		{
			if(isset($this->$attribut))
			{
				$attr = $this->$attribut;
			}
			else
			{
				$attr = 0;
			}
			return($attr);
		}
		
		public function __set($attribut, $valeur)
		{
			if($attribut == "id_secret" || $attribut == "table")
			{
				$error = 1;
			}
			else
			{
				if(isset($this->$attribut))
				{
					if($attribut == "titre" && empty($valeur))
					{
						$error = 3;
					}
					else
					{
						$this->$attribut = $valeur;
					}
				}
				else
				{
					$error = 2;
				}
			}
			return ($error);
		} 
		
		public function afficher()
		{
			$object_vars = get_object_vars($this); // Récupération des variables et des valeurs de celle-ci dans un tableau
			foreach($object_vars as $label => $valeur) // Parcours du tableau (associatif)
			{
				if($label != "id_secret" && $label != "titre" && $label != "table")
				{
					switch($label)
					{
						case "banque_name" : $label = "banque";
							break;
						case "numero" : $label = "numéro";
							break;
						case "type_compte" : $label = "type";
							break;
					}
					
					echo "<p class='value'><span class='label'>".ucfirst($label)." : </span><span>".stripslashes($valeur)."</span></p>"; // Affichage nom variable et valeur variable
				}
			}
		}
	}
?>