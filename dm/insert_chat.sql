use chat;

select * from users;
-- id 1 admin
-- id 4 Jan Novak

-- automaticke potvrzovani transakci - vychozi chovani
set autocommit=1;


-- naplnime uzivatele
INSERT INTO users (passwd, login, role)
VALUES ('12345', 'admin', 'admin');

-- update uziv. majicich heslo '12345'
-- na heslo md5('12345')
update users
set passwd = md5('12345')
where passwd = '12345'
    and id > 0;



INSERT INTO users (name, surname, passwd, login, role)
VALUES ('Jan', 'Novak', '12345', 'jnovak', 'user');


INSERT INTO users (name, surname, passwd, login, role)
VALUES ('Alena', 'Vesela', md5('12345'), 'avesela', 'user');


-- zmenime Jan Novak na Petr Novak a heslo na 45678
UPDATE users 
SET name = 'Petr', passwd = '45678'
WHERE id = 3; -- !!!! bez podminky zmeni vsechny zaznamy!!!

-- smazani  uzivatele
DELETE FROM users
WHERE id = 3; -- !!!! bez podminky zmeni vsechny zaznamy!!!


-- naplnime mistnosti
insert into rooms(name, public, descr)
values('room1', 'Y', 'Místnost pro všechny');

-- vypneme automaticke potvrzovani transakci
set autocommit=0;

insert into rooms(name, public, descr)
values('room2', 'N', 'Místnost 2');

rollback; -- odvolavam posl. transakci (insert room2)
commit; -- potvrdim explicitne posl. transakci

select * from rooms;
-- id 1 room1
-- id 2 room2

-- prispevek Jana (users.id 4) do mistnosti room1 (rooms.id 1)
insert into posts(msg, rooms_id, users_id)
values('Zprava od Jan', 1, 4);

insert into posts(msg, rooms_id, users_id)
values('Dalsi zprava od Jan', 1, 4);





