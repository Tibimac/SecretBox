<?php
	//+=================================================================================+	
	//|						Classe Licence						|
	//+=================================================================================+
	class Licence extends Secret
	{
		private $application;
		private $version;
		private $description;
		private $societe;
		private $url;
		private $numero;
		private $clef;
		private $date_achat;
		private $nom;
		private $email;
		private $notes;
		
		//Constructeur
		public function __construct($id, $titre, $table, $application, $version, $description, $societe, $url, $numero, $clef, $date_achat, $nom, $email, $notes)
		{
			parent::__construct($id, $titre, $table);
			$this->application = $application;
			$this->version = $version;
			$this->description = $description;
			$this->societe = $societe;
			$this->url = $url;
			$this->numero = $numero;
			$this->clef = $clef;
			$this->date_achat = $date_achat;
			$this->nom = $nom;
			$this->email = $email;
			$this->notes = $notes;
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
			$object_vars = get_object_vars($this); // Récupération des variables de l'objet et de leur valeur dans un tableau
			foreach($object_vars as $label => $valeur) // Parcours du tableau (associatif)
			{
				if($label == "url" || $label == "numero" || $label == "date_achat" || $label == "email" || $label == "description" || $label == "notes" || $label == "societe") //Redéfinition de certains labels pour l'affichage et agrémentation de certaines valeurs
				{
					switch($label)
					{
						case "societe" : $label = "société";
							break;
						case "url" : $label = "site web";
								   $valeur = "<a href='http://".$valeur."' target='_blank'>".$valeur."</a>";
							break;
						case "numero" : $label = "numéro";
							break;
						case "date_achat" : $label = "date d'achat";
							break;
						case "email" : $valeur = "<a href='mailto:$valeur'>$valeur</a>";
							break;
						case "description" : $valeur = htmlspecialchars($valeur);
							break;
						case "notes" : $valeur = htmlspecialchars($valeur);
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