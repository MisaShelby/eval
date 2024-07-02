<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Commission</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            margin: 20px auto;
            max-width: 900px;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Row Styling */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }

        /* Column Styling */
        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 15px;
            box-sizing: border-box;
        }

        /* Form Styling */
        form {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        /* Success and Error Messages */
        .text-success {
            color: #28a745;
            margin-top: 20px;
        }

        .text-danger {
            color: #dc3545;
        }

        .list-group {
            list-style-type: none;
            padding: 0;
            margin-top: 20px;
        }

        .list-item {
            padding: 10px;
            border: 1px solid #dc3545;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        /* Table Styling */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
            text-align: left;
        }

        .table th,
        .table td {
            padding: 12px;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            background-color: #f8f9fa;
        }

        .table tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .col-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            form, .btn-primary, button, a {
                width: 100%;
                text-align: center;
            }
        }
        
        .centered-table {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 0 auto;
            width: 100%;
        }

        .centered-hr {
            width: 50%;
            border: 1px solid black;
            margin: 20px auto;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        button a {
            color: #fff;
            text-decoration: none;
        }

        button a:hover {
            text-decoration: underline;
        }

        .export-buttons {
            display: flex;
            justify-content: space-between;
        }

        .export-buttons form {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row black-alpha-border p-3 centered-table">
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Type de Bien</th>
                            <th>Commission</th>
                        </tr>
                        <hr class="centered-hr">
                    </thead>
                    <tbody>
                        <?php foreach($type_bien as $val){?>
                            <tr>
                                <td><?=$val->nom_bien;?></td>
                                <td><?=$val->comission;?></td>
                                <td class="export-buttons">
                                    <form action="<?= site_url('Export/export_excel/')?>" method="post">
                                        <button type="submit">Exporter Excel</button>
                                    </form>
                                    <form action="<?= site_url('Export/export_pdf/')?>" method="post">
                                        <button type="submit">Exporter PDF</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <button><a href="<?= site_url("Importation_Co/drop_data1")?>">Réinitialiser</a></button>
    </div>
</body>
</html>
