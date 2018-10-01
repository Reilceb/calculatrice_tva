<?php

$calculHT = NULL;
$calculTTC = NULL;
$calculTVA = 0;
$checkInlineRadio3 = "checked";
$checkInlineRadio2 = "";
$checkInlineRadio1 = "";
$memory = array();


if (!empty($_POST)) {

    require "Calcul.php";
    require "Connection.php";
    $calcul = new Calcul();
    

    if (!empty($_POST['ht']) && empty($_POST['ttc'])) {
        $calculTTC = round($calcul->ttc($_POST['ht'], $_POST['tva']), 2);
        $calculHT = round($_POST['ht'], 2);
        
    } elseif (!empty($_POST['ttc']) && empty($_POST['ht'])) {
        $calculHT = round($calcul->ht($_POST['ttc'], $_POST['tva']), 2);
        $calculTTC = round($_POST['ttc'], 2);
    }

    $calculTVA = $calcul->tva($calculTTC, $calculHT);

    if ($_POST['tva'] == "10") {
        $checkInlineRadio3 = "";
        $checkInlineRadio2 = "checked";
    } elseif ($_POST['tva'] == "5") {
        $checkInlineRadio3 = "";
        $checkInlineRadio1 = "checked";
    }

    $query = "INSERT INTO Results (ht, ttc, montant, tva) VALUES (". $calculHT . "," . $calculTTC . "," . $calculTVA . ", '" . $_POST['tva'] . "')";
    $pdo->exec($query);

    $memory = $pdo->query("SELECT * FROM Results ORDER BY id DESC LIMIT 5");

    $memory = $memory->fetchAll();

}


?>


<!doctype html>
<html lang="en">
    <head>
        <title>Calculatrice TVA</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    </head>
    <body>
        <h1 class="text-center mt-5">Calculatrice TVA</h1>
 
        <div class="container mt-5">
            <form class="form border border-secondary p-3" method="post">
                <div class="row justify-content-center">
                    <div class="form-check form-check-inline">
                        <legend class="col-form-label mr-3">TVA</legend>
                        <input class="form-check-input" type="radio" name="tva" id="inlineRadio3" value="20" <?php echo $checkInlineRadio3 ?>>
                        <label class="form-check-label" for="inlineRadio3">20%</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tva" id="inlineRadio2" value="10" <?php echo $checkInlineRadio2 ?>>
                        <label class="form-check-label" for="inlineRadio2">10%</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tva" id="inlineRadio1" value="5" <?php echo $checkInlineRadio1 ?>>
                        <label class="form-check-label" for="inlineRadio1">5%</label>
                    </div>
                </div>
                <div class="form-inline justify-content-center mt-5">
                    <div class="form-group mx-3">
                        <input type="text" class="form-control mx-3" name="ht" id="ht" autocomplete="off" value="<?php echo $calculHT ?>">
                        <label for="ht">€ HT</label>
                    </div>
                    <div class="form-group mx-3">
                        <input type="text" class="form-control mx-3" name="ttc" id="ttc" autocomplete="off" value="<?php echo $calculTTC ?>">
                        <label for="ht">€ TTC</label>
                        
                    </div>
                </div>
                <div class="row justify-content-center mt-5">
                    <button type="submit" class="btn btn-primary">Calculer</button>
                </div>
                <div class="row justify-content-center mt-5">
                    <p class="text-center mt-5">Montant de la TVA : <?php echo $calculTVA . " €" ?></p>
                </div>
                
            </form>
            <h2 class="text-center mt-5">5 derniers calculs</h2>
            <table class="table table-striped mt-5 table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Montant HT (€)</th>
                        <th class="text-center">Montant TTC (€)</th>
                        <th class="text-center">Montant de la TVA (€)</th>
                        <th class="text-center">Taux de TVA (%)</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                foreach ($memory as $row) {
                    echo "<tr>";
                    echo "<td class='text-center'>" . $row['ht'] . "</td>";
                    echo "<td class='text-center'>" . $row['ttc'] . "</td>";
                    echo "<td class='text-center'>" . $row['montant'] . "</td>";
                    echo "<td class='text-center'>" . $row['tva'] . "</td>";
                    echo "<tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
 

      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
  </body>
</html>