DROP TABLE IF EXISTS login_attempts;
DROP TABLE IF EXISTS COMMANDS;
DROP TABLE IF EXISTS RPISTATUS;
DROP TABLE IF EXISTS RPI;
DROP TABLE IF EXISTS members;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS RPISTATUS;

CREATE TABLE members(
   id          INT            NOT NULL AUTO_INCREMENT,
   username    varchar (30)   NOT NULL,
   email       VARCHAR (50)   NOT NULL,                                   # used as loginame
   password    VARCHAR (128)   NOT NULL,
   salt        VARCHAR (128)   NOT NULL,
   firstName   VARCHAR (30)           ,
   lastName    VARCHAR (30)           ,
   company     VARCHAR (30)           ,
   phonumber   VARCHAR (20)           ,
   unitPermis  SMALLINT       NOT NULL,                                   # 0 = own units, 1 = all units
   custPermis  SMALLINT       Not NULL,                                   # 0 = no access, 1 = access 2 = admin
   creatTime   TIMESTAMP      NOT NULL,         # Creation time
   PRIMARY KEY (id, username)
) ENGINE = InnoDB;


CREATE TABLE users(

   `userID` int(11) NOT NULL AUTO_INCREMENT,
   `username` varchar(50) NOT NULL,
   `password` varbinary(250) NOT NULL,
   PRIMARY KEY (`userID`,`username`)
)  ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

CREATE TABLE login_attempts (
    user_id INT(11) NOT NULL,
    time VARCHAR(30) NOT NULL
)   ENGINE=InnoDB;

CREATE TABLE RPI(
   mac            VARCHAR (17)   NOT NULL,
   creatTime      TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,    # Creation time
   PRIMARY KEY (mac)
);

CREATE TABLE RPISTATUS(
   id             INT            NOT NULL AUTO_INCREMENT,
   ip             VARCHAR (15)   NOT NULL,
   wan            VARCHAR (15)   NOT NULL,
   mac            VARCHAR (17)   NOT NULL,
   cpu            VARCHAR (8)    NOT NULL,
   ram            VARCHAR (8)    NOT NULL,
   messageSpeed   VARCHAR (8)   ,
   orientation    SMALLINT       NOT NULL,
   url            VARCHAR (2000) ,
   urlViaServer   SMALLINT       ,                                      # 0 = direct 1 =  via cloudscreen.dk 
   creatTime      TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,    # Creation time
   PRIMARY KEY (id),
   FOREIGN KEY (mac)  REFERENCES RPI(mac)
);

CREATE TABLE COMMANDS(
   id             INT            NOT NULL AUTO_INCREMENT,
   mac            VARCHAR (17)   NOT NULL,
   command        VARCHAR (8000) ,                                      # Shell command
   orientation    SMALLINT       ,                                      # 0 = landscape 1 = potrait
   url            VARCHAR (2000) ,
   urlViaServer   SMALLINT       ,                                      # 0 = direct 1 =  via cloudscreen.dk 
   creatTime      TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,    # Creation time
   PRIMARY KEY (id),
   FOREIGN KEY (mac)  REFERENCES RPI(mac)
);

# create secure user for login php
INSERT INTO members VALUES(1, 'seb', 'sebastian@lapela.dk',
'00807432eae173f652f2064bdca1b61b290b52d40e429a7d295d76a71084aa96c0233b82f1feac45529e0726559645acaed6f3ae58a286b9f075916ebf66cacc',
'f9aab579fc1b41ed0c44fe4ecdbfcdb4cb99b9023abb241a6db833288f4eea3c02f76e0d35204a8695077dcf81932aa59006423976224be0390395bae152d4ef',
'sebastian', 'jensen', 'lapela', '22772357', 1, 2, CURRENT_TIMESTAMP);


INSERT INTO `users` (`userID`, `username`, `password`) VALUES
(3, 'papabear', '19ab5b345576117c60091c27df896684f259a4dd16a4acc66c829b3a39565cfc'),
(4, 'aaa', '485012098aa94a2a115382ea6bc6f9838c5d91abe5a64c7ff4d321ec6226df77'),
(5, 'ddd', 'bce58e68e8ebf51808f9a32199c410f5be898046ef191b320a3a26644db990dd');

