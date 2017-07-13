CREATE TABLE meetings (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
title  varchar(256)  DEFAULT '' NOT NULL, 
start_date  INT(11), 
end_date  INT(11), 
type  INT(11), 
venue  varchar(256)  DEFAULT '' NOT NULL, 
importance  varchar(32)  DEFAULT '' NOT NULL, 
status  varchar(32)  DEFAULT '' NOT NULL, 
guests  varchar(256)  DEFAULT '' NOT NULL, 
description  text  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;