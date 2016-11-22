<?php

/*********************************************************************
*  Class to handle recipes
*********************************************************************/

class Recipe
{

    // Properties

    /*********************************************************************
    * @var int the recipeId from the database
    *********************************************************************/
    public $recipeId = null;

    /********************************************************************* 
    * @var int when the recipe was published
    *********************************************************************/
    public $pubDate = null;

    /*********************************************************************
    * @var string full title of the recipe
    *********************************************************************/
    public $title = null;

    /*********************************************************************
    * @var string the recipe cateogy (appetizer, entree, dessert, etc.)
    *********************************************************************/
    public $category = null;

    /*********************************************************************
    * @var string the description of the recipe for the menu
    *********************************************************************/
    public $description = null;

    /*********************************************************************
    * @var int the food cost for recipe
    *********************************************************************/
    public $foodCost = null;

    /*********************************************************************
    * @var int the menu price for the recipe
    *********************************************************************/
    public $menuPrice = null;


    /*********************************************************************
    * Sets the object's properties using the values in the supplied array
    *
    * @param assoc The property values
    *********************************************************************/

    public function __construct ($data=array()) {
        if ( isset( $data['recipeId'] ) ) $this->recipeId = (int) $data['recipeId'];
        if ( isset( $data['pubDate'] ) ) $this->pubDate = (int) $data['pubDate'];
        if ( isset( $data['title'] ) ) $this->title = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['title'] );
        if ( isset( $data['category'] ) ) $this->category = $data['category'];
        if ( isset( $data['description'] ) ) $this->description = $data['description'];
        if ( isset( $data['foodCost'] ) ) $this->foodCost = (int) $data['foodCost'];
        if ( isset( $data['menuPrice'] ) ) $this->menuPrice = (int) $data['menuPrice'];
    }


    /*********************************************************************
    * Sets the object's properties using the edit form post values in the supplied array
    *
    * @param assoc The form post values
    *********************************************************************/

    public function storeFormValues ( $params ) {
 
        // Store all the parameters
        $this->__construct( $params );
     
        // Parse and store the publication date
        if ( isset($params['pubDate']) ) {
          $pubDate = explode ( '-', $params['pubDate'] );
     
          if ( count($pubDate) == 3 ) {
            list ( $y, $m, $d ) = $pubDate;
            $this->pubDate = mktime ( 0, 0, 0, $m, $d, $y );
          }
        }
    }


    /*********************************************************************
    * Returns a Recipe object matching the given Recipe ID
    *
    * @param int The recipe ID
    * @return Recipe|false The recipe object, or false if the record was not found or there was a problem
    *********************************************************************/
 
    public static function getById( $recipeId ) {
        $conn = new PDO( DB_DBN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT *, UNIX_TIMESTAMP(pubDate) AS pubDate FROM recipes WHERE recipeId = :recipeId";
        $st = $conn->prepare( $sql );
        $st->bindValue( ":recipeId", $recipeId, PDO::PARAM_INT );
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ( $row ) return new Recipe ( $row );
    }


    /*********************************************************************
    * Returns all (or a range of) Recipe objects in the DB
    *
    * @param int Optional The number of rows to return (default=all)
    * @param string Optional column by which to order the recipe (default="pubDate DESC")
    * @return Array|false A two-element array : results => array, a list of Recipe objects; totalRows => Total number of recipes
    *********************************************************************/
 
    public static function getList( $numRows=1000000, $order="pubDate DESC" ) {
        $conn = new PDO( DB_DBN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(pubDate) AS pubDate FROM recipes
                ORDER BY " . mysql_escape_string($order) . " LIMIT :numRows";

        $st = $conn->prepare( $sql );
        $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
        $st->execute();
        $list = array();

        while ( $row = $st->fetch() ) {
          $recipe = new Recipe( $row );
          $list[] = $recipe;
        }

        // Now get the total number of recipes that matched the criteria
        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
        return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }


    /*********************************************************************
    * Inserts the current Recipe object into the database, and sets its recipeId property.
    *********************************************************************/
 
    public function insert() {

        // Does the Recipe object already have an ID?
        if ( !is_null( $this->recipeId ) ) trigger_error ( "Recipe::insert(): Attempt to insert a Recipe object that already has its ID property set (to $this->recipeId).", E_USER_ERROR );

        // Insert the Recipe
        $conn = new PDO( DB_DBN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO recipes ( pubDate, title, category, description, foodCost, menuPrice ) 
                VALUES ( FROM_UNIXTIME(:pubDate), :title, :cateogry, :description, :foodCost, :menuPrice )";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":pubDate", $this->pubDate, PDO::PARAM_INT );
        $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
        $st->bindValue( ":cateogry", $this->cateogry, PDO::PARAM_STR );
        $st->bindValue( ":description", $this->description, PDO::PARAM_STR );
        $st->bindValue( ":foodCost", $this->foodCost, PDO::PARAM_INT );
        $st->bindValue( ":menuPrice", $this->menuPrice, PDO::PARAM_INT );
        $st->execute();
        $this->recipeId = $conn->lastInsertId();
        $conn = null;
    }


    /*********************************************************************
    * Updates the current Recipe object in the database.
    *********************************************************************/
 
    public function update() {

        // Does the Recipe object have an ID?
        if ( is_null( $this->recipeId ) ) trigger_error ( "Recipe::update(): Attempt to update a Recipe object that does not have its ID property set.", E_USER_ERROR );

        // Update the Recipe
        $conn = new PDO( DB_DBN, DB_USERNAME, DB_PASSWORD );
        $sql = "UPDATE recipes SET pubDate=FROM_UNIXTIME(:pubDate), title=:title, category=:category, description=:description, foodCost=:foodCost, menuPrice=:menuPrice )
                WHERE recipeId = :recipeId";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":pubDate", $this->pubDate, PDO::PARAM_INT );
        $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
        $st->bindValue( ":category", $this->category, PDO::PARAM_STR );
        $st->bindValue( ":description", $this->description, PDO::PARAM_STR );
        $st->bindValue( ":foodCost", $this->foodCost, PDO::PARAM_INT);
        $st->bindValue( ":menuPrice", $this->menuPrice, PDO::PARAM_INT);
        $st->bindValue( ":recipeId", $this->recipeId, PDO::PARAM_INT );
        $st->execute();
        $conn = null;
    }


    /*********************************************************************
    * Deletes the current Recipe object in the database.
    *********************************************************************/

    public function delete() {

        // Does the Recipe object have an ID?
        if ( is_null( $this->recipeId ) ) trigger_error ( "Recipe::delete(): Attempt to delete a Recipe object that does not have its ID property set.", E_USER_ERROR );

        // Delete the Recipe
        $conn = new PDO( DB_DBN, DB_USERNAME, DB_PASSWORD );
        $st = $conn->prepare ( "DELETE FROM recipes WHERE recipeId = :recipeId LIMIT 1" );
        $st->bindValue( ":recipeId", $this->recipeId, PDO::PARAM_INT );
        $st->execute();
        $conn = null;
    }
}

?>