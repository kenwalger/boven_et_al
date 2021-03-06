<?php

/*********************************************************************
*  Class to handle menus
*********************************************************************/

class Menu 
{

    // Properties

    /*********************************************************************
    * @var int the menu ID from the database
    *********************************************************************/
    public $id = null;

    /********************************************************************* 
    * @var int when the menu was published
    *********************************************************************/
    public $publicationDate = null;

    /*********************************************************************
    * @var string Full title of the menu
    *********************************************************************/
    public $title = null;

    /*********************************************************************
    * @var string a shorty summary of the menu
    *********************************************************************/
    public $summary = null;

    /*********************************************************************
    * @var string the HTML content of the menu
    *********************************************************************/
    public $content = null;


    /*********************************************************************
    * Sets the object's properties using the values in the supplied array
    *
    * @param assoc The property values
    *********************************************************************/

    public function __construct ($data=array()) {
        if ( isset( $data['id'] ) ) $this->id = (int) $data['id'];
        if ( isset( $data['publicationDate'] ) ) $this->publicationDate = (int) $data['publicationDate'];
        if ( isset( $data['title'] ) ) $this->title = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['title'] );
        if ( isset( $data['summary'] ) ) $this->summary = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['summary'] );
        if ( isset( $data['content'] ) ) $this->content = $data['content'];
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
        if ( isset($params['publicationDate']) ) {
          $publicationDate = explode ( '-', $params['publicationDate'] );
     
          if ( count($publicationDate) == 3 ) {
            list ( $y, $m, $d ) = $publicationDate;
            $this->publicationDate = mktime ( 0, 0, 0, $m, $d, $y );
          }
        }
    }


    /*********************************************************************
    * Returns a Menu object matching the given menu ID
    *
    * @param int The menu ID
    * @return Menu|false The menu object, or false if the record was not found or there was a problem
    *********************************************************************/
 
    public static function getById( $id ) {
        $conn = new PDO( DB_DBN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM menus WHERE id = :id";
        $st = $conn->prepare( $sql );
        $st->bindValue( ":id", $id, PDO::PARAM_INT );
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ( $row ) return new Menu( $row );
    }


    /*********************************************************************
    * Returns all (or a range of) Menu objects in the DB
    *
    * @param int Optional The number of rows to return (default=all)
    * @param string Optional column by which to order the menu (default="publicationDate DESC")
    * @return Array|false A two-element array : results => array, a list of Menu objects; totalRows => Total number of menu
    *********************************************************************/
 
    public static function getList( $numRows=1000000, $order="publicationDate DESC" ) {
        $conn = new PDO( DB_DBN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM menus
                ORDER BY " . mysql_escape_string($order) . " LIMIT :numRows";

        $st = $conn->prepare( $sql );
        $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
        $st->execute();
        $list = array();

        while ( $row = $st->fetch() ) {
          $menu = new Menu( $row );
          $list[] = $menu;
        }

        // Now get the total number of menus that matched the criteria
        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
        return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }


    /*********************************************************************
    * Inserts the current Menu object into the database, and sets its ID property.
    *********************************************************************/
 
    public function insert() {

        // Does the Menu object already have an ID?
        if ( !is_null( $this->id ) ) trigger_error ( "Menu::insert(): Attempt to insert a Menu object that already has its ID property set (to $this->id).", E_USER_ERROR );

        // Insert the Menu
        $conn = new PDO( DB_DBN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO menus ( publicationDate, title, summary, content ) VALUES ( FROM_UNIXTIME(:publicationDate), :title, :summary, :content )";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":publicationDate", $this->publicationDate, PDO::PARAM_INT );
        $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
        $st->bindValue( ":summary", $this->summary, PDO::PARAM_STR );
        $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;
    }


    /*********************************************************************
    * Updates the current Menu object in the database.
    *********************************************************************/
 
    public function update() {

        // Does the Menu object have an ID?
        if ( is_null( $this->id ) ) trigger_error ( "Menu::update(): Attempt to update a Menu object that does not have its ID property set.", E_USER_ERROR );

        // Update the Menu
        $conn = new PDO( DB_DBN, DB_USERNAME, DB_PASSWORD );
        $sql = "UPDATE menus SET publicationDate=FROM_UNIXTIME(:publicationDate), title=:title, summary=:summary, content=:content WHERE id = :id";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":publicationDate", $this->publicationDate, PDO::PARAM_INT );
        $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
        $st->bindValue( ":summary", $this->summary, PDO::PARAM_STR );
        $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
        $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
        $st->execute();
        $conn = null;
    }


    /*********************************************************************
    * Deletes the current Menu object in the database.
    *********************************************************************/

    public function delete() {

        // Does the Menu object have an ID?
        if ( is_null( $this->id ) ) trigger_error ( "Menu::delete(): Attempt to delete a Menu object that does not have its ID property set.", E_USER_ERROR );

        // Delete the Menu
        $conn = new PDO( DB_DBN, DB_USERNAME, DB_PASSWORD );
        $st = $conn->prepare ( "DELETE FROM menus WHERE id = :id LIMIT 1" );
        $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
        $st->execute();
        $conn = null;
    }
}

?>