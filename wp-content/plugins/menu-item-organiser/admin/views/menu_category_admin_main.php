<?php
/**
 * Admin Page for Menu Categories
 *
 *
 * Created by PhpStorm.
 * User: toost_000
 * Date: 4-1-2020
 * Time: 13:17
 */


include  MENU_ITEM_ORGANISER_PLUGIN_MODEL_DIR . "/MenuCategory.php";
include  MENU_ITEM_ORGANISER_PLUGIN_MODEL_DIR . "/MenuCategoryManager.php";

// local stuff
$categoryManager = new MenuCategoryManager();

$base_url = get_admin_url() . 'admin.php';
$params = array('page' => basename(__FILE__, '.php'));

$base_url = add_query_arg($params, $base_url);

$getArray = MenuCategoryManager::getGetValues();
$postArray = MenuCategoryManager::getPostValues();

$action = FALSE;

$debug = array();


if (!empty($getArray)){
    if (isset($getArray['action']))
        try {
            $action = MenuCategoryManager::handleGetAction();
        } catch (Exception $e) {
            //todo
        }
}

$error = null;

if (!empty($postArray)){

    // Check for action = add
    if (isset($postArray['add'])){
        try {
            MenuCategoryManager::save($postArray);
            echo '<p style=\'margin-top:20px;\' class=\'alert alert-success text-center\'><strong>Nieuw Menu item toegevoegd</strong></p>';
        } catch (Exception $e){
            echo '<p style=\'margin-top:20px;\' class=\'alert alert-danger text-center\'><strong>Oops er is een ongelukje gebeurd!!!</strong></p>';
            $error = $e->getMessage();
        }
    }

    // Check for action = update
    if (isset($postArray['update'])){
        try {
            MenuCategoryManager::update();
        } catch (Exception $e){
            echo '<p style=\'margin-top:20px;\' class=\'alert alert-danger text-center\'><strong>Cannot have duplicated rankings</strong></p>';
        }

        array_push($debug, 'calling Update');
    }

}


?>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css" rel="stylesheet">

    <style>
        input, label {
            display:block;
        }

        /*Verwijderd de wordpress backend footer*/
        #wpfooter {
            margin-bottom: 100%;
        }


        .categorie-holder {
            width: 1200px;
            float: right;
            margin-bottom: 50px;
        }

        .form-holder {
            width: 300px;
            float: left;
        }

        .float-left.pagination-detail {
            visibility: hidden;
        }

    </style>

    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
    <script language="JavaScript" type="text/javascript">
        $(document).ready(function(){
            $("a.delete").click(function(e){
                if(!confirm('Weet u zeker dat u het item wilt verwijderen?')){
                    e.preventDefault();
                    return false;
                }
                return true;
            });
        });

    </script>
</head>
<div>
    <span>Shortcode  van de plug-in: [view-Menu] </span>
</div>


<div class="wrap">

    <?php
    // Check if action = update : then end update form
    echo (($action == 'update' ) ? '</form>' : '');
    /** Finally add the new entry line only if no update action * */
    if ($action !== 'update') {
        ?>
        <div class="form-holder">
            <form action="<?php echo $base_url; ?>" method="post">
                <section>
                    <div style="float:left;margin-right:20px;">
                        <label for="name">Naam <span style="color: red;">*</span></label>
                        <input id="name" maxlength="32" type="text" name="naam" placeholder="Naam" required>

                        <label for="ranking">Ranking <span style="color: red;">*</span></label>
                        <input id="name" maxlength="32" type="number" name="ranking" placeholder="1" required>
                    </div>
                    <br style="clear:both;" />
                </section>

                <section>
                    <div style="float:left;margin-top:20px;">
                        <input type="submit" name="add" value="Toevoegen"/>
                    </div>
                </section>
            </form>
        </div>
        <?php
    } // if action !== update
    ?>

    <?php

    // Check if action == update : then start update form
    echo (($action == 'update' ) ? '<form action="' . $base_url . '"
method="post">' : '');
    ?>
    <div class="categorie-holder">
        <table id="table" data-toggle="table" data-pagination="true" class="table table-sm table-hover table-striped">
            <thead class='thead-dark'>
            <tr>
                <th>Ranking</th>
                <th>Naam</th>
                <th>Actions</th>
            </tr>
            </thead>
            <!-- <tr><td colspan="3">Event types rij 1</td></tr> -->
            <?php
            //*
            if (MenuCategoryManager::getNrOfCategories() < 1) {
                ?>
                <tr><td colspan="5">Begin met nieuwe producten toe te voegen</tr>
                <?php
            } else {
                $categories = MenuCategoryManager::getCategories();

                //** Show all event categories in the tabel
                foreach ($categories as  $category) {
                    // Create update link
                    $params = array('action' => 'update', 'id' => $category->getId());
                    // add params to base url update link
                    $upd_link = add_query_arg($params, $base_url);
                    // Create delete link
                    $params = array('action' => 'delete', 'id' => $category->getId());
                    // Add params to base url delete link
                    $del_link = add_query_arg($params, $base_url);


// If update and id match show update form
                    // Add hidden field id for id transfer
                    if (($action == 'update') &&
                        ($category->getId() == $getArray['id'])) {

                        ?>
                        <tr style="text-align: center;">
                        <td>
                            <input type="hidden" name="id" value="<?php echo $category->getId(); ?>">
                            <input type="text" name="ranking" required value="<?php echo $category->getRanking(); ?>">
                        </td>
                        <td>
                            <input type="text" name="naam" required value="<?php echo $category->getName(); ?>">
                        </td>
                        <td colspan="1"><input type="submit" name="update" value="Updaten"
                            /></td>
                    <?php } else { ?>
                        <td width="400"><?php echo $category->getRanking();?></td>
                        <td width="400"><?php echo $category->getName();?></td>

                        <?php
                        if ($action !== 'update') {
// If action is update don’t show the action button
                            ?>
                            <td width="30">
                                <a href="<?php echo $upd_link; ?>"><button class="btn btn-primary">Update</button></a>
                                <a class="delete" href="<?php echo $del_link; ?>"><button class="btn btn-danger">Delete</button></a>
                            </td>

                            <?php
                        } // if action !== update
                        ?>
                    <?php } // if acton !== update ?>
                    </tr>
                    <?php
                } //foreach event type
                ?>
                <?php
            }
            ?>
        </table>
    </div>
</div>


<div class="error" style="position: absolute; bottom: 10px;">
    <?php

    // TODO: remove this block
    echo (isset($error) ? $error : 'no errors found');
    ?>
    <pre>
            <?php
            /*
            echo '<br>GET ';
            var_dump(MenuCategoryManager::getGetValues());


            echo '<br>POST :';
            var_dump(MenuCategoryManager::getPostValues());
            */
            echo '<br>Debug :';
            var_dump($debug);
            ?>
        </pre>
</div>

<div class="debug">

</div>




