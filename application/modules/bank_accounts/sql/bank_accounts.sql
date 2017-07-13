CREATE TABLE bank_accounts (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
bank_name  varchar(32)  DEFAULT '' NOT NULL, 
account_name  varchar(256)  DEFAULT '' NOT NULL, 
account_number  varchar(256)  DEFAULT '' NOT NULL, 
branch  varchar(256)  DEFAULT '' NOT NULL, 
description  text  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;