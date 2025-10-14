START TRANSACTION;

DROP TABLE IF EXISTS `admindata`;
CREATE TABLE `admindata`
(
    `id`       int(11) PRIMARY KEY AUTO_INCREMENT,
    `email`    varchar(45)  NOT NULL,
    `password` varchar(255) NOT NULL
) AUTO_INCREMENT = 3;



DROP TABLE IF EXISTS `availability`;
CREATE TABLE `availability`
(
    `userid`    varchar(20) DEFAULT NULL,
    `d`         date NOT NULL,
    `starttime` time NOT NULL,
    `endtime`   time        DEFAULT NULL,
    `reason`    varchar(15) DEFAULT 'manual'
);

DROP TABLE IF EXISTS `degree`;
CREATE TABLE `degree`
(
    `Degree_id`  int(5) PRIMARY KEY AUTO_INCREMENT,
    `degreeName` varchar(255) NOT NULL
) AUTO_INCREMENT = 2;



DROP TABLE IF EXISTS `mailbox`;
CREATE TABLE `mailbox`
(
    `id`      int(45) PRIMARY KEY AUTO_INCREMENT,
    `Subject` varchar(255) NOT NULL,
    `message` varchar(255) NOT NULL,
    `sentby`  varchar(60)  NOT NULL,
    `sentto`  varchar(60)  NOT NULL,
    `created` datetime     NOT NULL
) AUTO_INCREMENT = 24;



DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages`
(
    `id`       int(6) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `message`  varchar(255) NOT NULL,
    `reg_date` timestamp    NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) AUTO_INCREMENT = 2;



DROP TABLE IF EXISTS `recurringavailability`;
CREATE TABLE `recurringavailability`
(
    `userid`        varchar(20) DEFAULT NULL,
    `weekstartdate` date                NOT NULL,
    `dayindex`      tinyint(3) UNSIGNED NOT NULL,
    `starttime`     time                NOT NULL,
    `endtime`       time        DEFAULT NULL
);



DROP TABLE IF EXISTS `requestbox`;
CREATE TABLE `requestbox`
(
    `id`                 int(45) PRIMARY KEY AUTO_INCREMENT,
    `skillName`          varchar(255) NOT NULL,
    `message`            varchar(255) NOT NULL,
    `credits`            int(5)       NOT NULL,
    `requestee`          varchar(60)  NOT NULL,
    `requester`          varchar(60)  NOT NULL,
    `proposedDate`       datetime     NOT NULL,
    `created`            datetime     NOT NULL,
    `requesteeAgreed`    tinyint(1)   NOT NULL DEFAULT 0,
    `requesterAgreed`    tinyint(1)   NOT NULL DEFAULT 0,
    `requesterConfirmed` tinyint(1)   NOT NULL DEFAULT 0,
    `requesteeConfirmed` tinyint(1)   NOT NULL DEFAULT 0,
    `creditsReleased`    tinyint(1)   NOT NULL DEFAULT 0
) AUTO_INCREMENT = 4;



DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews`
(
    `id`      int(45)     NOT NULL,
    `user`    varchar(45) NOT NULL,
    `product` varchar(45) NOT NULL,
    `rating`  int(45)     NOT NULL,
    `review`  varchar(45) NOT NULL
);



DROP TABLE IF EXISTS `skills`;
CREATE TABLE `skills`
(
    `skillName` varchar(60) PRIMARY KEY,
    `academic`  tinyint(1)                 NOT NULL,
    `status`    enum ('active','inactive') NOT NULL
);


DROP TABLE IF EXISTS `userrequestedskills`;
CREATE TABLE `userrequestedskills`
(
    `id`        int(11)      NOT NULL,
    `skillName` varchar(255) NOT NULL,
    PRIMARY KEY (id, skillName)
);



DROP TABLE IF EXISTS `userrequests`;
CREATE TABLE `userrequests`
(
    `request_ID` int(10) PRIMARY KEY AUTO_INCREMENT,
    `userID`     tinyint(10)  NOT NULL,
    `Request`    varchar(255) NOT NULL
);


