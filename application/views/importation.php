<main id="main" class="main"> 
<section>
<style>
    /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    
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

.btn-primary {
    background-color: #007bff;
    border: none;
    padding: 10px 20px;
    color: #fff;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
}

/* Link Styling */
a {
    display: inline-block;
    margin-top: 20px;
    color: #007bff;
    text-decoration: none;
    transition: color 0.3s ease;
}

a:hover {
    color: #0056b3;
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

/* Responsive Design */
@media (max-width: 768px) {
    .col-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }

    form, .btn-primary, a {
        width: 100%;
        text-align: center;
    }
    
}

</style>

<div class="container">
        <div class="row">
            <div class="col-6">
                <form action="<?= site_url('Importation_Co/upload1') ?>" method="post" enctype="multipart/form-data">
                    <div class="my-3">
                        <h3>Importation comission :</h3>
                        <input type="file" name="itapy" class="form-control" id="">
                    </div>
                    <input type="submit" value="Importer" class="btn btn-primary">
                </form>
            </div>
          
            <div class="col-6">
                <?php
                if (isset($success) && strlen($success) > 0) { ?>
                    <h4 class="text-success">
                        <?= $success ?>
                    </h4>
                    <?php
                } else if (isset($errors) && count($errors) > 0) { ?>

                        <ul class="list-group">
                            <?php
                            foreach ($errors as $error) { ?>
                                <li class="list-item">
                                    <p class="text-danger">
                                        <?= $error ?>
                                    </p>
                                </li>

                        <?php }

                            ?>
                        </ul>

                <?php }

                ?>
                <!-- Ato erreur no ato na success -->
            </div>
        </div>
        <a href="<?= site_url('Importation_Co/all_pers1')?>">liste</a>
        <a href="<?= site_url('Importation_Co/duree1')?>">duree</a>
</div>
<div class="container">
        <div class="row">
            <div class="col-6">
                <form action="<?= site_url('Importation_Co/upload') ?>" method="post" enctype="multipart/form-data">
                    <div class="my-3">
                        <h3>Importation Bien :</h3>
                        <input type="file" name="personne" class="form-control" id="">
                    </div>
                    <input type="submit" value="Importer" class="btn btn-primary">
                </form>
            </div>
          
            <div class="col-6">
                <?php
                if (isset($success) && strlen($success) > 0) { ?>
                    <h4 class="text-success">
                        <?= $success ?>
                    </h4>
                    <?php
                } else if (isset($errors) && count($errors) > 0) { ?>

                        <ul class="list-group">
                            <?php
                            foreach ($errors as $error) { ?>
                                <li class="list-item">
                                    <p class="text-danger">
                                        <?= $error ?>
                                    </p>
                                </li>

                        <?php }

                            ?>
                        </ul>

                <?php }

                ?>
                <!-- Ato erreur no ato na success -->
            </div>
        </div>
        <a href="<?= site_url('Importation_Co/all_pers')?>">liste</a>
        <a href="<?= site_url('Importation_Co/duree')?>">duree</a>
</div>


<div class="container">
        <div class="row">
            <div class="col-6">
                <form action="<?= site_url('Importation_Co/upload2') ?>" method="post" enctype="multipart/form-data">
                    <div class="my-3">
                        <h3>Importation location :</h3>
                        <input type="file" name="loca" class="form-control" id="">
                    </div>
                    <input type="submit" value="Importer" class="btn btn-primary">
                </form>
            </div>
          
            <div class="col-6">
                <?php
                if (isset($success) && strlen($success) > 0) { ?>
                    <h4 class="text-success">
                        <?= $success ?>
                    </h4>
                    <?php
                } else if (isset($errors) && count($errors) > 0) { ?>

                        <ul class="list-group">
                            <?php
                            foreach ($errors as $error) { ?>
                                <li class="list-item">
                                    <p class="text-danger">
                                        <?= $error ?>
                                    </p>
                                </li>

                        <?php }

                            ?>
                        </ul>

                <?php }

                ?>
                <!-- Ato erreur no ato na success -->
            </div>
        </div>
        <a href="<?= site_url('Importation_Co/all_pers1')?>">liste</a>
        <a href="<?= site_url('Importation_Co/duree1')?>">duree</a>
</div>

</section>