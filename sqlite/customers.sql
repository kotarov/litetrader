
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
    id integer primary key, 
    name text, 
    family text, 
    ein text,
    email text, 
    password text, 
    onelogin_pass text, 
    onelogin_time integer, 
    phone text, 
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


DROP TABLE IF EXISTS `customers_companies`;
CREATE TABLE `customers_companies` (
    id_customer integer,
    id_company integer,
    positin text
); 

DROP TABLE IF EXISTS `customers_products`;
CREATE TABLE `customers_products` (
    id integer primary key,
    id_customer integer,
    id_product integer,
    note text,
    id_unit integer,
    qty     real,
    price   real,
    date_add integer,
    is_closed integer
);



DROP TABLE IF EXISTS order_statuses;
CREATE TABLE order_statuses (
    id integer primary key,
    is_default integer,
    name text,
    icon text,
    is_closed integer
);

DROP TABLE IF EXISTS orders;
CREATE TABLE orders (
    id integer primary key,
    id_status integer,
    date_add integer,
    date_delivery integer,
    id_customer integer,
    id_company integer,
    customer text,
    company text,
    mrp text,
    ein text,
    phone text,
    email text,
    country text,
    city text,
    address text,
    price real,
    is_active integer,
    id_method integer,
    method text,
);


DROP TABLE IF EXISTS orders_products;
CREATE TABLE orders_products (
    id integer primary key,
    id_order integer,
    id_product integer,
    product text,
    note text,
    id_unit integer,
    unit text,
    qty real,
    price real,
    date_add integer,
    is_closed integer
);

DROP TABLE IF EXISTS orders_statuses;
CREATE TABLE orders_statuses (
    id integer primary key,
    id_order integer,
    id_status integer,
    status text,
    user text,
    date_add integer
);

