USE `chat`;
DROP procedure IF EXISTS `add_user`;

USE `chat`;
DROP procedure IF EXISTS `chat`.`add_user`;
;

DELIMITER $$
USE `chat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_user`(
   IN p_login varchar(20),
   IN p_passwd varchar(32),
   IN p_role varchar(10))
BEGIN
    -- TODO - kontrola, jestli p_role obsahuje
    -- jedno z admin/user
    if p_role <> 'user' and p_role <> 'admin' then
        signal SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Chybna role.';
    end if;
    insert into users(login, passwd, role)
    values(p_login, p_passwd, p_role);
END$$

DELIMITER ;
;

