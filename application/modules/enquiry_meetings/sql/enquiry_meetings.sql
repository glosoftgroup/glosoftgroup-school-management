CREATE TABLE IF NOT EXISTS  enquiry_meetings (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	title  varchar(256)  DEFAULT '' NOT NULL, 
	person_to_meet  varchar(32)  DEFAULT '' NOT NULL, 
	proposed_date  INT(11), 
	time  varchar(256)  DEFAULT '' NOT NULL, 
	reason  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;