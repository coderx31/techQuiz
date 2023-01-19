# create tables

# users
CREATE TABLE `users` (
  `user_id` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

# questions
CREATE TABLE `questions` (
  `question_id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `votes` int(11) DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

# answers
CREATE TABLE `answers` (
  `answer_id` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `question_id` varchar(50) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `votes` int(11) NOT NULL DEFAULT 0,
  `updated` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# insert test data into db
INSERT INTO `users`(`user_id`, `firstname`, `lastname`, `username`, `email`, `password`) VALUES ('25614802-8592-11ed-a1eb-0242ac120002','Shenal','Fernando','coderx','shenal.fernando10@gmail.com','test-password')
INSERT INTO `questions`(`question_id`, `user_id`, `title`, `body`) VALUES ('d5359d7e-8591-11ed-a1eb-0242ac120002','25614802-8592-11ed-a1eb-0242ac120002','Test-Question 1','Test Body')
INSERT INTO `questions`(`question_id`, `user_id`, `title`, `body`) VALUES ('80f12084-8592-11ed-a1eb-0242ac120002','25614802-8592-11ed-a1eb-0242ac120002','Test-Question 2','Test Body')
INSERT INTO `questions`(`question_id`, `user_id`, `title`, `body`) VALUES ('c9b4fa8e-8592-11ed-a1eb-0242ac120002','25614802-8592-11ed-a1eb-0242ac120002','Test-Question 3','Test Body')
INSERT INTO `answers`(`answer_id`, `body`, `user_id`, `question_id`) VALUES ('f0b8bb72-8653-11ed-a1eb-0242ac120002','test answer body','25614802-8592-11ed-a1eb-0242ac120002','d5359d7e-8591-11ed-a1eb-0242ac120002')
INSERT INTO `answers`(`answer_id`, `body`, `user_id`, `question_id`) VALUES ('7b896d00-8654-11ed-a1eb-0242ac120002','test answer body 2','25614802-8592-11ed-a1eb-0242ac120002','d5359d7e-8591-11ed-a1eb-0242ac120002')
INSERT INTO `answers`(`answer_id`, `body`, `user_id`, `question_id`) VALUES ('9c3020d0-8654-11ed-a1eb-0242ac120002','test answer body 3','25614802-8592-11ed-a1eb-0242ac120002','d5359d7e-8591-11ed-a1eb-0242ac120002')