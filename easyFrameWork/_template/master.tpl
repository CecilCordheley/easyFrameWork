<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <title>TEST EasyTemplate |{var:title}</title>
        <link rel="stylesheet" href="_css/style.css">
    </head>
    <body>
        <div class="container">
            <footer>Ici le pied de page</footer>
            <main>{var:mainContent}</main>
            <header>
            <h1>Exemple de site</h1>
            <menu>
            {LOOP:menu}
            <li>
                <a href="{#href#}">{#PageName#}</a>
            </li>
            {/LOOP}
            </menu>
            </header>
        </div>
    </body>
</html>