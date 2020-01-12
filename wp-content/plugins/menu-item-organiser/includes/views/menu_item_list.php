<?php
// Include model:
include MENU_ITEM_ORGANISER_PLUGIN_MODEL_DIR . "/MenuProduct.php";
include MENU_ITEM_ORGANISER_PLUGIN_MODEL_DIR . "/MenuProductManager.php";
include MENU_ITEM_ORGANISER_PLUGIN_MODEL_DIR . "/MenuCategory.php";
include MENU_ITEM_ORGANISER_PLUGIN_MODEL_DIR . "/MenuCategoryManager.php";


// Set base url to current file and add page specific vars
$base_url = get_admin_url() . 'admin.php';
$params = array('page' => basename(__FILE__, ".php"));
// Add params to base url
$base_url = add_query_arg($params, $base_url);
// Get the GET data in filtered array
$get_array = MenuProductManager::getGetValues();


?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat|Roboto:700,900');

    p{
        font-family: Montserrat;
    }

    h3, h5{
        font-family: Montserrat;
        color: #d3a998;
    }


    .table-wd{
        min-width: 250px;
    }
    .table-scroll{
        height:100%;
        overflow:auto;
        margin-top:20px;
    }

    .menu-holder{
        max-width: 800px;
    }
    .prijs{
        float:right;
    }
    .naam {
        margin-bottom: 0.2px;
    }
    p.naam {
        margin-bottom: 0.2px;
    }
</style>
<div class="wrap">
    <div class="menu-holder container">
        <?php
        //*
        if (MenuProductManager::getNrOfMenuItems() < 1) {
            ?>
            <h3>Er zijn momenteel geen Menu items</h3>
            <?php
        } else {



            // Version 2
            $categories = MenuCategoryManager::getCategories();
            $products = MenuProductManager::getMenuItems();


            /*
             * For every category, loop over all products until one is found that fits the current
             * category. Then set it to not empty.
             * If no product is found, the category remains to be set to empty, as by default declaration
             * in MenuCategory:empty = true
             */
            foreach ($categories as $category){
                foreach ($products as $product){
                    if ($product->getCategoryId() == $category->getId()){
                        $category->setEmpty(false);
                        break;
                    }
                }
            }


            /*
             * Loop over each category and display it, followed by all contained menu items.
             */
            foreach ($categories as $category){

                // If the current category is empty, skip it
                if ($category->isEmpty())
                    continue;

                ?>
                <tr>
                    <h3>
                        <?php echo $category->getName(); ?>
                    </h3>
                </tr>
                <?php


                // display data
                foreach($products as $product){
                    if ($product->getCategoryId() != $category->getId())
                        continue;
                    ?>
                    <div class="menu-items-holder row">
                        <div class="naam-holder col-12"><h5 class=""><?php echo $product->getName(); ?></h5></div>
                        <div class="beschrijving-holder col-11"><?php echo $product->getDescription(); ?></div>
                        <div class="prijs-hlder col-1"><p class="prijs"><?php echo $product->getPrice();?></p></div>
                    </div>
                    <?php
                }
            }

        }
        ?>
        </tbody>
    </table>
        </div>
</div>