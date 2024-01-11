<!--ICI LE TEMPLATE SPECIFIQUE DE VOTRE PAGE-->
<div class="row">
    <div class="list col-12 col-lg-6">
        <div class="list-group">

        {LOOP:classList}
        <a href="?className={#className#}" class="list-group-item list-group-item-action">{#className#}</a>
        {/LOOP}
        </div>
    </div>
    <div class="content col-12 col-lg-6">
        ICI LE CONTENU
    </div>
</div>