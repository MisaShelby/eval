<main id="main" class="main"> 
    <section>
        <div class="container">
            <h2 class="mt-5">Chiffre d'Affaires du Proprietaire :</h2>
            <form class="form-inline mt-3" method="post" action="<?php echo base_url('Accueil_proprio/chiffre_affaire_proprio')?>">
                <div class="form-group mb-2">
                    <label for="date_debut" class="sr-only">Date Début</label>
                    <input type="date" class="form-control" id="date_debut" name="date_debut" required>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="date_fin" class="sr-only">Date Fin</label>
                    <input type="date" class="form-control" id="date_fin" name="date_fin" required>
                </div>
                <button type="submit" class="btn btn-primary mb-2">Valider ☑️</button>
            </form>

            <?php
            if (!empty($results)) {
                // Initialize total loyer and total commission
                $total_loyer = 0;
                $total_commission = 0;

                foreach ($results as $row) {
                    // Accumulate the totals
                    $total_loyer += $row['total_loyer'];
                    $total_commission += $row['total_comission'];
                }

                // Calculate total chiffre d'affaires
                $total_chiffre_affaires = $total_loyer - $total_commission;

                // Display the selected dates
                echo "<h3 class='mt-4'>Résultats pour la période du " . htmlspecialchars($_POST['date_debut']) . " au " . htmlspecialchars($_POST['date_fin']) . " :</h3>";

                // Display total loyer, total commission and total chiffre d'affaires
                echo "<table class='table table-bordered mt-3'>
                        <thead>
                            <tr>
                                <th>Total Loyer (Ar)</th>
                                <th>Total Commission (Ar)</th>
                                <th>Chiffre d'Affaires Total (Ar)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>{$total_loyer} Ar</strong></td>
                                <td><strong>{$total_commission} Ar</strong></td>
                                <td><strong>{$total_chiffre_affaires} Ar</strong></td>
                            </tr>
                        </tbody>
                      </table>";
            } else {
                echo "<p class='mt-3'>Aucun résultat trouvé pour les dates sélectionnées.</p>";
            }
            ?>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
