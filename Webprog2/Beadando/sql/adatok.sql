CREATE TABLE `comicbooks`(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `writer` VARCHAR(255) NOT NULL,
    `illustrator` VARCHAR(255) NOT NULL,
    `year` INT NOT NULL,
    `cover` VARCHAR(255) NULL,
    `desc` TEXT NOT NULL,
    `userId` INT NOT NULL
);

CREATE TABLE `users` (
    `userId` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL UNIQUE,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `fullname` VARCHAR(255) NOT NULL,
    `birth_date` DATE NOT NULL,
    `registration_date` DATE,
    `password` TEXT NOT NULL,
    `profile_pic` TEXT
);