DROP TABLE IF EXISTS `userdata`;
CREATE TABLE `userdata`
(
    `id`             int(11) PRIMARY KEY AUTO_INCREMENT,
    `email`          varchar(45)          NOT NULL,
    `firstName`      varchar(80)          NOT NULL,
    `lastName`       varchar(80)          NOT NULL,
    `password`       varchar(255)         NOT NULL,
    `imageName`      varchar(255)         NOT NULL DEFAULT 'default-avatar.jpg',
    `imagePath`      varchar(255)         NOT NULL DEFAULT '../userProfilePictures/default-avatar.jpg',
    `academicYear`   tinyint(3)           NOT NULL DEFAULT 1,
    `credits`        smallint(4) UNSIGNED NOT NULL,
    `college`        varchar(60)          NOT NULL,
    `bio`            varchar(255)         NOT NULL,
    `availability`   varchar(255)                  DEFAULT NULL,
    `last_active`    date                          DEFAULT '2025-01-01',
    `Suspended`      tinyint(1)           NOT NULL DEFAULT 0,
    `suspendedUntil` date                          DEFAULT NULL,
    `Deleted`        tinyint(1)           NOT NULL DEFAULT 0,
    `admin`          tinyint(1)           NOT NULL DEFAULT 0
) AUTO_INCREMENT = 9;


DROP TABLE IF EXISTS `userskills`;
CREATE TABLE `userskills`
(
    `id`        int(11) REFERENCES userdata (id) ON DELETE CASCADE ON UPDATE CASCADE,
    `skillName` varchar(60) NOT NULL,
    PRIMARY KEY (id, skillName)
);



