<?php
/**
 * Manager to assist with menu items
 *
 *
 * User: toost_000
 * Date: 4-1-2020
 * Time: 14:39
 */

//include_once  MENU_ITEM_ORGANISER_PLUGIN_MODEL_DIR . "/MenuCategoryManager.php";

class MenuProductManager {

    /**
     * Filter given POST-variables to only accept valid ones
     *
     * @return mixed[]
     */
    public static function getPostValues(){

        $pre = array(
            'add' => array('filter' => FILTER_SANITIZE_STRING),
            'update' => array('filter' => FILTER_SANITIZE_STRING),
            'naam' => array('filter' => FILTER_SANITIZE_STRING),
            'id' => array('filter' => FILTER_VALIDATE_INT),
            'prijs' => array('filter' => FILTER_SANITIZE_NUMBER_FLOAT),
            'beschrijving' => array('filter' => FILTER_SANITIZE_STRING),
            'categoryName' => array('filter' => FILTER_SANITIZE_STRING)
        );

        return filter_input_array(INPUT_POST, $pre);
    }

    /**
     * Filter given GET-variables to only accept valid ones
     *
     * @return mixed[]
     */
    public static function getGetValues(){
        $pre = array(
            'action' => array('filter', FILTER_SANITIZE_STRING),
            'id' => array('filter', FILTER_VALIDATE_INT)
        );

        return filter_input_array(INPUT_GET, $pre);
    }


    /**
     * Save any given Category
     *
     * @param $input mixed[]    Input array of category data
     * @throws  \http\Exception\InvalidArgumentException
     * @return void
     */
    public static function save($input){
        if (empty($input['naam']))
            throw new \http\Exception\InvalidArgumentException('Missing naam');

        if (empty($input['prijs']))
            throw new \http\Exception\InvalidArgumentException('Missing prijs');

        global $wpdb;

        $input['categoryID'] = MenuCategoryManager::resolveID($input['categoryName']);

        $wpdb->query($wpdb->prepare("INSERT INTO `" . self::getTableName()
            . "` ( `naam`, `beschrijving`, `prijs`, `categoryID`)" .
            " VALUES ( '%s', '%s', '%f', '%d');", $input['naam'], $input['beschrijving'], (float) $input['prijs'] / 100, $input['categoryID']));

    }

    /**
     * Update db entry using given POST variables
     *
     * @throws mysqli_sql_exception
     * @return void
     */
    public static function update(){
        $data = self::getPostValues();

        $data['categoryID'] = MenuCategoryManager::resolveID($data['categoryName']);

        global $wpdb;

        $wpdb->query($wpdb->prepare("UPDATE " . self::getTableName() .
            " SET `naam` = '%s', 
                  `beschrijving` = '%s', 
                  `prijs` = '%f', 
                  `categoryID` = '%d'" .
            "WHERE `" . self::getTableName() . "`.`id_menu_product` =%d;",
                    $data['naam'],
                    $data['beschrijving'],
            ((float)$data['prijs'] / 100),
                    $data['categoryID'],
                    $data['id']));
    }


    /**
     * Deletes category entry by it's ID
     *
     * @param $id int
     * @throws mysqli_sql_exception
     * @throws Exception
     * @return void
     */
    public static function delete($id){
        try {
            $id = (int) $id;
        } catch (Exception $e){
            throw new \http\Exception\InvalidArgumentException('Could not cast id to integer');
        }

        if (!is_int($id))
            throw new Exception('Invalid ID field: ' . $id);


        global $wpdb;
        $wpdb->delete(self::getTableName(), array('id_menu_product' => $id), array('%d'));
        if (!empty($wpdb->last_error)) {

            throw new Exception($wpdb->last_error);
        }
    }


    /**
     * Check the action and perform action on:
     * - delete
     *
     * @throws Exception    May forward Exception thrown in @see self::delete()
     * @return string       The action provided by the $_GET array
     */
    public static function handleGetAction(){
        $params = self::getGetValues();
        $action = '';

        if (!isset($params['action']))
            return 'err';

        $verified = $params['action'];

        switch ($verified){
            case 'update':
                // Indicate current action is 'update', if ID is provided
                if (!is_null($params['id']))
                    $action = $params['action'];
                break;

            case 'delete':
                if (!is_null($params['id'])){
                    $action = 'delete';
                    self::delete($params['id']);
                }

                break;

            default:
                // smth went wrong
                break;
        }
        return $action;
    }


    /**
     * Count number of items stored in the database
     *
     * @return int
     */
    public static function getNrOfMenuItems(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `" . self::getTableName() . "`";
        $result = $wpdb->get_row($query, ARRAY_A);

        return $result['nr'];
    }


    /**
     * Load all categories from the db as objects
     *
     * @return MenuProduct[]
     */
    public static function getMenuItems(){

        global $wpdb;
        $array = array();

        // Load rows from database

        $products = self::getTableName();
        $categories = MenuCategoryManager::getTableName();

        $query = "
        SELECT
            $products.id_menu_product,
            $products.categoryID,
            $products.naam,
            $products.beschrijving,
            $products.prijs,
            $categories.id,
            $categories.ranking
        FROM
            $products
        INNER JOIN
            $categories
        ON 
            $products.categoryID = $categories.id
        ORDER BY $categories.ranking;    
        
        ";

        $items = $wpdb->get_results($query, ARRAY_A);

        // Loop over rows and create an object for each of them
        foreach($items as $item){
            $entry = new MenuProduct(
                $item['id_menu_product'],
                $item['categoryID'],
                $item['naam'],
                $item['beschrijving'],
                $item['prijs']);

            // Add it to the array
            array_push($array, $entry);
        }

        return $array;
    }


    /**
     * Get Category table name in DB incl. prefix
     * @return string
     */
    public static function getTableName(){
        global $wpdb;
        return $wpdb->prefix . 'menu_product';
    }

}
