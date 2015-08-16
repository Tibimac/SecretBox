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
			<label for="utilisateur">Utilisateur : </label>
			<input type="text" name="utilisateur" id="utilisateur" value="<?php if(isset($utilisateur)){ echo $utilisateur;} ?>"/>
		</td>
	</tr>	
	<tr>
		<td>
			<label for="password">Mot de passe : </label>
			<input type="text" name="password" id="password" value="<?php if(isset($password)){ echo $password;} ?>"/>
		</td>
	</tr>	
	<tr>
		<td>
			<label for="url">Site web :</label>
			<span class="info-form">http://</span>
			<input type="text" name="url" id="url" value="<?php if(isset($url)){ echo $url;} ?>"/>
		</td>
	</tr>
	<tr>	
		<td colspan="2">
			<label for="description">Description :</label>
		</td>
	</tr>
	<tr>
		<td>
			<textarea type="text" name="description" id="description" ><?php if(isset($description)){ echo $description;} ?></textarea>
		</td>
	</tr>
</table>