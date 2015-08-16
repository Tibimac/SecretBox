<?php
	//+=====================================================================================================+	
	//|											Classe Cartes Bancaires										|
	//+=====================================================================================================+
	class Cb extends Secret
	{
		private $titulaire;
		private $numero;
		private $date_expiration;
		private $type_cb;
		
		//Constructeur
		public function __construct($id, $titre, $table, $titulaire, $numero, $date_expiration, $type_cb)
		{
			parent:: __construct($id, $titre, $table);
			$this->titulaire = $titulaire;
			$this->numero = $numero;
			$this->date_expiration = $date_expiration;
			$this->type_cb = $type_cb;
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
				if($label != "titulaire")
				{
					switch($label)
					{
						case "numero" : $label = "numéro";
							break;
						case "date_expiration" : $label = "date d'expiration";
							break;
						case "type_cb" : $label = "type";
							break;
					}
				}
				if($label != "id_secret" && $label != "titre" && $label != "table")
				{
					echo "<p class='value'><span class='label'>".ucfirst($label)." : </span><span>".stripslashes($valeur)."</span></p>"; // Affichage nom variable et valeur variable
				}
			}
		}
	}
?>