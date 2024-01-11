                               

<?php
/*---------------------------------------------------------------*/
/*
    Titre : Mise en cache d'un site                                                                                       
                                                                                                                          
    URL   : https://phpsources.net/code_s.php?id=395
    Auteur           : forty                                                                                              
    Website auteur   : http://www.toplien.fr/                                                                             
    Date édition     : 27 Mai 2008                                                                                        
    Date mise à jour : 22 Sept 2019                                                                                      
    Rapport de la maj:                                                                                                    
    - fonctionnement du code vérifié                                                                                    
*/
/*---------------------------------------------------------------*/
// répertoire contenant les fichiers cache
define ('REPERTOIRE_CACHE', rtrim($_SERVER['REMOTE_HOST'], '/') . '/cache/');
// durée de vie du cache en seconde : ici 24 heures
define('DUREE_CACHE', 86400);

// détermine le nom du fichier cache en fonction de l'url
function get_cache_name($url) {
    return REPERTOIRE_CACHE . md5($url) . '.html';
}

// supprime le fichier cache si il existe
function delete_cache_file($url) {
    $fichierCache = get_cache_name($url);
    if (@file_exists($fichierCache)) { //si la page existe dans le cache
        @unlink($fichierCache);
    }
}

//envoi le cache
function send_cache($fichierCache) {
    $date_modif = @filemtime($fichierCache);
    if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) &&
        (strtotime(preg_replace('/;.*$/', '', 
         $_SERVER['HTTP_IF_MODIFIED_SINCE'])) >= $date_modif)) {
        header('Status: 304 Not Modified', false, 304);
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $date_modif) . 
' GMT');
        header('Expires: ' . gmdate('D, d M Y H:i:s', $date_modif + DUREE_CACHE)
 . 
' GMT');
        exit;
    } else {
        header('Status: 200 OK', false, 200);
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $date_modif) . 
' GMT');
    }
    while (ob_get_level()) ob_end_clean();
    if ((ini_get('zlib.output_compression') != true) && 
        function_exists('ob_gzhandler')) {
        ob_start('ob_gzhandler');
    } else {
        ob_start();
    } 
    if (@readfile($fichierCache) === false) { 
//si la page n'existe dans le cache
        while (ob_get_level()) ob_end_clean();
        die('Rechargez la page');
    }
    if ((ini_get('zlib.output_compression') == true) || 
        !function_exists('ob_gzhandler')) {
        header('Content-Length: ' . ob_get_length());  
    }
    ob_end_flush();
}

// envoi le fichier cache si il existe, si il date de moins de 24H et si le
// paramètre $send_cache = true
// sinon commence la bufferisation du contenu (avec compression si possible)
function start_buffer($send_cache = true) {
    $fichierCache = get_cache_name('http://' . $_SERVER['HTTP_HOST'] . $_SERVER[
'REQUEST_URI']);
    if ($send_cache && @file_exists($fichierCache) && @filemtime($fichierCache) 
> 
time() - DUREE_CACHE) {
        send_cache($fichierCache);
        exit;
    }
    ignore_user_abort(true);
 //   set_time_limit();
    while (ob_get_level()) ob_end_clean();
    if ((ini_get('zlib.output_compression') != true) && function_exists(
'ob_gzha' .
'ndler')) {
        ob_start('ob_gzhandler');
    } else {
        ob_start();
    } 
}

// sauvegarde le fichier cache si $saveCache = true
// puis termine la bufferisation et envoi le contenu au navigateur
function end_buffer($saveCache = true) {
    if ($saveCache) {
        $fichierCache = get_cache_name('http://' . $_SERVER['HTTP_HOST'] . 
$_SERVER[
'REQUEST_URI']);
        if ($fd = fopen($fichierCache, 'w')) {
            fwrite($fd, ob_get_contents()); 
// on ecrit le contenu du buffer dans le
// fichier cache
            fclose($fd);
        }
        $date_modif = @filemtime($fichierCache);
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $date_modif) . 
' GMT');
        header('Expires: ' . gmdate('D, d M Y H:i:s', $date_modif + DUREE_CACHE)
 . 
' GMT');
    } else {
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    }
    if ((ini_get('zlib.output_compression') == true) || !function_exists(
'ob_gzh' .
'andler')) {
        header('Content-Length: ' . ob_get_length());  
    }
    ob_end_flush();
}

