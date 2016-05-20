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

INSERT INTO employees (name,email,password) VALUES ('Admin','admin@admin.admin','202cb962ac59075b964b07152d234b70');

/* 202cb962ac59075b964b07152d234b70 */