<h2>Présentation</h2>
<p>easyFrameWork est un FrameWork conçu pour les projets "de faible envergure". Ce FrameWork est basé sur une architecture simple</p>
<ol>
    <li>les pages sont à la racine du projet</li>
    <li>Les Classes sont dans des fichiers <span class="badge bg-secondary">*.class.php</span>
        <ul>
            <li>les classes dans le dossier <span class="badge bg-secondary">./_class/_master/</span> sont automatiquement toutes chargées</li>
            <li>les classes à la racine du dossier <span class="badge bg-secondary">./_class/</span> sont chargées selon leur nécéssité</li>
        </ul>
    </li>
    <li>Dans le dossier <span class="badge bg-secondary">./include/</span> contient : 
        <ul>
            <li>le fichier <span class='badge bg-secondary'>config.ini</span><p>Il regroupe tout les paramètres de base de votre projet</p></li>
            <li>le fichier <span class='badge bg-secondary'>error_model.html</span><p>Il s'agit du modèle HTML permetant d'afficher les erreurs</p></li>
            <li>le fichier <span class='badge bg-secondary'>model_page</span><p>Il s'agit du modèle pour les pages que vous créez via le terminal</p></li>
            <li>le fichier <span class='badge bg-secondary'>router.json</span><p>Il regroupe pour chaque page, les fichier *.js et *.CSS ainsi que la page de *.ctrl.php et la page du *.tpl</p></li>
        </ul>
    </li>
    <li>les contrôles sont gérés via les fichiers
         <span class="badge bg-secondary">*.ctrl.php</span> dans le dossier <span class="badge bg-secondary">./_ctrl/</span></li>
<li>Le dossier ./sqlView/ contient ensemble des "vues" <span class="badge bg-secondary">*.view</span> servant à l'affichage des requêtes SQL </li>
        </ol>
{view:academie}
<a href="ecole-1.html">Voir l'école</a>
<div>{var:userForm}</div>