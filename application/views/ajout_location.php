<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une nouvelle location</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .main {
            padding: 20px;
        }
        section {
            background: #fff;
            padding: 20px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        input[type="text"], input[type="number"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 15px;
            background: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <main id="main" class="main"> 
        <section>
            <h2>Ajouter une nouvelle location</h2>
            <form action="<?php echo base_url('Location/index') ?>" method="post">
                <div>
                    <label for="email_client">Email du client :</label>
                    <select name="email_client" id="email_client" required>
                        <option value="" disabled selected>Choisissez un email client</option>
                        <?php foreach ($clients as $client) : ?>
                            <option value="<?php echo $client['email']; ?>"><?php echo $client['email']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="bien">Bien :</label>
                    <select name="bien" id="bien" required>
                        <option value="" disabled selected>Choisissez un type de bien</option>
                        <?php foreach ($biens as $bien) : ?>
                            <option value="<?php echo $bien['reference']; ?>"><?php echo $bien['nom']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="duree">Durée (en mois) :</label>
                    <input type="number" id="duree" name="duree" min="1" required>
                </div>
                <div>
                    <label for="date_debut">Date de début :</label>
                    <input type="date" id="date_debut" name="date_debut" required>
                </div>
                <button type="submit">Ajouter</button>
            </form>
        </section>
    </main>
</body>
</html>
