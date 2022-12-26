# create tables

# users
CREATE TABLE users (
    user_id varchar(50) NOT NULL,
    firstname varchar(50) NOT NULL,
    lastname varchar(50) NOT NULL,
    username varchar(50) UNIQUE NOT NULL,
    email varchar(50) UNIQUE NOT NULL,
    password varchar(255) NOT NULL,
    PRIMARY KEY (user_id)
);

# questions
CREATE TABLE questions (
    question_id varchar(50) NOT NULL,
    user_id varchar(50) NOT NULL,
    title varchar(255) NOT NULL,
    body Text NOT NULL,
    votes Int DEFAULT 0,
    createdAt Timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updatedAt Timestamp,
    updated Int DEFAULT 0,
    PRIMARY KEY (question_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

# answers
CREATE TABLE answers (
	answer_id varchar(50) NOT NULL,
    body Text NOT NULL,
    user_id varchar(50) NOT NULL,
    question_id varchar(50) NOT NULL,
    createdAt Timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updatedAt Timestamp,
    updated Int DEFAULT 0,
    PRIMARY KEY (answer_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (question_id) REFERENCES questions(question_id)
);

