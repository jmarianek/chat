-- procedury pro chat
-- verze 2025-03-12

USE `chat`;
DROP procedure IF EXISTS `add_user`;


DELIMITER $$
USE `chat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_user`(
   IN p_login varchar(20),
   IN p_passwd varchar(32),
   IN p_role varchar(10),
   -- vystupni parametry
   out p_id int)
BEGIN
    -- TODO - kontrola, jestli p_role obsahuje
    -- jedno z admin/user
    if p_role <> 'user' and p_role <> 'admin' then
        signal SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Chybna role.';
    end if;
    insert into users(login, passwd, role)
    values(p_login, p_passwd, p_role);
    
    -- id posledniho vlozeneho zaznamu do out par. p_id
    select LAST_INSERT_ID() into p_id;
END$$


DELIMITER $$
-- funkce vracejici pocet uzivatelu
create function users_count()
returns int -- navratova hodnota
reads sql data -- jen cte data (NE modifikuje)
begin
    declare p_count int default null;
    select count(1) from users into p_count;
    return p_count;
end$$

delimiter ;

select users_count();

drop function if exists user_desc;

DELIMITER $$
-- TODO - popis uziv. ve tvaru "Jmeno Prijmeni, login (role)"
-- retezeni - funkce concat('a', 'b', ...)
create function user_desc(p_id int)
returns varchar(100)
reads sql data -- jen cte data (NE modifikuje)
begin
    declare p_name varchar(20);
    declare p_surname varchar(50);
    declare p_login varchar(20);
    declare p_role varchar(10);
    select IFNULL(name, ''), IFNULL(surname, ''),
        login, role into p_name, p_surname, p_login, p_role
        from users where id = p_id;
    return concat(p_name, ' ', p_surname, ', ', p_login, ' (', p_role, ')');
end$$

delimiter ;

select id, user_desc(id), login
from users;


-- !!! problem - funkce modifikuje selectu data v jeho prubehu
select id, change_passwd(id, 'ahoj'), passwd
from users
where passwd = '12345';




DELIMITER ;

call add_user('user8', '12345', 'user', @user_id);

select @user_id;
-- 16


