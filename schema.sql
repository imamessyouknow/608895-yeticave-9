create database YetiCave
default character set utf8
default collate utf8_general_ci;

use YetiCave;

create table categories (
cat_name nvarchar(30),
symbol_code nvarchar(30),
cat_id int auto_increment primary key);

create table lot (
date_create timestamp,
lot_name nvarchar(200),
lot_description nvarchar(4000),
lot_img nvarchar(4000),
start_price int,
date_end timestamp,
lot_rate_step decimal,
lot_id int auto_increment primary key);

alter table lot
add column 
	(autor_id int not null,
	winner_id int,
    category_id int not null);    

create table rate (
rate_date timestamp,
suplied_price int,
user_id int,
lot_id int,
rate_id int auto_increment primary key);

create table user_description (
registration_date timestamp,
email nvarchar(200) unique,
user_name nvarchar(40) unique,
user_password nvarchar(50),
user_avatar nvarchar(4000),
contact_inf nvarchar(4000),
user_id int auto_increment primary key,
created_lot_id int,
created_rate_id int);

insert into categories 
(cat_name, symbol_code) values 
('Доски и лыжи','boards'), 
('Крепления','attachment'), 
('Ботинки', 'boots'), 
('Одежда', 'clothing'), 
('Инструменты','tools'), 
('Разное','other');

create index cat_int on lot(category_id);
create index w_int on lot(winner_id);
create index aut_int on lot(autor_id);
create index u_int on rate(user_id);
create index l_int on rate(lot_id);
create index crl_int on user_description(created_lot_id);
create index crra_int on user_description(created_rate_id);