DROP TABLE IF EXISTS recurringAvailability, availability, userskills, users, skills;
#
CREATE TABLE IF NOT EXISTS skills (
    skill VARCHAR(30) PRIMARY KEY,
    academic TINYINT UNSIGNED NOT NULL
); -- stores 0/1 values to store if skill is academic. Can be extended for more categories


CREATE TABLE IF NOT EXISTS users (
    id VARCHAR(20) PRIMARY KEY,
    name VARCHAR(30),
    about VARCHAR(300),
    course VARCHAR(50),
    credits INT UNSIGNED DEFAULT 0,
    profile_pic_url VARCHAR(50),
    academicyear TINYINT UNSIGNED,
    college VARCHAR(30), -- Need to work out how to represent these
    suspendeduntil date,
    email VARCHAR(30)
    #,password VARCHAR(10) -- It would be funny

);


CREATE TABLE IF NOT EXISTS userskills (
    userid VARCHAR(20) REFERENCES users (id) ON DELETE CASCADE,
    skill VARCHAR(30) REFERENCES skills (skill) ON DELETE CASCADE,
    PRIMARY KEY (userid, skill),
    CONSTRAINT u UNIQUE (userid, skill)
);


CREATE TABLE IF NOT EXISTS availability (
    userid VARCHAR(20) REFERENCES users (id) ON DELETE CASCADE,
    d DATE NOT NULL,
    starttime TIME NOT NULL,
    endtime TIME,
    reason VARCHAR(15) DEFAULT 'manual'
);


CREATE TABLE IF NOT EXISTS recurringAvailability (
    userid VARCHAR(20) REFERENCES users (id) ON DELETE CASCADE,
    weekstartdate DATE NOT NULL,
    dayindex TINYINT UNSIGNED NOT NULL,
    starttime TIME NOT NULL,
    endtime TIME
);

CREATE TABLE IF NOT EXISTS request (
    requestid VARCHAR(20) PRIMARY KEY,
    d DATE,
    starttime TIME,
    duration TINYINT,
    requesterid VARCHAR(20) REFERENCES users (id),
    requesteeid VARCHAR(20) REFERENCES users (id),
    status VARCHAR(15) NOT NULL,
    datecompleted DATE,
    requesterreview VARCHAR(100),
    requesteereview VARCHAR(100)
);

# Testing data below
# Create test users
INSERT INTO users VALUES ('testuser1',
                          'Jim',
                          'Cool Guy',
                          'BIT',
                          10,
                          NULL,
                          2,
                          'CSE',
                          NULL,
                          'test@example.com');

INSERT INTO users VALUES ('testuser2',
                          'Bart',
                          'Cooler Guy',
                          'BBUSIB', -- Some sort of business degree
                          40,
                          NULL,
                          4,
                          'CBGL',
                          NULL,
                          'email@website.com');

# Insert non-academic skills
INSERT INTO skills VALUES ('Skill1', 0);
INSERT INTO skills VALUES ('Skill2', 0);
INSERT INTO skills VALUES ('Skill3', 0);
INSERT INTO skills VALUES ('Skill4', 0);
INSERT INTO skills VALUES ('Skill5', 0);
INSERT INTO skills VALUES ('Skill6', 0);
INSERT INTO skills VALUES ('Skill7', 0);
INSERT INTO skills VALUES ('Skill8', 0);
INSERT INTO skills VALUES ('Skill9', 0);
INSERT INTO skills VALUES ('Skill10', 0);

# Insert academic skills
INSERT INTO skills VALUES ('a', 1);
INSERT INTO skills VALUES ('b', 1);
INSERT INTO skills VALUES ('c', 1);
INSERT INTO skills VALUES ('d', 1);
INSERT INTO skills VALUES ('e', 1);

# Assign skills to user
INSERT INTO userskills VALUES ('testuser1', 'Skill0');
INSERT INTO userskills VALUES ('testuser1', 'Skill2');
INSERT INTO userskills VALUES ('testuser1', 'Skill4');
INSERT INTO userskills VALUES ('testuser1', 'Skill7');

INSERT INTO userskills VALUES ('testuser1', 'a');
INSERT INTO userskills VALUES ('testuser1', 'b');

INSERT INTO userskills VALUES ('testuser1', 'z');


INSERT INTO web_dev_db.recurringAvailability (userid, weekstartdate, dayindex, starttime, endtime) VALUES ('testuser1', '2025-09-15', 0, '21:10:17', '21:10:25');
INSERT INTO web_dev_db.recurringAvailability (userid, weekstartdate, dayindex, starttime, endtime) VALUES ('testuser1', '2025-01-06', 2, '18:16:29', '23:16:32');
INSERT INTO web_dev_db.recurringAvailability (userid, weekstartdate, dayindex, starttime, endtime) VALUES ('testuser1', '2025-09-15', 5, '10:30:00', '11:45:00');
