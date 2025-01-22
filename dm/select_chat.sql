use chat;

desc users;

-- vyber vsechny  uzivatele
SELECT * FROM users;

SELECT id, name, login FROM users;

-- uzivatele, kteri nemaji jmeno NULL
select * from users
where name is not null;

-- uzivatele, kteri maji jmeno NULL
select * from users
where name is null;

-- uzivatele, kteri maji jmeno NULL, nebo prazdny retezec
select * from users
where name is null or name = '';



select id, login, role
from users;

select * -- vsechny sloupce
from users
where role = 'user'; -- jen ty co maji roli user

-- vsichni bezni uzivatele jmenujici se Pavel
select login, name, role
from users
where 
    role = 'user'
    and name = 'Pavel';
    
-- uzivatele kteri se jmenuji Alena nebo Pavel
select login, name, role
from users
where 
    name = 'Alena' or name = 'Pavel';
    
-- uzivatele kteri se NEjmenuji Alena nebo Pavel
select login, name, role
from users
where 
    not(name = 'Alena' or name = 'Pavel');

-- uzivatele, kteri maji ve jmenu pismenko n
select * from users
where name like '%n%'; -- % zn. lib. retezec

-- uzivatele kteri zacinaji pismenkem P
select name as  jmeno from users -- as prejmenuje sloupec (jen pro dotaz)
where name like 'P%'; -- % zn. lib. retezec

-- in pro seznam
select * from users
where name in ('Pavel', 'Petr');

-- uzivatele s id 2..100
select * from users
where id between 4 and 100;

-- uzivatele zalozeni 21.11.2024 a pozdeji
select * from users
where created > '2024-11-21';

-- pocet uzivatelu
select count(id) from users;

update users set age = 20 where id = 1;
update users set age = 25 where id = 2;
update users set age = 30 where id = 3;
update users set age = 25 where id = 4;

-- suma veku vsech uzivatelu
select sum(age) from users;
-- 45

select upper(name) as upname, lower(surname) as losurname
from users;
-- JAN novak

-- formatovani datumu
select date_format(created, '%e.%m.%Y') from users;
-- 2024-11-20 -> 20.11.2024

-- vyber uzivatelu a jejich prispevku
select u.id, u.login, p.msg
from users u -- vse z users
left join posts p -- k tomu nalepeny prispevky
on u.id = p.users_id; -- vazba (pres klice)

-- v mezicase join vyse pridan do create_chat.sql jako view

select * from view_posts;


-- agregace podle users - kolik ma kdo prispevku (posts)
select u.id, u.login, count(u.login)
from users u -- vse z users
left join posts p -- k tomu nalepeny prispevky
on u.id = p.users_id -- vazba (pres klice)
group by u.login;

-- vysetreni narocnosti
explain select *
from users
where id = 1;


explain select *
from users
where name = 'Petr';

explain select *
from users
where surname = 'Novak';



