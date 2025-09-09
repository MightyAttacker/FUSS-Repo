CREATE TABLE IF NOT EXISTS skills (
    skill VARCHAR(30) PRIMARY KEY,
    academic TINYINT UNSIGNED NOT NULL
); -- stores 0/1 values to store if skill is academic. Can be extended for more categories 


CREATE TABLE IF NOT EXISTS users (
    id VARCHAR(20) PRIMARY KEY,
    about VARCHAR(300),
    credits INT UNSIGNED DEFAULT 0,
    profile_pic_url VARCHAR(50)
);


CREATE TABLE IF NOT EXISTS userskills (
    userid VARCHAR(20) REFERENCES users (id) ON DELETE CASCADE,
    skill VARCHAR(30) REFERENCES skills (skill) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS availability (
    userid VARCHAR(20) REFERENCES users (id) ON DELETE CASCADE,
    d DATE,
    starttime TIME NOT NULL,
    endtime TIME
);


CREATE TABLE IF NOT EXISTS recurringAvailability (
    userid VARCHAR(20) REFERENCES users (id) ON DELETE CASCADE,
    weekstartdate DATE NOT NULL,
    dayindex TINYINT UNSIGNED NOT NULL,
    starttime TIME NOT NULL,
    endtime TIME
)