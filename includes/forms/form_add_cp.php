<table class="table">			
	<tr>
		<td>
			<label for="titre" class="required">Titre* :</label>
		</td>
	</tr>
	<tr>
		<td>
			<input type="text" name="titre" id="titre" value="<?php if(isset($titre)){ echo $titre;} ?>"/>
		</td>
	</tr>
	<tr>
		<td>
			<label for="banque_name">Banque : </label>
			<input type="text" name="banque_name" id="banque_name" class="fright" value="<?php if(isset($banque_name)){ echo $banque_name;} ?>"/>
		</td>
	</tr>	
	<tr>
		<td>
			<label for="numero">Numéro : </label>
			<input type="text" name="numero" id="numero" class="fright" value="<?php if(isset($numero)){ echo $numero;} ?>"/>
		</td>
	</tr>	
	<tr>
		<td>
			<label for="type_compte">Type :</label>
			<input type="text" name="type_compte" id="type_compte" class="fright" value="<?php if(isset($type_compte)){ echo $type_compte;} ?>"/>
		</td>
	</tr>
</table>