create database YetiCave
default character set utf8
default collate utf8_general_ci;

use YetiCave;

create table categories (
id int auto_increment primary key,
name char(255) not null,
symbol_code char(255) not null);

create table rate (
id int auto_increment primary key,
create_at timestamp not null,
suplied_price int not null,
user_id int not null,
lot_id int not null,
foreign key (user_id) references user(id),
foreign key (lot_id) references lot(id));

create table user (
id int auto_increment primary key,
registration_date timestamp not null,
email char(255) unique not null,
name char(255) unique not null,
password char(255) not null,
avatar text null,
phone varchar(20) unique not null,
address text null,
about_me text null);

create table lot (
id int auto_increment primary key,
date_create timestamp not null,
name char(255) not null,
description text,
img text,
start_price int,
date_end timestamp null,
rate_step decimal,
author_id int not null,
winner_id int null,
category_id int not null,
foreign key (author_id) references user(id),
foreign key (winner_id) references user(id),
foreign key (category_id) references categories(id));  

insert into categories 
(name, symbol_code) values 
('Доски и лыжи','boards'), 
('Крепления','attachment'), 
('Ботинки', 'boots'), 
('Одежда', 'clothing'), 
('Инструменты','tools'), 
('Разное','other');

create index categor_ind on lot(category_id);
create index winner_ind on lot(winner_id);
create index author_ind on lot(author_id);
create index user_ind on rate(user_id);
create index lot_ind on rate(lot_id);
create index categor_prim_ind on categories(id);
create index lot_prim_ind on lot(id);
create index rate_prim_ind on rate(id);
create index user_prim_ind on user(id);
