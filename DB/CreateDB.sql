/* create the DB */
CREATE DATABASE FaceAfeka;
USE FaceAfeka;

CREATE TABLE Users(
  UserID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Username VARCHAR(45) NOT NULL,
  Password VARCHAR(255) NOT NULL,
  PRIMARY KEY (UserID)
);

INSERT into Users (Username, Password) values ('EranLaudin', '393cf13dea198de16792babb0e6628d5');
INSERT into Users (Username, Password) values ('OhadCohen', 'f45fb23a59cc8bcd9de4952b33f473dc');
INSERT into Users (Username, Password) values ('NirLevi', 'd75f00b502dc1f485f80141dac1a38bc');
