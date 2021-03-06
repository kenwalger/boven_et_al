USE boven;# MySQL returned an empty result set (i.e. zero rows).

DROP TABLE IF EXISTS menus;# MySQL returned an empty result set (i.e. zero rows).

CREATE TABLE menus
(
  id              smallint unsigned NOT NULL auto_increment,
  publicationDate date NOT NULL,                              # When the menu was published
  title           varchar(255) NOT NULL,                      # Full title of the menu
  summary         text NOT NULL,                              # A short summary of the menu
  content         mediumtext NOT NULL,                        # The HTML content of the menu
  

  PRIMARY KEY     (id)
)ENGINE=MyISAM DEFAULT CHARSET=UTF8 AUTO_INCREMENT=2 ;# MySQL returned an empty result set (i.e. zero rows).


DROP TABLE IF EXISTS recipes;# MySQL returned an empty result set (i.e. zero rows).

CREATE TABLE recipes
(
    recipeId        smallint unsigned NOT NULL auto_increment,
    pubDate         date NOT NULL,
    title           varchar(255) NOT NULL,                      # Full title of the recipe
    category         text NOT NULL,                             # The cateogry of the recipe (appetizer, soup, entree, dessert)
    description     mediumtext NOT NULL,                        # The menu description for the recipe
    foodCost        int(10) NOT NULL,                           # cost of total menu item
    menuPrice       int(10) NOT NULL,                           # menu price
    
    PRIMARY KEY     (recipeId)
    
)ENGINE=MyISAM DEFAULT CHARSET=UTF8 AUTO_INCREMENT=2;# MySQL returned an empty result set (i.e. zero rows).


DROP TABLE IF EXISTS members;# MySQL returned an empty result set (i.e. zero rows).

CREATE TABLE members
(
    memberID        int(11) NOT NULL AUTO_INCREMENT,
    username        varchar(255) NOT NULL DEFAULT '',
    password        varchar(32) NOT NULL DEFAULT '',
    dateCreated     timestamp NOT NULL,
    
    PRIMARY KEY (memberID)
    
)ENGINE=MyISAM DEFAULT CHARSET=UTF8 AUTO_INCREMENT=2;# MySQL returned an empty result set (i.e. zero rows).

    
INSERT INTO members (memberID, username, password) VALUES
    (1, 'admin', 'admin');# 1 row affected.
