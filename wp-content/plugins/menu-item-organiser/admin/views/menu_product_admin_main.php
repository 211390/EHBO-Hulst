
<?php
// Include model:
include  MENU_ITEM_ORGANISER_PLUGIN_MODEL_DIR . "/MenuProduct.php";
include  MENU_ITEM_ORGANISER_PLUGIN_MODEL_DIR . "/MenuProductManager.php";
include  MENU_ITEM_ORGANISER_PLUGIN_MODEL_DIR . "/MenuCategory.php";
include  MENU_ITEM_ORGANISER_PLUGIN_MODEL_DIR . "/MenuCategoryManager.php";


// Set base url to current file and add page specific vars
$base_url = get_admin_url() . 'admin.php';
$params = array('page' => basename(__FILE__, ".php"));
// Add params to base url
$base_url = add_query_arg($params, $base_url);
// Get the GET data in filtered array
$get_array = MenuProductManager::getGetValues();

// Collect Errors
$error = null;

// temp
$debug = array();

// Keep track of current action.
$action = FALSE;

// Check the GET data
if (!empty($get_array)) {

    // Check actions
    if (isset($get_array['action'])) {
        try {
            $action = MenuProductManager::handleGetAction();
            $error .= 'handleGetAction';
        } catch (Exception $e){
            $error = $e->getMessage();
        }

    }
}
// Get the POST data in filtered array
$post_array = MenuProductManager::getPostValues();
echo '<pre>';
$categories = MenuCategoryManager::getCategories();
echo '</pre>';

// Check the POST data
if (!empty($post_array)) {

    if (isset($post_array['add'])) {
        // Save event categorie
        try {
            MenuProductManager::save($post_array);
            echo '<p style=\'margin-top:20px;\' class=\'alert alert-success text-center\'><strong>Nieuw Menu item toegevoegd</strong></p>';
        } catch (Exception $e){
            $error = $e->getMessage();
            echo '<p style=\'margin-top:20px;\' class=\'alert alert-danger text-center\'><strong>Oops er is een ongelukje gebeurd!!!</strong></p>';
        }

    }
    // Check the update form:
    if (isset($post_array['update'])) {
        // Save event categorie
        MenuProductManager::update();
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
    <span>Shortcode  van de plug-in: [view-menu] </span>
</div>





<div class="wrap">

    <?php

    // Check if action == update : then start update form
    echo (($action == 'update') ? '<form action="' . $base_url . '"
method="post">' : '');
    ?>
    <table id="table" data-toggle="table" data-pagination="true" class="table table-sm table-hover table-striped">
        <thead class='thead-dark'>
        <tr>
            <th>Id</th>
            <th>Naam</th>
            <th>Beschrijving</th>
            <th>Prijs</th>
            <th>Categorie</th>
            <th>Actions</th>
        </tr>
        </thead>
        <!-- <tr><td colspan="3">Event types rij 1</td></tr> -->
        <?php
        //*
        if (MenuProductManager::getNrOfMenuItems() < 1) {
            ?>
            <tr><td colspan="6">Begin met nieuwe producten toe te voegen</tr>
            <?php
        } else {
            $item_list = MenuProductManager::getMenuItems();


            //** Show all event categories in the tabel
            foreach ($item_list as $menu_type_obj) {
                // Create update link
                $params = array('action' => 'update', 'id' => $menu_type_obj->getId());
                // add params to base url update link
                $upd_link = add_query_arg($params, $base_url);
                // Create delete link
                $params = array('action' => 'delete', 'id' => $menu_type_obj->getId());
                // Add params to base url delete link
                $del_link = add_query_arg($params, $base_url);


// If update and id match show update form
                // Add hidden field id for id transfer
                if (($action == 'update') &&
                    ($menu_type_obj->getId() == $get_array['id'])) {

                    ?>
                    <tr style="text-align: center;">
                    <td width="180">
                        <input type="hidden" name="id" value="<?php echo $menu_type_obj->getId(); ?>">
                    </td>
                    <td><input type="text" name="naam" required value="<?php echo $menu_type_obj->getName(); ?>"></td>
                    <td width="200"><input type="text" name="beschrijving" value ="<?php echo $menu_type_obj->getDescription(); ?>"></td>
                    <td width="200"><input type="number" step="0.01" name="prijs" min="0" value ="<?php echo $menu_type_obj->getPrice(); ?>"></td>
                    <td width="200">
                        <select name="categoryName">
                            <?php
                            foreach ($categories as $category) {
                                ?>
                                <option value="<?php echo $category->getName(); ?>"

                                <?php
                                if ($category->getId() == $menu_type_obj->getCategoryId()){
                                    echo ' selected="selected" ';
                                }
                                ?>
                                >
                                    <?php echo $category->getName();

                                ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                    <td colspan="1"><input type="submit" name="update" value="Updaten"
                        /></td>
                <?php } else { ?>
                    <td width="100"><?php echo $menu_type_obj->getId(); ?></td>
                    <td width="100"><?php echo $menu_type_obj->getName(); ?></td>
                    <td width="200"><?php echo $menu_type_obj->getDescription(); ?></td>
                    <td width="400"><?php echo $menu_type_obj->getPrice();?> &euro;</td>
                    <td width="400"><?php echo $menu_type_obj->getCategoryName();?></td>
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

    <?php
    // Check if action = update : then end update form
    echo (($action == 'update') ? '</form>' : '');
    /** Finally add the new entry line only if no update action * */
    if ($action !== 'update') {
        ?>

        <br style="clear:both;" />

        <!-- Form to ADD a new entry  -->

        <form action="<?php echo $base_url; ?>" method="post">
            <section>
                <div style="float:left;margin-right:20px;">
                    <label for="name">Naam <span style="color: red;">*</span></label>
                    <input id="name" maxlength="32" type="text" name="naam" placeholder="Naam" required>
                </div>
                <div style="float:left;margin-right:20px;">
                    <label for="beschrijving">Beschrijving</label>
                    <input id="beschrijving" maxlength="1024" type="text" name="beschrijving" placeholder="Locatie">
                </div>
                <div style="float:left;margin-right:20px;">
                    <label for="prijs">Prijs <span style="color: red;">*</span></label>
                    <input id="prijs" type="number" step="0.01" name="prijs" required>
                </div>
                <div style="float:left;margin-right:20px;">
                    <label for="categorie">Categorie <span style="color: red;">*</span></label>
                    <select name="categoryName">
                        <?php
                             foreach ($categories as $category) {
                                 ?>
                                 <option value='<?php echo $category->getName(); ?>'><?php echo $category->getName(); ?></option>
                                 <?php
                             }
                        ?>
                    </select>
                </div>
                <br style="clear:both;" />
            </section>

            <section>
                <div style="float:left;margin-top:20px;">
                    <input type="submit" name="add" value="Toevoegen"/>
                </div>
            </section>
        </form>
        <?php
    } // if action !== update
    ?>
</div>




