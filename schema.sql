CREATE DATABASE IF NOT EXISTS doingsdone
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email CHAR(128),
  password CHAR(64),
  name CHAR(128)
);

CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT(5),
  project_id INT(5),
  name CHAR(255),
  execute_date DATE,
  ready BIT
);

CREATE TABLE projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(255),
  user_id INT(5)
);

CREATE INDEX p_name ON tasks(name);

CREATE UNIQUE INDEX email ON users(email);
