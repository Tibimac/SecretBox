<table class="table">			
	<tr>
		<td colspan="2">
			<label for="titre" class="required">Titre* :</label>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="text" name="titre" id="titre" value="<?php if(isset($titre)){ echo $titre;} ?>"/>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<label for="titulaire">Titulaire :</label>
			<input type="text" name="titulaire" id="titulaire" value="<?php if(isset($titulaire)){ echo $titulaire;} ?>"/>
		</td>
	</tr>	
	<tr>
		<td colspan="2">
			<label for="numero">Numéro :</label>
			<input type="text" name="numero" id="numero" value="<?php if(isset($numero)){ echo $numero;} ?>"/>
		</td>
	</tr>	
	<tr>
		<td>
			<label for="date_expiration">Date d'expiration :</label>
			<input type="text" name="date_expiration" id="date_expiration" value="<?php if(isset($date_expiration)){ echo $date_expiration;} ?>"/>
		</td>
		<td>
			<span id="v-align-sup" class="aide">(jj/mm/aaaa)</span>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<label for="type_cb">Type :</label>
			<input type="text" name="type_cb" id="type_cb" value="<?php if(isset($type_cb)){ echo $type_cb;} ?>"/>
		</td>
	</tr>
</table>