<!--ICI LE TEMPLATE SPECIFIQUE DE VOTRE PAGE-->
<div class="row">
    <div class="list col-12 col-lg-4">
        <div class="list-group">

        {LOOP:classList}
        <a href="?className={#className#}" class="list-group-item list-group-item-action">{#className#}</a>
        {/LOOP}
        </div>
    </div>
    <div class="content col-12 col-lg-8">
        {:IF {var:className}! }
        <h2>{:GET name="className"}</h2>
        <p>{var:descClass}</p>
        <div class="accordion" id="accordionExample">
        {LOOP:method}
        <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{#index#}" aria-expanded="true" aria-controls="collapseOne">
                {#name#}
            </button>
        </h2>
        <div id="collapse{#index#}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
           {#desc#}
          {#params#}
          </div>
        </div>
      </div>
        {/LOOP}
        </div>
        {:/IF}
    </div>
</div>