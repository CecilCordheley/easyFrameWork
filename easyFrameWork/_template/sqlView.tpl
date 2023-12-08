<!--ICI LE TEMPLATE SPECIFIQUE DE sqlView.php-->
<p>Les vues SQL permettent d'utiliser un template (modèle) 
    pour des occurences d'une requêtes SQL. Dans notre exemple 
    nous allons créer une vue pour 
    afficher dans un tableau tous les élèves</p>
<h3>1. Créer la vue SQL</h3>
<p>Dans le dossier <strong>sqlView</strong> créer un modèl avec l'extension <i>*.view</i></p>
<code>
    <ul>
        <li>&lt;tr>
            <ul>
                <li>&lt;td>[#NOM_ELEVE#]&lt;/td></li>
                <li>&lt;td>[#PRENOM_ELEVE#]&lt;/td></li>
            </ul>
        </li>
        <li>&lt;/tr></li>
    </ul>
</code>
<h3>2. Utiliser la Class SqlToView</h3>
<p>Pour utiliser des SQL Vues, il faut instancier la SQLFactory</p>
<code>
    <ul>
        <li>$sqlF=new SQLFactoryV2();</li>
        <li>$SQL2V=new SqlToView($sqlF,"sqlView/eleveAll.view");</li>
    </ul>
</code>
<h3>3. Paramétrer l'objet SqlToView</h3>
<code>
    <ul>
        <li>$param=[];</li>
        <li>$param["query"]="SELECT * FROM eleve_tbl";//Requête SQL </li>
        <li>$param["container"]="&lt;table>[...]&lt;/table>";//integration HTML dans laquelle la vue va être appliquée</li>
    </ul>
</code>
<h3>3. Générer la vue</h3>
<code>
    <ul><li>echo $SQL2V->generate($param);</li></ul>
</code>