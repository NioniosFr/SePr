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
  UNIQUE user_name (user_name)
);

-- create table otun ---one time use number----------------

CREATE TABLE IF NOT EXISTS sepr.session_otun
(
  otun Integer NOT NULL,
  user_name Char(50) NOT NULL,
  PRIMARY KEY (otun),
  UNIQUE otun (otun)
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

ALTER TABLE sepr.session_otun ADD 
CONSTRAINT user_auth_user_name_fk 
FOREIGN KEY (user_name) 
REFERENCES sepr.user_auth (user_name) 
ON DELETE NO ACTION 
ON UPDATE NO ACTION
;

-- populate section -------------------------------------------------------------

INSERT INTO sepr.user_auth (email_address,user_name,passw, secure_question,secure_answer) VALUES 
('user1@email.com','user1','password_testing','What are we doing?','testing'),
('user2@email.com','user2','password_testing','What are we doing?','testing');

-- TESTING ----------------------------------------------------------------------

select * from sepr.user_auth where passw = sha2('password_testing',256);

show triggers from sepr;

