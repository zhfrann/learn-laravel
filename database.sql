CREATE DATABASE belajar_laravel_database;

CREATE TABLE categories(
    id VARCHAR(100) NOT NULL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP
) engine innodb;
