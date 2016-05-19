DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
    id integer primary key, 
    name text, 
    family text, 
    email text, 
    password text, 
    phone text, 
    address text, 
    date_add integer,
    date_logged integer
);