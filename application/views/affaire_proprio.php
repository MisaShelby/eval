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
                $date_debut = htmlspecialchars($_POST['date_debut']);
                $date_fin = htmlspecialchars($_POST['date_fin']);
                
                // Display the selected dates
                echo "<h3 class='mt-4'>Résultats pour la période du " . $date_debut . " au " . $date_fin . " :</h3>";

                echo "<table class='table table-bordered mt-3'>
                        <thead>
                            <tr>
                                <th>Mois</th>
                                <th>Total Loyer(Ar)</th>
                                <th>Total Commission(Ar)</th>
                                <th>Details</th>

                            </tr>
                        </thead>
                        <tbody>";

                // Initialize total loyer and total commission
                $total_loyer = 0;
                $total_commission = 0;

                foreach ($results as $row) {
                    $mois_param = urlencode($row['mois']); // Encodage du mois pour l'URL
                    $details_link = base_url("Accueil_admin/details_mois?mois={$mois_param}"); 
                    // Accumulate the totals
                    $total_loyer += $row['total_loyer'];
                    $total_commission += $row['total_comission'];
                    
                    echo "<tr>
                            <td>{$row['mois']}</td>
                            <td>{$row['total_loyer']} Ar</td>
                            <td>{$row['total_comission']} Ar </td>
                            <td><a href='{$details_link}' class='btn btn-sm btn-info'>Détails</a></td> <!-- Ajout du lien avec le mois comme paramètre -->

                          </tr>";
                }

                // Calculate total chiffre d'affaires
                $total_chiffre_affaires = $total_loyer - $total_commission;

                // Display total loyer, total commission and total chiffre d'affaires
                echo "<tr>
                        <td><strong>Total (Ariary)</strong></td>
                        <td><strong>{$total_loyer} Ar</strong></td>
                        <td><strong>{$total_commission} Ar</strong></td>
                      </tr>";
                echo "<tr>
                        <td colspan='2'><strong>Chiffre d'Affaires Total (Ariary)</strong></td>
                        <td><strong>{$total_chiffre_affaires} Ar</strong></td>
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
