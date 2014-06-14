-- create database section ------------------------------------------------------

CREATE DATABASE IF NOT EXISTS sepr;

-- Create user Section --------------------------------------------------

CREATE User ''@'%' IDENTIFIED BY '';

GRANT ALL PRIVILEGES on sepr.* to ''@'%';

FLUSH PRIVILEGES;

-- drop table section -----------------------------------------------------------

DROP TABLE IF EXISTS sepr.user_auth;
DROP TABLE IF EXISTS sepr.session_otun;

-- create table section ---------------------------------------------------------

CREATE TABLE IF NOT EXISTS sepr.user_auth
(
  email_address Char(50) NOT NULL,
  user_name Char(25) NOT NULL,
  passw Char(255) NOT NULL,
  secure_question Char(255) NOT NULL,
  secure_answer Char(255) NOT NULL,
  PRIMARY KEY (email_address),
  UNIQUE email_address (email_address),
  UNIQUE usera_name (user_name)
);

-- create table user permissions ------------------------------------------------

CREATE TABLE IF NOT EXISTS `sepr.permissions` (
  `user_name` char(25) NOT NULL,
  `create` tinyint(1) DEFAULT '0',
  `read` tinyint(1) DEFAULT '0',
  `update` tinyint(1) DEFAULT '0',
  `delete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`user_name`)
);

-- create table otun ---one time use number----------------

CREATE TABLE IF NOT EXISTS sepr.otun (
user_name Char(25) NOT NULL,
otun Int NOT NULL UNIQUE,
created  datetime not null,
modified TIMESTAMP DEFAULT now(),
PRIMARY KEY (user_name),
UNIQUE otun (otun)
);

-- crete page table -----

CREATE TABLE IF NOT EXISTS sepr.page(
`page_id` Int NOT NULL AUTO_INCREMENT,
`last_edited_by` char(50) NOT NULL,
`created` datetime NOT NULL,
`modified` TIMESTAMP NOT NULL DEFAULT now(),
`text` text,
PRIMARY KEY (`page_id`)
);

-- drop trigger section ---------------------------------------------------------

DROP TRIGGER IF EXISTS sepr.tr_before_insert_auth;

-- create trigger section -------------------------------------------------------

delimiter |
CREATE TRIGGER sepr.tr_before_insert_auth
BEFORE INSERT ON sepr.user_auth
FOR EACH ROW BEGIN
IF (NEW.email_address IS NOT NULL) THEN
            SET NEW.email_address = NEW.email_address;
        END IF;
IF (NEW.user_name IS NOT NULL) THEN
            SET NEW.user_name = NEW.user_name;
        END IF;
IF (NEW.passw IS NOT NULL) THEN
            SET NEW.passw = SHA2(NEW.passw, 256);
        END IF;
IF (NEW.secure_question IS NOT NULL) THEN
            SET NEW.secure_question = NEW.secure_question;
        END IF;
IF (NEW.secure_answer IS NOT NULL) THEN
            SET NEW.secure_answer = SHA2(NEW.secure_answer, 256);
        END IF;
END |
delimiter;

-- Realtionships ------------------------

ALTER TABLE sepr.otun ADD
CONSTRAINT user_otun_user_name_fk
FOREIGN KEY (user_name)
REFERENCES sepr.user_auth (user_name)
ON DELETE NO ACTION
ON UPDATE NO ACTION
;

ALTER TABLE sepr.permissions ADD
CONSTRAINT user_permissions_user_name_fk
FOREIGN KEY (user_name)
REFERENCES sepr.user_auth (user_name)
ON DELETE NO ACTION
ON UPDATE NO ACTION
;

ALTER TABLE sepr.page ADD
CONSTRAINT page_created_by_user_name_fk
FOREIGN KEY (last_edited_by)
REFERENCES sepr.user_auth (user_name)
ON DELETE NO ACTION
ON UPDATE NO ACTION
;

-- populate section -------------------------------------------------------------

INSERT INTO sepr.user_auth (email_address,user_name,passw, secure_question,secure_answer) VALUES
('admin','administrator','admin','What are we doing?','testing');
('anonymous','anonymous','anonymous','What are we doing?','testing');
('user1@email.com','user1','user1','What are we doing?','testing'),
('user2@email.com','user2','user2','What are we doing?','testing');

INSERT INTO sepr.permissions (`user_name`,`create`, `read`, `update`, `delete`) VALUES
('administrator', 1,1,1,1),
('anonymous', 0,1,0,0),
('user1',0,1,1,0),
('user2',1,1,1,0);

INSERT INTO sepr.page (last_edited_by,created,text) VALUES
('user1',now(),'This is a demo page content.'),
('user2',now(),'This is another page content demo.');

-- TESTING ----------------------------------------------------------------------

select * from sepr.user_auth where passw = sha2('password_testing',256);

show triggers from sepr;

