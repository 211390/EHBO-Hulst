<?php
/**
 * Static helper for categories
 *
 *
 * Created by PhpStorm.
 * User: toost_000
 * Date: 4-1-2020
 * Time: 13:29
 *
 * @author Tirstan Oostdijk
 */


class MenuCategoryManager {


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
            'ranking' => array('filter' => FILTER_VALIDATE_INT)
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

        $categories = self::getCategories();
        foreach ($categories as $c){
            if ($c->getRanking() == $input['ranking'])
                throw new InvalidArgumentException('Cannot duplicate ranking value');
        }


        if (empty($input['ranking']))
            $input['ranking'] = 1; // default ranking

        global $wpdb;

        $wpdb->query($wpdb->prepare("INSERT INTO `" . self::getTableName()
            . "` ( `naam`, `ranking`)" .
            " VALUES ( '%s', '%d');", $input['naam'], $input['ranking']));

    }

    /**
     * Update db entry using given POST variables
     *
     * @throws InvalidArgumentException
     * @throws mysqli_sql_exception
     * @return void
     */
    public static function update(){
        $data = self::getPostValues();

        $categories = self::getCategories();
        foreach ($categories as $c){
            if ($c->getRanking() == $data['ranking'])
                throw new InvalidArgumentException('Cannot duplicate ranking value');
        }

        global $wpdb;

        $wpdb->query($wpdb->prepare("UPDATE " . self::getTableName() .
            " SET `naam` = '%s', 
                  `ranking` = '%d' " .
            "WHERE `" . self::getTableName() . "`.`id` =%d;",
            $data['naam'],
            $data['ranking'],
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
            throw new Exception('Invalid ID field');

        global $wpdb;
        $wpdb->delete(self::getTableName(), array('id' => $id), array('%d'));
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
                    $action = 'update';

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
     * Count number of categories stored in the database
     *
     * @return int
     */
    public static function getNrOfCategories(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `" . self::getTableName() . "`";
        $result = $wpdb->get_row($query, ARRAY_A);

        return $result['nr'];
    }


    /**
     * Load all categories from the db as objects
     *
     * @return MenuCategory[]
     */
    public static function getCategories(){

        global $wpdb;
        $array = [];

        // Load rows from database
        $categories = $wpdb->get_results("SELECT * FROM `"
            . self::getTableName() . "` ORDER BY `ranking` ASC", ARRAY_A);


        // Loop over rows and create an object for each of them
        foreach($categories as $category){
            $entry = new MenuCategory(
                $category['id'],
                $category['naam'],
                $category['ranking']);

            // Add it to the array
            array_push($array, $entry);
        }

        return $array;
    }


    /**
     * Tries to resolve a category by any given name, provided by drop-down menus
     *
     *
     * @param $name string  The given name
     * @return int          The resolved ID or 0 on failure
     */
    public static function resolveID($name){
        $categories = self::getCategories();

        foreach ($categories as $category){
            if (strcmp($category->getName(), $name) == 0)
                return $category->getId();
        }
        return 0;
    }


    /**
     * Resolve a category's name by a given ID.
     *
     * @param $id int
     * @return string|null
     */
    public static function getNameStatic($id){
        global $wpdb;

        $qry = "SELECT * FROM " . self::getTableName() . " WHERE `id` = '%d'";
        $stmt = $wpdb->prepare($qry, array($id));

        $result = $wpdb->get_results($stmt, ARRAY_A);

        return $result[0]['naam'];
    }

    /**
     * Get Category table name in DB incl. prefix
     * @return string
     */
    public static function getTableName(){
        global $wpdb;
        return $wpdb->prefix . 'menu_categories';
    }
}