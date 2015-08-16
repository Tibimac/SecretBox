<?php
	//+=================================================================================+
	//|						Classe Secret						|
	//+=================================================================================+
	class Secret
	{
		protected $id_secret;
		protected $titre;
		protected $table;
		
		
		//Constructeur
		public function __construct($id, $titre, $table)
		{
			$this->id_secret = $id;
			$this->titre = $titre;
			$this->table = $table;
		}
		
		public function __get($attribut)
		{
			$attr = 0;
			
			if(isset($this->$attribut))
			{
				$attr = $this->$attribut;
			}
			
			return($attr);
		}
		
		public function __set($attribut, $valeur)
		{
			$error=0;
			
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
	}
?>