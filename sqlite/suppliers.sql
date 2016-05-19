/*
DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers` (
    id integer primary key, 
    name text,
    family text,
    password text,
    phone text,
    email text,
    country text,
    city text,
    address text,
    date_add integer,
    date_logged integer,
    is_active integer
); 


DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
    id integer primary key, 
    name text,
    mrp text,
    ein text,
    email text,
    phone text,
    country text,
    city text,
    address text
); 

DROP TABLE IF EXISTS `suppliers_companies`;
CREATE TABLE `suppliers_companies` (
    id_supplier integer,
    id_company integer,
    position text
); 
*/
DROP TABLE IF EXISTS `suppliers_products`;
CREATE TABLE `suppliers_products` (
    id integer primary key,
    id_supplier integer,
    id_company integer,
    id_product integer,
    id_unit integer,
    qty     real,
    price   real,
    date_add integer,
    is_closed integer
);