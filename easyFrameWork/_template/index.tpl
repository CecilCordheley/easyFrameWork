<h2>ICI je suis dans le template index.tpl</h2>
<p>Ici le contenu de la variable de session</p>
{view:academie}
<a href="ecole-1.html">Voir l'école</a>
<div>{var:userForm}</div>
<table>
	<tr>
		<th>NOM</th>
		<th>PRENOM</th>
	</tr>
{LOOP:personne}
<tr>
	<td>{#nom#}</td>	
	<td>{#prenom#}</td>
</tr>
{/LOOP}
</table>