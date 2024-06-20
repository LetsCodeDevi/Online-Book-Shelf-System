-- SQLite

insert into users(Name, Username, Email, Contact, Password) values ('Devi', 'dev123', 'devi@gmail.com','212344','devi@123');

create table customers (id INTEGER PRIMARY KEY AUTOINCREMENT, Name varchar(255) NOT NULL,
    email varchar(255),
    Age int);
insert into customers(Name, email, Age) values ('Devi', 'devi@gmail.com',21);
select * from customers;

select * from users;

CREATE TABLE users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        Name TEXT NOT NULL,
        Username TEXT NOT NULL,
        Email varchar(255) NOT NULL,
        Contact VARCHAR(255) NOT NULL,
        Password TEXT NOT NULL);

