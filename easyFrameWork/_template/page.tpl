<h1>ceci est la page de page.tpl</h1>
<u>{:SESSION name="test"}</u>
<i>{var:contentItalic}</i>
<div>
<span>{var:tabExemple.test}</span>
</div>
<ul>
    {LOOP:maboucle}
    <li>{#content#}</li>
    {/LOOP}
</ul>