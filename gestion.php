<?php require_once("header.php"); ?>
<?php require_once("database.php"); ?>

<div class="container" style="margin-top: 150px; margin-bottom: 200px">
    <div class="row">
        <h1 style="margin-bottom: 50px"><strong>Liste des items   </strong><a href="insert.php" class="btn btn-success btn-lg"> Ajouter</a></h1>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>résumé</th>
                    <th>Prix</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $db = Database::connect();
                $db->exec('SET NAMES utf8');
                    $statement = $db->query("SELECT * FROM products");
                    while($item = $statement->fetch()) 
                    {
                        echo '<tr>';
                        echo '<td>'. $item['product_titre'] . '</td>';
                        echo '<td>'. $item['product_auteur'] . '</td>';
                        echo '<td>'. $item['product_resume'] . '</td>';
                        echo '<td>'. number_format($item['product_price'], 2, '.', '') . '</td>';
                        echo '<td width=300>';
                        echo '<a class="btn btn-secondary" href="view.php?product_id='.$item['product_id'].'"> Voir</a>';
                        echo ' ';
                        echo '<a class="btn btn-primary" href="update_product.php?product_id='.$item['product_id'].'"> Modifier</a>';
                        echo ' ';
                        echo '<a class="btn btn-danger" href="delete.php?product_id='.$item['product_id'].'"> Supprimer</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once("footer1.php"); ?>