<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        h3 {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0 10px;
        }

        .chiffre {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .chiffre ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .chiffre li {
            font-size: 18px;
            color: #333;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .chiffre li:last-child {
            border-bottom: none;
        }

        input[type="date"]{
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
            opacity: 0.9;
        }

        input[type="submit"] {
            margin-top: 10px;
            width: 100px;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .tab {

            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 500px;
            background-color: #f8f9fa;
            color: #333;
        }

        h3 {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, td {
            border: 1px solid #ddd;
        }

        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: grey;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
        .chart{
            margin-left:500px;
        }
    </style>
</head>
<body>
    <h4>DASHBOARD (Entre deux dates)</h4>
    <div class="selec">
        <span>Choisissez une date :</span>
        <form action="<?= base_url('proprietaire/proprietaire/home') ?>" class="form d-flex" method="post">
            <div class="mx-2">
                date 1:
                <input type="date" name="date1" id="date1">
                date 2:
                <input type="date" name="date2" id="date2">
                <input type="submit" class="btn btn-primary" value="Voir">
            </div>

        </form>
    </div>
    <h3>
        resultat
    </h3>
    <div class="chiffre">
        <ul>
            <?php if(!$chiffre){?>
                <li>Chiffre d'affaire = 0 Ariary</li>
            <?php } else{?>
                <li>Chiffre d'affaire = <?= number_format($chiffre->total_loyer, 0, '', ' ') ?> Ariary</li>
            <?php }?>
        </ul>
    </div>
    <div class="tab">

        <table class="table">
        <thead>
            <tr>                
                <th>Mois</th>                  
                <th>Loyer</th>                
                <th>Mada Immo</th>                
                <th>Chiffre d'affaire</th>                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($locs as $loc) {?>
                <?php if ($loc->loyer_par_mois) {?>
                    <tr>
                    <td><?= $loc->mois_annee?></td>  
                    <td style="text-align: right;"><?= number_format($loc->loyer_par_mois, 0, '', ' ')?>Ar</td>  
                    <td style="text-align: right;"><?= number_format($loc->gain, 0, '', ' ')?>Ar</td>  
                    <td style="text-align: right;"><?= number_format($loc->chiffre, 0, '', ' ')?>Ar</td>  
                    </tr>
                <?php }?>                                
            <?php }?>
            <tr>
                <td style="text-align: right;">TOTAL :</td>
                <td style="text-align: right;"><?= number_format($chiffre->total, 0, '', ' ') ?>Ar</td>
                <td style="text-align: right;"><?= number_format($chiffre->mada_immo, 0, '', ' ') ?>Ar</td>
                <td style="text-align: right;"><?= number_format($chiffre->total_loyer, 0, '', ' ') ?>Ar</td>
            </tr>
        </tbody>
        </table>
        </div>

            <canvas id="bar-chart"></canvas>

</body>
</html>
<script src="<?= base_url('assets/chart-js/Chart.js') ?>"></script>
<script>
    const labels = [];
    const loyerParMoisData = [];
    const gainData = [];

    <?php foreach ($locs as $loc) { ?>
        labels.push('<?= $loc->mois_annee ?>');
        loyerParMoisData.push(<?= $loc->loyer_par_mois ?>);
    <?php } ?>

    const barData = {
        labels: labels,
        datasets: [
            {
                label: 'Loyer par Mois',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                data: loyerParMoisData
            }
        ]
    };

    const contextBar = document.getElementById('bar-chart').getContext('2d');

    const barChart = new Chart(contextBar, {
        type: 'bar',
        data: barData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var date1Input = document.getElementById("date1");
    var date2Input = document.getElementById("date2");

    function validateDates() {
        if (!date1Input.value ||!date2Input.value) {
            alert("Les dates ne doivent pas être vides.");
            return false;
        }
        return true;
    }

    // Ajoutez un écouteur d'événements pour le formulaire
    var form = document.querySelector("form");
    form.addEventListener("submit", function(event) {
        if (!validateDates()) {
            event.preventDefault(); // Empêche la soumission du formulaire
        }
    });
});
</script>