/*
# insert sample information to members
INSERT INTO members (FirstName, LastName, Email, Password) VALUES('Oscar', 'Roth Andersen', 'oscarrothandersen@gmail.com', 'passw0rd');
INSERT INTO members (FirstName, LastName, Email, Password) VALUES('Vivien', 'verdens-n�stl�ngeste-navn', 'vivien@gmail.com', 'p4ssw0rd');
INSERT INTO members (FirstName, LastName, Email, Password) VALUES('Sebastian', 'Ostenfeldt Jensen', 'sebastian@momentos.dk', 'pa55w0rd');

# insert sample information to PERMISSIONS
INSERT INTO permissions (RankName, Organise, Scannerman, Scan) VALUES('Organiser', TRUE, TRUE, TRUE);
INSERT INTO permissions (RankName, Organise, Scannerman, Scan) VALUES('Scannerman', FALSE, FALSE, TRUE);
INSERT INTO permissions (RankName, Organise, Scannerman, Scan) VALUES('Right hand', FALSE, TRUE, TRUE);
INSERT INTO permissions (RankName, Organise, Scannerman, Scan) VALUES('Guest', FALSE, FALSE, FALSE);

# insert sample information to CATEGORIES
INSERT INTO categories (CatName) VALUES('Fest');
INSERT INTO categories (CatName) VALUES('Koncert');
INSERT INTO categories (CatName) VALUES('Messe');
INSERT INTO categories (CatName) VALUES('Cirkus');

# insert sample information to ADS
INSERT INTO ads (AdName, AdPicture) VALUES('Carlsberg', 'carlsberg.png');
INSERT INTO ads (AdName, AdPicture) VALUES('Bog og Id�', 'relevant.png');
INSERT INTO ads (AdName, AdPicture) VALUES('Tycho Brahe's Studiebod', 'wuuut.png');

# insert sample information to EVENTS
INSERT INTO events (CategoryId, AdId, EventName, EventStart, EventEnd, Description, Location, Venue, URLName, Publicity) 
       VALUES (1, 2, 'Fishing in a pond', '2014-04-20 16:00:00', '2014-04-20 23:00:00', 'Det her bliver for vildt!!!', 'Ved andedammen', 'Andedammen', 'andedam', TRUE);
INSERT INTO events (CategoryId, AdId, EventName, EventStart, EventEnd, Description, Location, Venue, URLName, Publicity) 
       VALUES (2, 2, 'Vivien bliver oldgammel', '2014-04-29 08:00:00', '2014-04-30 23:00:00', '10000 �r gammel', 'Under bordet', 'Under bordet', 'vivien', TRUE);

# insert sample information to TICKETS
INSERT INTO tickets (UserId, EventId, Details, QRcode, IP) VALUES(1, 32, '...', 'QRQRQRQR', '234.543.234.543');
INSERT INTO tickets (UserId, EventId, Details, QRcode, IP) VALUES(2, 32, '...', 'QRQRQRQR', '234.543.234.543');
INSERT INTO tickets (UserId, EventId, Details, QRcode, IP) VALUES(3, 32, '...', 'QRQRQRQR', '234.543.234.543');
INSERT INTO tickets (UserId, EventId, Details, QRcode, IP) VALUES(2, 33, '...', 'QRQRQRQR', '234.543.234.543');

# insert sample information to ACTORS
INSERT INTO actors (EventId, UserId, RankId) VALUES(32, 1, 1);
INSERT INTO actors (EventId, UserId, RankId) VALUES(32, 2, 2);
INSERT INTO actors (EventId, UserId, RankId) VALUES(32, 3, 3);
INSERT INTO actors (EventId, UserId, RankId) VALUES(33, 1, 4);
INSERT INTO actors (EventId, UserId, RankId) VALUES(33, 2, 3);
*/
