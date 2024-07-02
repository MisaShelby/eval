<main id="main" class="main">
    <section>
        <div>
            <input id="myInput" class="form-control" placeholder="Recherche..." />
        </div>

        <div class="row">
            <?php if (!empty($cv)) : ?>
                <?php foreach ($cv as $a) : ?>
                    <div class="col-sm-6" style="margin-top:20px;">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $a['nom']; ?> 🏡</h5>
                                <h6 class="card-text">Reference : <?php echo $a['reference']; ?></h6>
                                <h6 class="card-text">Numero : <?php echo $a['numero']; ?> ☎</h6>
                                <h6 class="card-text">Description : <?php echo $a['description']; ?> ✔️</h6>        
                                <h6 class="card-text">Region : <?php echo $a['region']; ?> 📍</h6>
                                <h6 class="card-text">Loyer : <?php echo $a['loyer']; ?> Ar</h6>
                                <h6 class="card-text">Type bien : <?php echo $a['type_nom']; ?> 🏡</h6>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun bien trouvé.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".col-sm-6").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>
