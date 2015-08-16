function setFocus(element)
{
	document.getElementById(element).focus();
}


function confirm_delete(article, name, title) 
{
	if(confirm("Attention vous allez supprimer "+article+" "+name+" '"+title+"' !")) 
	{
		return true;
	} 
	else
	{
		return false;
	}
}


function reinitForm(page)
{	
	var formID;
	var i;
	
	switch(page)
	{
		case 'l' : formID = new Array("titre1", "application1", "version1", "description1", "societe", "url", "numero", "clef", "date_achat", "nom", "email", "notes");
			break;
		case 's' : formID = new Array("titre", "utilisateur", "password", "url", "description");
			break;
		case 'cb' : formID = new Array("titre", "titulaire", "numero", "date_expiration", "type_cb");
			break;
		case 'cp': formID = new Array("titre", "banque_name", "numero", "type_compte");
			break;
	}

	for(i = 0; i < formID.length; i++)
	{
		document.getElementById(formID[i]).value = '';
	}
	
	setFocus('titre');
}