DROP TABLE IF EXISTS `user_mailbox`;
CREATE TABLE `user_mailbox`
(
    `id`         int(45) PRIMARY KEY AUTO_INCREMENT,
    `user`       varchar(45) NOT NULL,
    `mailbox`    varchar(45) NOT NULL,
    `mailbox_id` int(45) REFERENCES mailbox (id) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT = 34;



DROP TABLE IF EXISTS `user_requestbox`;
CREATE TABLE `user_requestbox`
(
    `id`             int(45) PRIMARY KEY AUTO_INCREMENT,
    `user`           varchar(45) NOT NULL,
    `requestboxType` varchar(45) NOT NULL,
    `requestBox_id`  int(45)     NOT NULL
) AUTO_INCREMENT = 6;


--

INSERT INTO `admindata` (`id`, `email`, `password`)
VALUES (1, 'putl0014@flinders.edu.au', '$2y$10$ds4ha4PtWZZZ2Xk9G.4pRuKwAcJSeKQczEOYZDqMIjimGrtasegtG'),
       (2, 'bob@flinders.edu.au', '$2y$10$ds4ha4PtWZZZ2Xk9G.4pRuKwAcJSeKQczEOYZDqMIjimGrtasegtG');


INSERT INTO `degree` (`Degree_id`, `degreeName`)
VALUES (1, 'DegreeName');

INSERT INTO `mailbox` (`id`, `Subject`, `message`, `sentby`, `sentto`, `created`)
VALUES (1, 'test', 'test', 'bob@flinders.edu.au', 'putl0014@flinders.edu.au', '2025-10-07 12:30:00'),
       (2, 'Bob the tester', 'hello bob the tester', 'bob@flinders.edu.au', 'putl0014@flinders.edu.au',
        '2025-10-08 05:30:14'),
       (3, 'Testing Time Zone', 'it is currently 2:09pm', 'putl0014@flinders.edu.au', 'bob@flinders.edu.au',
        '2025-10-08 14:09:30'),
       (4, 'character limit',
        'gfwhyuISKKKKKKKKKKKKKKKKKKKKKKKDHGAHSDFAHKGJFDSHKJFSHAGKJHGKJFSAHGSAFHGJASFHJGASFHGJFHJASGHGJSFAHGJFSAHGJSFAHGSAFGHJhjfjahkshjsfajhfsajhsafhjjfasjklfasjhlkfashjlfashjfashjfhsajhjfasjhkafsjhkfashjklfasljhlfasjlhafsjlhfasljhkafsljhkfashjlkhfjaslhjafshjklasf',
        'putl0014@flinders.edu.au', 'bob@flinders.edu.au', '2025-10-08 14:17:27'),
       (5, 'Hello', 'testing Message', 'putl0014@flinders.edu.au', 'bob@flinders.edu.au', '2025-10-08 14:28:04'),
       (6, 'Hello', 'test 4', 'putl0014@flinders.edu.au', 'bob@flinders.edu.au', '2025-10-08 14:32:15'),
       (7, 'test 1 2 3', 'test 1 2 3', 'putl0014@flinders.edu.au', 'test@flinders.edu.au', '2025-10-11 19:47:09'),
       (14, 'test 1 2 3', 'test 1 2 3', 'putl0014@flinders.edu.au', 'test@flinders.edu.au', '2025-10-11 19:49:46'),
       (15, 'Test #9', 'Mambo # 5', 'putl0014@flinders.edu.au', 'test@flinders.edu.au', '2025-10-11 19:50:08'),
       (16, 'Request for chat', 'Hello, lorem ipsum blah blah', 'test1@flinders.edu.au', 'putl0014@flinders.edu.au',
        '2025-10-12 15:49:20'),
       (17, 'Hello', 'Hello and Welcome to FUSS, can I help you with anything', 'test1@flinders.edu.au',
        'putl0014@flinders.edu.au', '2025-10-12 15:49:53'),
       (18, 'Help Im stuck', 'Help Im stuck in the database let me out', 'test1@flinders.edu.au',
        'putl0014@flinders.edu.au', '2025-10-12 15:50:13'),
       (19, 'JK Im okay', 'totally not a bot .exe', 'test1@flinders.edu.au', 'putl0014@flinders.edu.au',
        '2025-10-12 15:50:32'),
       (20, 'Message #7', 'Test message number 7', 'test1@flinders.edu.au', 'putl0014@flinders.edu.au',
        '2025-10-12 15:51:15'),
       (21, 'Test msg #8', 'god this is boring', 'test1@flinders.edu.au', 'putl0014@flinders.edu.au',
        '2025-10-12 15:51:33'),
       (22, 'Test #10', 'god is it over for me?', 'test1@flinders.edu.au', 'putl0014@flinders.edu.au',
        '2025-10-12 15:51:47'),
       (23, 'Hello have you heard the good word?', 'The bird is the word', 'test1@flinders.edu.au',
        'putl0014@flinders.edu.au', '2025-10-12 15:52:04');

INSERT INTO `messages` (`id`, `message`, `reg_date`)
VALUES (1, 'Connection and insert into db successful', '2025-10-03 04:21:27');


INSERT INTO `recurringavailability` (`userid`, `weekstartdate`, `dayindex`, `starttime`, `endtime`)
VALUES ('testuser1', '2025-09-15', 0, '21:10:17', '21:10:25'),
       ('testuser1', '2025-01-06', 2, '18:16:29', '23:16:32'),
       ('testuser1', '2025-09-15', 5, '10:30:00', '11:45:00');

INSERT INTO `requestbox` (`id`, `skillName`, `message`, `credits`, `requestee`, `requester`, `proposedDate`, `created`,
                          `requesteeAgreed`, `requesterAgreed`, `requesterConfirmed`, `requesteeConfirmed`,
                          `creditsReleased`)
VALUES (3, 'Jedi Mind Tricks', 'Help me I wish to learn the force', 1, '1', '7', '2026-05-04 17:37:00',
        '2025-10-12 17:37:44', 1, 1, 1, 1, 1);

INSERT INTO `reviews` (`id`, `user`, `product`, `rating`, `review`)
VALUES (3, '1', 'Jedi Mind Tricks', 1, 'Blah blah student talked too much'),
       (3, '7', 'Jedi Mind Tricks', 5, 'Teacher was super patient with me');

INSERT INTO `skills` (`skillName`, `academic`, `status`)
VALUES ('academicTest', 1, 'active'),
       ('academicTest1', 1, 'active'),
       ('academicTest2', 1, 'active'),
       ('academicTest3', 1, 'active'),
       ('academicTest4', 1, 'active'),
       ('academicTest5', 1, 'active'),
       ('academicTest6', 1, 'active'),
       ('Basic C++ Programming', 1, 'active'),
       ('Basic HTML', 1, 'active'),
       ('Basic JavaScript', 1, 'active'),
       ('Basic PHP', 1, 'active'),
       ('Basic Report Writing', 1, 'active'),
       ('Basic SQL', 1, 'active'),
       ('Expert HTML', 1, 'active'),
       ('Expert JavaScript', 1, 'active'),
       ('Expert PHP', 1, 'active'),
       ('Expert Report Writing', 1, 'active'),
       ('Expert SQL', 1, 'active'),
       ('House Moving', 0, 'active'),
       ('How to Make Friendships', 0, 'active'),
       ('Intermediate HTML', 1, 'active'),
       ('Intermediate JavaScript', 1, 'active'),
       ('Intermediate PHP', 1, 'active'),
       ('Intermediate Report Writing', 1, 'active'),
       ('Intermediate SQL', 1, 'active'),
       ('Learning to Draw', 0, 'active'),
       ('nonAcademicTest1', 0, 'active'),
       ('nonAcademicTest2', 0, 'active'),
       ('nonAcademicTest3', 0, 'active'),
       ('nonAcademicTest4', 0, 'active'),
       ('nonAcademicTest5', 0, 'active'),
       ('nonAcademicTest6', 0, 'active'),
       ('nonAcademicTest7', 0, 'active'),
       ('nonAcademicTest8', 0, 'active'),
       ('Sketching Profiles', 0, 'active');

INSERT INTO `userdata` (`id`, `email`, `firstName`, `lastName`, `password`, `imageName`, `imagePath`, `academicYear`,
                        `credits`, `college`, `bio`, `availability`, `last_active`, `Suspended`, `suspendedUntil`,
                        `Deleted`, `admin`)
VALUES (1, 'putl0014@flinders.edu.au', 'Jayden', 'Putland',
        '$2y$10$ds4ha4PtWZZZ2Xk9G.4pRuKwAcJSeKQczEOYZDqMIjimGrtasegtG', 'default-avatar.jpg',
        '../userProfilePictures/default-avatar.jpg', 1, 16, 'Information Science', 'Not an explodey',
        'Wednesdays after 4pm', '2025-10-11', 0, NULL, 0, 1),
       (2, 'bob@flinders.edu.au', 'Bob', 'Test', '$2y$10$FhUF0v/ZyEzPw6GLdOuwEONmeEuBpzZxrFQ8VqGk6JJuytP.G.RQ6',
        'default-avatar.jpg', '../userProfilePictures/default-avatar.jpg', 0, 1, '', '', NULL, CURRENT_DATE, 0, NULL, 0,
        1),
       (3, 'test@flinders.edu.au', 'First', 'Last', '$2y$10$mmiNWdOSqK0HWZaRtcNHe.yjyoB3khBe.Ickx8DG3Rs4mrYIwj1r6',
        'default-avatar.jpg\n', '../userProfilePictures/default-avatar.jpg', 0, 1, '', '',
        'Monday All Day, Tuesday after 11am, Friday Before 3pm', CURRENT_DATE, 1, '2025-10-11', 0, 0),
       (4, 'klen0010@flinders.edu.au', 'Lachlan', 'Lachlans Last Name ',
        '$2y$10$ds4ha4PtWZZZ2Xk9G.4pRuKwAcJSeKQczEOYZDqMIjimGrtasegtG', 'default-avatar.jpg',
        '../userProfilePictures/default-avatar.jpg', 0, 1, '', '', NULL, CURRENT_DATE, 0, NULL, 0, 1),
       (5, 'wach0035@flinders.edu.au', 'Thomas', 'Thomas Last Name ',
        '$2y$10$ds4ha4PtWZZZ2Xk9G.4pRuKwAcJSeKQczEOYZDqMIjimGrtasegtG', 'default-avatar.jpg',
        '../userProfilePictures/default-avatar.jpg', 0, 1, '', '', NULL, CURRENT_DATE, 0, NULL, 0, 1),
       (6, 'mane0039@flinders.edu.au', 'Liam', 'Liams Last Name ',
        '$2y$10$ds4ha4PtWZZZ2Xk9G.4pRuKwAcJSeKQczEOYZDqMIjimGrtasegtG', 'default-avatar.jpg',
        '../userProfilePictures/default-avatar.jpg', 0, 1, '', '', NULL, CURRENT_DATE, 0, NULL, 0, 1),
       (7, 'test1@flinders.edu.au', 'First', 'First', '$2y$10$gtZWRpAnqTP.rULVLI8UDupGWZv4HENHSJmWhX7.2u.eKJxvhPJLy',
        'default-avatar.jpg', '../userProfilePictures/default-avatar.jpg', 1, 0, '', '', 'Hell freezing over', NULL, 0,
        NULL, 0, 0),
       (8, 'firstfirster@flinders.edu.au', 'First', 'Firster',
        '$2y$10$FA.sjxbbbKVRlFLX783YXezY/lM7QIA3bGcsj.6ZG6/fs69Be91i2', 'default-avatar.jpg',
        '../userProfilePictures/default-avatar.jpg', 1, 1, '', '', NULL, NULL, 0, NULL, 1, 0);

INSERT INTO `userrequestedskills` (`id`, `skillName`)
VALUES (1, 'House Moving'),
       (1, 'nonAcademicTest8');

INSERT INTO `userskills` (`id`, `skillName`)
VALUES (1, 'academicTest'),
       (1, 'academicTest1'),
       (1, 'academicTest2'),
       (1, 'Basic C++ Programming'),
       (1, 'House Moving'),
       (1, 'nonAcademicTest1'),
       (1, 'nonAcademicTest5'),
       (2, 'academicTest4'),
       (2, 'academicTest5'),
       (2, 'House Moving'),
       (2, 'nonAcademicTest5'),
       (3, 'Basic HTML'),
       (3, 'Basic JavaScript'),
       (3, 'Basic Report Writing'),
       (3, 'Expert HTML'),
       (3, 'Expert JavaScript'),
       (3, 'Expert Report Writing'),
       (3, 'House Moving'),
       (3, 'Intermediate HTML'),
       (3, 'Intermediate JavaScript'),
       (3, 'Intermediate Report Writing');


INSERT INTO `user_mailbox` (`id`, `user`, `mailbox`, `mailbox_id`)
VALUES (1, 'bob@flinders.edu.au', 'Out', 1),
       (2, 'putl0014@flinders.edu.au', 'In', 1),
       (3, 'putl0014@flinders.edu.au', 'In', 2),
       (4, 'bob@flinders.edu.au', 'Out', 2),
       (5, 'bob@flinders.edu.au', 'In', 3),
       (6, 'putl0014@flinders.edu.au', 'Out', 3),
       (7, 'bob@flinders.edu.au', 'In', 4),
       (8, 'putl0014@flinders.edu.au', 'Out', 4),
       (9, 'bob@flinders.edu.au', 'In', 5),
       (10, 'putl0014@flinders.edu.au', 'Out', 5),
       (11, 'bob@flinders.edu.au', 'In', 6),
       (12, 'putl0014@flinders.edu.au', 'Out', 6),
       (14, 'test@flinders.edu.au', 'In', 14),
       (15, 'putl0014@flinders.edu.au', 'Out', 14),
       (16, 'test@flinders.edu.au', 'In', 15),
       (17, 'putl0014@flinders.edu.au', 'Out', 15),
       (18, 'putl0014@flinders.edu.au', 'In', 16),
       (19, 'test1@flinders.edu.au', 'Out', 16),
       (20, 'putl0014@flinders.edu.au', 'In', 17),
       (21, 'test1@flinders.edu.au', 'Out', 17),
       (22, 'putl0014@flinders.edu.au', 'In', 18),
       (23, 'test1@flinders.edu.au', 'Out', 18),
       (24, 'putl0014@flinders.edu.au', 'In', 19),
       (25, 'test1@flinders.edu.au', 'Out', 19),
       (26, 'putl0014@flinders.edu.au', 'In', 20),
       (27, 'test1@flinders.edu.au', 'Out', 20),
       (28, 'putl0014@flinders.edu.au', 'In', 21),
       (29, 'test1@flinders.edu.au', 'Out', 21),
       (30, 'putl0014@flinders.edu.au', 'In', 22),
       (31, 'test1@flinders.edu.au', 'Out', 22),
       (32, 'putl0014@flinders.edu.au', 'In', 23),
       (33, 'test1@flinders.edu.au', 'Out', 23);

INSERT INTO `user_requestbox` (`id`, `user`, `requestboxType`, `requestBox_id`)
VALUES (2, '7', 'In', 2),
       (3, '7', 'Out', 2),
       (4, '1', 'In', 3),
       (5, '7', 'Out', 3);

COMMIT;
