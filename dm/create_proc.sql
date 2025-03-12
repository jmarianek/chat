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
   out p_id int) -- vystupni parametr
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


DELIMITER ;

call add_user('user8', '12345', 'user', @user_id);

select @user_id;
-- 16


