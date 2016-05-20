DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
    id integer primary key,
    name text,
    reference text,
    description text,
    tags text,
    details text,
    id_unit integer,
    qty real,
    price real,
    id_category integer,
    id_supplier integer,
    date_add integer,
    is_visible integer,
    is_avaible integer,
    is_adv integer,
    url_rewrite text
);

DROP TABLE IF EXISTS units;
CREATE TABLE units (
    id integer primary key,
    name text,
    abbreviation text,
    position integer,
    is_default integer
);
INSERT INTO units (is_default,abbreviation,name,position) VALUES 
    (1,   'nb','Number',    1), 
    (null,'kg','Kilogram',  1), 
    (null,'gr','Gram',      1), 
    (null,'m' ,'Meter',     1), 
    (null,'cm','Cantimeter',1),
    (null,'km','Kilometer', 1), 
    (null,'m2','Square meter',1), 
    (null,'m3','Cubic meter',1);


DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
    id integer primary key,
    id_parent integer,
    name text,
    description text,
    tags text,
    pos integer,
    is_visible integer,
    
    depth integer,
    depth_html text,
    parents text,
    children text,
    url_rewrite text,
    list_order integer
);


DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
    id integer primary key, 
    id_product integer,
    name text,
    `type` text,
    size text,
    is_cover integer,
    date_add integer,
    full blob,
    thumb blob,
    small blob
); 