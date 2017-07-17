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

CREATE TABLE Friends(
  User1 VARCHAR(45) NOT NULL,
  User2 VARCHAR(45) NOT NULL,
  FOREIGN KEY (User1) REFERENCES Users (Username),
  FOREIGN KEY (User2) REFERENCES Users (Username)
);

INSERT INTO friends VALUES ('NirLevi', 'EranLaudin');
INSERT INTO friends VALUES ('EranLaudin', 'OhadCohen');

CREATE TABLE Posts(
  PostID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Status VARCHAR(45),
  ImgSrc VARCHAR(45),
  Publisher VARCHAR(45) NOT NULL,
  Privacy VARCHAR(45) NOT NULL,
  Likes INTEGER NOT NULL DEFAULT 0,
  Date DATE NOT NULL,
  PRIMARY KEY (PostID)
);

INSERT INTO Posts (Status, ImgSrc, Publisher, Privacy, Date) VALUES
  ('This is a dog status.', 'dog.jpg', 'EranLaudin', 'Public', '2017-07-15');
INSERT INTO Posts (Status, ImgSrc, Publisher, Privacy, Date) VALUES
  ('MyStatus before', '', 'EranLaudin', 'Public', '2017-07-13');
INSERT INTO Posts (Status, ImgSrc, Publisher, Privacy, Date) VALUES
  ('This is a cat status', '201707141001241501264039.png', 'OhadCohen', 'Public', '2017-07-14');


CREATE TABLE Comments(
  PostID INTEGER UNSIGNED NOT NULL,
  Comment VARCHAR(45) NOT NULL,
  Username VARCHAR(45) NOT NULL,
  Date DATE,
  FOREIGN KEY (PostID) REFERENCES Posts(PostID)
);

