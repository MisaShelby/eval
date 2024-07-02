<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Mois</title>
    <style>
        /* Styles CSS facultatifs pour la mise en forme */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<main id="main" class="main"> 
    <section>
    <h2>Détails des Locations pour le Mois et l'année</h2>

    <?php if (!empty($details_mois)) { ?>
        <table>
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Loyer Mensuel</th>
                    <th>Numéro Propriétaire</th>
                    <th>Email Client</th>
                    <th>Commission</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($details_mois as $detail) { ?>
                    <tr>
                        <td><?php echo $detail['reference']; ?></td>
                        <td><?php echo $detail['loyer']; ?> Ar</td>
                        <td><?php echo $detail['numero_proprio']; ?></td>
                        <td><?php echo $detail['email_client']; ?></td>
                        <td><?php echo $detail['comission']; ?> %</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>Aucun détail trouvé pour ce mois.</p>
    <?php } ?>
</body>
</section>
    </main>

</html>
