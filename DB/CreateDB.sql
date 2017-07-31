/* create the DB */
CREATE DATABASE FaceAfeka;
USE FaceAfeka;

CREATE TABLE Users(
  UserID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Username VARCHAR(45) NOT NULL,
  Password VARCHAR(255) NOT NULL,
  PRIMARY KEY (UserID)
);

INSERT into Users (Username, Password) values ('Eran Laudin', '393cf13dea198de16792babb0e6628d5');
INSERT into Users (Username, Password) values ('Ohad Cohen', 'f45fb23a59cc8bcd9de4952b33f473dc');
INSERT into Users (Username, Password) values ('Nir Levi', 'd75f00b502dc1f485f80141dac1a38bc');
INSERT into Users (Username, Password) values ('Yael Gersh', '354b9213c1464bccf703d6ca97186827');
INSERT into Users (Username, Password) values ('Avi Elgal', '2700ba29cd5b2b69e9dbcbc31d221ae5');
INSERT into Users (Username, Password) values ('Omri Koresh', '7a1d24e641b6cf74f1c5b0e7fd9b8f46');

CREATE TABLE Friends(
  User1 VARCHAR(45) NOT NULL,
  User2 VARCHAR(45) NOT NULL,
  FOREIGN KEY (User1) REFERENCES Users (Username),
  FOREIGN KEY (User2) REFERENCES Users (Username)
);

INSERT INTO friends VALUES ('Nir Levi', 'Eran Laudin');
INSERT INTO friends VALUES ('Nir Levi', 'Ohad Cohen');
INSERT INTO friends VALUES ('Eran Laudin', 'Ohad Cohen');
INSERT INTO friends VALUES ('Yael Gersh', 'Ohad Cohen');
INSERT INTO friends VALUES ('Eran Laudin', 'Yael Gersh');
INSERT INTO friends VALUES ('Eran Laudin', 'Avi Elgal');


CREATE TABLE Posts(
  PostID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Status VARCHAR(45),
  ImgSrc VARCHAR(255),
  Publisher VARCHAR(45) NOT NULL,
  Privacy VARCHAR(45) NOT NULL,
  Likes INTEGER NOT NULL DEFAULT 0,
  Date DATETIME NOT NULL,
  PRIMARY KEY (PostID)
);

INSERT INTO Posts (Status, ImgSrc, Publisher, Privacy, Date) VALUES
  ('This is a dog status.', '20170719153646889933074.jpg', 'Eran Laudin', 'Public', '2017-07-15 15:00:00');
INSERT INTO Posts (Status, ImgSrc, Publisher, Privacy, Date) VALUES
  ('MyStatus before', '', 'Eran Laudin', 'Public', '2017-07-13 20:05:32');
INSERT INTO Posts (Status, ImgSrc, Publisher, Privacy, Date) VALUES
  ('This is a cat status', '201707181724441840804854.png', 'Ohad Cohen', 'Public', '2017-07-14 14:22:22');
INSERT INTO Posts (Status, ImgSrc, Publisher, Privacy, Date) VALUES
  ('Hello World', '201707141001241501264039.png', 'Ohad Cohen', 'Public', '2017-07-17 20:12:38');


CREATE TABLE Comments(
  PostID INTEGER UNSIGNED NOT NULL,
  Comment VARCHAR(45) NOT NULL,
  Username VARCHAR(45) NOT NULL,
  Date DATETIME,
  FOREIGN KEY (PostID) REFERENCES Posts(PostID)
);

INSERT INTO Comments (PostID, Comment, Username, Date) VALUES
  (1 , 'Great job, mate!', 'Ohad Cohen', '2017-07-15 16:05:00');
INSERT INTO Comments (PostID, Comment, Username, Date) VALUES
  (1 , ':-)', 'Nir Levi', '2017-07-15 20:50:00');
INSERT INTO Comments (PostID, Comment, Username, Date) VALUES
  (1 , 'lolol', 'Eran Laudin', '2017-07-15 17:50:00');

