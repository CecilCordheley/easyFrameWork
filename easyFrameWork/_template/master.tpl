<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <title>TEST EasyTemplate |{var:title}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="_css/style.css">
    </head>
    <body>
        <div class="container">
            <footer>Ici le pied de page</footer>
            <main>{var:mainContent}</main>
            <header>
            <h1>easyFrameWork</h1>
            <menu>
            {LOOP:menu}
            <li>
                <a href="{#href#}">{#pageName#}</a>
            </li>
            {/LOOP}
            </menu>
            </header>
        </div>
    </body>
</html>