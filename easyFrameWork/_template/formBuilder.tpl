<h2>FormBuilder</h2>
<div class="row">
    <h3>Utilisation basique</h3>
    <p>Le FormBuilder est un composant qui permet de créer des formulaires HTML</p>
    <p>Pour créer un formulaire il convient dans un premier temps d'instancier le formBuilder</p>
    <div class="code col-6">
        <span class="badge">PHP</span>
        <span class="variable">$action</span>="url.php";<span class="comment">//URL vers laquelle le formulaire sera
            transmi</span><br>
        <span class="variable">$method</span>="POST";<span class="comment">//Methode POST ou GET</span><br>
        <span class="variable">$form</span> = new FormBuilder(<span class="variable">$action</span>,
        <span class="variable">$method</span>);
    </div>
    <p>A présent pour chaque composant, on utilise la methode ->addCompoment($param) qui prend en paramètre un tableau.
    </p>
    <div class="code col-6">
        <span class="badge">PHP</span>
        <span class="variable">$form</span>-><span class="methode">addCompoment</span>([<br>
        "ID" => "test",<br>
        "type" => "text",<br>
        'required'=>true,<br>
        "className"=>"testClass",<br>
        "name" => "test_name",<br>
        "label"=>"Ici le nom"<br>
        ]);
    </div>
    <p>Une fois tout les composant paramètrés, il suffit d'utiliser la méthode ->generate()</p>
    <p>Celle-ci va retourner la chaine de caractères HTML qui correspond au formulaire</p>
    <div class="code col-6">
        <span class="badge">PHP</span>
        <span class="variable">$form</span>-><span class="methode">generate()</span>
    </div>
    <p>Voici un exemple simple : </p>
    <div class="code col-6">
        <span class="badge">PHP</span>
        <span class="variable">$form</span> = new FormBuilder("#?action=test","POST");<br>
        <span class="variable">$form</span>-><span class="methode">addCompoment</span>([<br>
        "ID" => "nom",<br>
        "type" => "text",<br>
        "name" => "inputName",<br>
        "value" => "valeur par défaut",<br>
        "label"=>"Ici le nom"<br>
        ]);<br>
        echo <span class="variable">$form</span>-><span class="methode">generate();</span>
    </div>
    <div class="col-6">
        <span class="badge">HTML</span>
        &lt;form action=&quot;#?action=test&quot; method=&quot;POST&quot;&gt;<br>
        &lt;label for=&quot;nom&quot;&gt;Ici le nom&lt;/label&gt;<br>
        &lt;input id=&quot;nom&quot; type=&quot;text&quot; name=&quot;inputName&quot; value=&quot;valeur par
        d&eacute;faut&quot; &gt;
        &lt;button type=&#039;submit&#039;&gt;Valider&lt;/button&gt; &lt;button
        type=&#039;reset&#039;&gt;Effacer&lt;/button&gt; <br>
        &lt;/form&gt;
    </div>
    <div class="col-6">
        <div class="exemple">{var:FormExample1}</div>

    </div>
    <div class="col-6">
        <p>Dans cette exemple, on créer un formulaire basique avec un champs texte et la méthode generate() retourne la
            chaine de caractère HTML </p>
    </div>
    <h3>Utiliser les patterns</h3>
    <p>Il est possible d'utiliser un pattern HTML pour injecter les composants</p>
    <div class="code col-6">
        <span class="badge">PHP</span>
        $pattern="\n&lt;div class='compoment'>\n".<br>
        "\t&lt;label for=\"[#ID#]\">[#label#]&lt;/label>\n".<br>
        "\t&lt;input id=\"[#ID#]\" type=\"[#type#]\" name=\"[#name#]\" value=[#value#] [#required#]>\n".<br>
        "&lt;/div>";<br>
        $form = new FormBuilder("#?action=test", "POST",$pattern);
    </div>
    <p>A présent, les composants respecterons le pattern donné.</p>
    <div class="code col-6">
        <span class="badge">PHP</span>
        $form->addCompoment([<br>
        "ID" => "nom",<br>
        "type" => "text",<br>
        "name" => "inputName",<br>
        "value" => "valeur par défaut",<br>
        "label"=>"Ici le nom"<br>
        ]);<br>
        echo $form->generate();
    </div>
    <div class="col-6">
        &lt;form action=&quot;#?action=test&quot; method=&quot;POST&quot;&gt;<br>
         &lt;div class=&#039;compoment&#039;&gt;<br>
          &lt;label for=&quot;nom&quot;&gt;Ici le nom&lt;/label&gt;<br>
           &lt;input id=&quot;nom&quot; type=&quot;text&quot; name=&quot;inputName&quot; value=&quot;valeur par d&eacute;faut&quot; &gt;<br>
            &lt;/div&gt;<br>
             &lt;button type=&#039;submit&#039;&gt;Valider&lt;/button&gt; &lt;button type=&#039;reset&#039;&gt;Effacer&lt;/button&gt;<br>
              &lt;/form&gt;
    </div>
    <div class="col-6">
        <div class="exemple">{var:FormExample2}</div>
    </div>
    <div class="col-6">
       <p>a présent, les composants sont dans des balises div avec une classe "compoment"
    </p>
    </div>
      
</div>
<!--{var:formTest}-->