insert into categories 
(name, symbol_code) values 
('Доски и лыжи','boards'), 
('Крепления','attachment'), 
('Ботинки', 'boots'), 
('Одежда', 'clothing'), 
('Инструменты','tools'), 
('Разное','other');

insert into user 
(registration_date, email, name, password, phone, address, about_me) values
(now(),'vasya@mail.ru','Василий', 'пятьпятерок', '79161234567', 'улица ленина дом 69', 'коммунист'),
(now(),'putya@kremlin.ru','Володя', 'кабаеванорм', '1', 'рядом с метро', 'коммунист-пацифист');

insert into lot 
(date_create, name, description, img, start_price, rate_step, author_id, category_id) values
(now(), '2014 Rossignol District Snowboard', 'описание...','img/lot-1.jpg', 10999, 0.1, 2, 1),
(now(), 'DC Ply Mens 2016/2017 Snowboard', 'описание...','img/lot-2.jpg', 159999, 0.1, 3, 1),
(now(), 'Крепления Union Contact Pro 2015 года размер L/XL', 'описание...','img/lot-3.jpg', 8000, 0.2, 2, 2),
(now(), 'Ботинки для сноуборда DC Mutiny Charocal', 'описание...','img/lot-4.jpg', 10999, 0.1, 3, 3),
(now(), 'Куртка для сноуборда DC Mutiny Charocal', 'описание...','img/lot-5.jpg', 7500, 0.15, 3, 4),
(now(), 'Маска Oakley Canopy', 'описание...','img/lot-6.jpg', 5400, 0.25, 2, 6);

insert into rate 
(create_at, suplied_price, user_id, lot_id) values
(now(), 12000, 3, 3),
(now(), 8000, 2, 4);

select name from categories;

select l.name, start_price, date_create, img, current_price, c.name
from lot l join categories c on l.category_id = c.id
where date_create >= adddate(now(), interval - 5 day);

select l.name, start_price, date_create, img, current_price, c.name
from lot l join categories c on l.category_id = c.id
where l.id = 2;

update lot set name = 'newname'
where id = 2;

select l.name, create_at, suplied_price, u.name
from rate 
join lot l on rate.lot_id = l.id
join user u on rate.user_id = u.id 
where create_at >= adddate(now(), interval - 1 day) and lot_id = 2;