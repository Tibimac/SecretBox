<table class="table">			
	<tr>
		<td colspan="2">
			<label for="titre" class="required">Titre* :</label>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="text" name="titre" id="titre" value="<?php if(isset($titre)){ echo $titre;}?>"/>
		</td>
	</tr>
	<tr>
		<td>
			<label for="application">Application :</label>
		</td>
		<td>
			<label for="version">Version :</label>
		</td>
	</tr>	
	<tr>
		<td>
			<input type="text" name="application" id="application" value="<?php if(isset($application)){ echo $application;} ?>"/>
		</td>
		<td>
			<input type="text" name="version" id="version" value="<?php if(isset($version)){ echo $version;} ?>"/>
		</td>
	</tr>	
	<tr>
		<td colspan="2">
			<label for="description">Description :</label><br/>
			<textarea type="text" name="description" id="description"><?php if(isset($description)){ echo $description;} ?></textarea>
		</td>
	</tr>
	<tr>	
		<td colspan="2">
			<label for="societe">Société :</label>
		
			<input type="text" name="societe" id="societe" value="<?php if(isset($societe)){ echo $societe;} ?>"/>
		</td>
	</tr>	
	<tr>	
		<td colspan="2">
			<label for="url">Site Web :</label>
			<span class="aide">http://</span>
			<input type="text" name="url" id="url" value="<?php if(isset($url)){ echo $url;} ?>"/>
		</td>
	</tr>
	<tr>
		<td>
			<label for="numero">Numéro :</label>
		</td>
		<td>
			<label for="clef">Clef :</label>
		</td>
	</tr>
	<tr>
		<td>
			<input type="text" name="numero" id="numero" value="<?php if(isset($numero)){ echo $numero;} ?>"/>
		</td>
		<td>
			<input type="text" name="clef" id="clef" value="<?php if(isset($clef)){ echo $clef;} ?>"/>
		</td>
	</tr>
	<tr>
		<td id="test">
			<label for="date_achat">Date d'achat :</label>
		
			<input type="text" name="date_achat" id="date_achat" value="<?php if(isset($date_achat)){ echo $date_achat;} ?>"/>
		</td>
		<td>
			<span id="v-align-sup" class="aide">(jj/mm/aaaa)</span>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<label for="nom">Nom :</label>
		
			<input type="text" name="nom" id="nom" value="<?php if(isset($nom)){ echo $nom;} ?>"/>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<label for="email">Email :</label>
		
			<input type="text" name="email" id="email" value="<?php if(isset($email)){ echo $email;} ?>"/>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<label for="notes">Notes :</label><br/>
			<textarea type="text" name="notes" id="notes"><?php if(isset($notes)){ echo $notes;} ?></textarea>
		</td>
	</tr>
</table>