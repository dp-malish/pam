CREATE TABLE IF NOT EXISTS user_agent(
  id int(11) NOT NULL AUTO_INCREMENT,
  browser varchar(255) NOT NULL,

  PRIMARY KEY (id)
 /* UNIQUE KEY link(link),
  KEY (heading,category)*/
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
