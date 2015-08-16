<?php
	//+===========================================================================+	
	//|						Classe Site						|
	//+===========================================================================+
	class Site extends Secret
	{
		private $utilisateur;
		private $password;
		private $url;
		private $description;
	
		//Constructeur
		public function __construct($id, $titre, $table, $utilisateur, $password, $url, $description)
		{
			parent:: __construct($id, $titre, $table);
			$this->utilisateur = $utilisateur;
			$this->password = $password;
			$this->url = $url;
			$this->description = $description;
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
						case "utilisateur" : $label = "nom d'utilisateur";
							break;
						case "password" : $label = "mot de passe";
							break;
						case "url" : $label = "site web";
								   $valeur = "<a href='http://".$valeur."' target='_blank'>".$valeur."</a>";
							break;
						case "description" : $valeur = htmlspecialchars($valeur);
							break;
					}
					
					echo "<p class='value'><span class='label'>".ucfirst($label)." : </span><span>".stripslashes($valeur)."</span></p>"; // Affichage nom variable et valeur variable
				}
			}
		}
	}
?>