// cette fonction est a appeler en cas d'erreur pour générer le contenu de la
// page (par exemple pour l'accès à la base de données)
// si le fichier existe en cache on envoie ce fichier sinon on envoie une
// erreur
// 503 (reessayer plus tard).
function gere_erreur() {
    $fichierCache = get_cache_name('http://' . $_SERVER['HTTP_HOST'] . $_SERVER[
'REQUEST_URI']);
    if (@file_exists($fichierCache)) {
        send_cache($fichierCache);
    } else {
        while (ob_get_level()) ob_end_clean();  // vide le buffer de sortie
        header('Status: 503 Service Temporarily Unavailable', false, 503);
        header('Retry-After: 3600'); // 1 heure
?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html>
<head>
<title>503 Service Temporarily Unavailable</title>
<meta name="robots" content="none">
</head>
<body>
<h1>Service Temporarily Unavailable</h1>
<p>The server is temporarily unable to service your
request due to maintenance downtime or capacity
problems. Please try again later.</p>
<h1>Service Temporairement indisponible</h1>
<p>Le serveur est temporairement incapable de
répondre à votre requête à cause d'un arrêt du
serveur pour maintenance ou problème.</p>
</body>
</html>
<?php
    }
    exit;
}
?>
<?php
// ce qui suit n'est là que pour servir d'exemple

if (isset($_GET['delete'])) {
    delete_cache_file($_GET['url']);
    header('Status: 301 Move permanently', false, 301);
    header('Location: ' . $_GET['url']);
    exit;
}

start_buffer();
?>
<!DOCTYPE html>
<html>
<head>
<title>Test gestion cache</title>
</head>
<body>
<p>Ce script contient les fonctions pour la gestion du cache. 
Si la date HTTP_IF_MODIFIED_SINCE est renseignée et que le cache n'a pas été
 modifié depuis
cette date, on ne renvoie qu'un statut 304 (Not modified). 
Si les options le permettent le contenu de la page est compressé avant d'être
 envoyé.</p>
<p>La fonction <strong>get_cache_name</strong> permet de déterminer le nom du
 fichier cache en fonction de l'url. 
Les fichiers caches sont sauvegardés dans un répertoire /cache/ à la racine
 du
 site (<?php echo REPERTOIRE_CACHE;?>). 
L'url est encodé avec la fonction md5 pour constituer le nom du fichier suivi
 de
 l'extension .html.
Cette page sera sauvegardée par exemple avec le nom 
<?php echo get_cache_name('http://' . $_SERVER['HTTP_HOST'] . $_SERVER[
'REQUEST_URI']); ?></p>
<p>La fonction <strong>delete_cache_file</strong> permet de supprimer le fichier
 cache en fonction de l'url.</p>
<p>La fonction <strong>start_buffer</strong> permet d'envoyer le fichier cache
 si il existe, si il date de moins de 24H
et si le paramètre de la fonction est true. Elle doit être placée le plus
 haut
 possible dans le script
appelé (avant tout affichage de données). Il est possible de ne pas envoyer le
 fichier en cache en 
mettant false comme paramètre (par exemple pour remplacer le fichier
 cache).</p>
<p>La fonction <strong>end_buffer</strong> permet de sauvegarder le fichier
 cache si le paramètre de la fonction
est true. Le contenu de la page est ensuite envoyée au navigateur. Elle doit
 être placée à la fin des
scripts après la génération du contenu. Il est possible de ne pas sauvegarder
 le
 fichier cache
en mettant false comme paramètre (par exemple quand la page a des paramètres
 POST)</p>
<p>La fonction <strong>gere_erreur</strong> peut être appelée en cas d'erreurs
 (par exemple MYSQL). 
Il faut l'appeler quand on est dans l'impossibilité de générer le contenu de
 la
 page. 
Elle envoie le fichier cache si il existe (même s'il est périmé). Sinon une
 erreur 503 est renvoyée
(Service temporairement indisponible) qui indique aux moteurs de recherche qu'il
 faut revenir
1H plus tard.</p>
<p><a href="cache.php">Rechargez cette page</a> pour voir la version en cache.
 La date et l'heure ci dessous ne doivent pas changer.</p>
<p><a href="cache.php?delete&url=<?php echo urlencode('http://' . $_SERVER[
'HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>">Supprimer le cache</a> pour voir la
 date
 changer.</p>
<p><?php echo gmdate('D, d M Y H:i:s') . ' GMT'; ?></p>
<?php 
// on créé le répertoire cache si il n'existe pas.
if (!@file_exists(REPERTOIRE_CACHE)) {
    @mkdir(REPERTOIRE_CACHE);
}
?>
</body>
</html>
<?php
end_buffer();
?>


                            