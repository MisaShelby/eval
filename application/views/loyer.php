<main id="main" class="main"> 
    <section>
        <div class="container">
            <h2 class="mt-5">Les loyers du client du :</h2>
            <form class="form-inline mt-3" method="post" action="<?php echo base_url('Accueil_client/chiffre_affaire_client')?>">
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
                $date_debut = htmlspecialchars($_POST['date_debut']);
                $date_fin = htmlspecialchars($_POST['date_fin']);
                
                // Display the selected dates
                echo "<h3 class='mt-4'>Résultats pour la période du " . $date_debut . " au " . $date_fin . " :</h3>";
                echo "<table class='table table-bordered mt-3'>
                        <thead>
                            <tr>
                                <th>Mois</th>
                                <th>Total Loyer(Ariary)</th>
                                <th>Payé(✔️ ou ❌)</th>
                            </tr>
                        </thead>
                        <tbody>";

                // Initialize total loyer
                $total_loyer = 0;

                foreach ($results as $row) {
                    // Accumulate the totals
                    $total_loyer += $row['total_loyer'];

                    // Determine paye status
                    $paye_status = $row['paye'] == 0 ? 'Non payé ❌' : 'Payé ✔️';
                    
                    echo "<tr>
                            <td>{$row['mois']}</td>
                            <td>{$row['total_loyer']} Ar</td>
                            <td>{$paye_status}</td>
                          </tr>";
                }

                // Display total loyer
                echo "<tr>
                        <td><strong>Total (Ariary)</strong></td>
                        <td><strong>{$total_loyer} Ar</strong></td>
                        <td><strong></strong></td>
                      </tr>";

                echo "  </tbody>
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
