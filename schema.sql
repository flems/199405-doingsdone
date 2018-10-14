CREATE DATABASE IF NOT EXISTS doingsdone
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email CHAR(128),
  password CHAR(255),
  name CHAR(128),
  show_completed BIT
);

CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_date DATE,
  name CHAR(255),
  file_name CHAR(255),
  file_url CHAR(255),
  user_id INT(5),
  project_id INT(5),
  execute_date DATE,
  ready BIT
);

CREATE TABLE projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  p_name CHAR(255),
  user_id INT(5)
);

CREATE INDEX p_name ON tasks(name);

CREATE UNIQUE INDEX email ON users(email);
