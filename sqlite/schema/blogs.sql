DROP TABLE IF EXISTS blogs;
CREATE TABLE blogs (
    id integer primary key, 
    title text,
    subtitle text,
    id_category integer,
    tags text,
    id_author integer,
    author text,
    `date` integer,
    date_add integer,
    content text,
    image blob,
    is_active integer,
    is_new integer,
    url_rewrite text
);

DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
    id integer primary key,
    id_parent integer,
    title text,
    subtitle text,
    tags text,
    image blob,
    is_visible integer,
    position integer,
    
    depth integer,
    depth_html text,
    parents text,
    children text,
    url_rewrite text,
    list_order integer
);

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
    id integer primary key,
    id_author integer,
    author text,
    date_add integer,
    content text,
    is_active integer,
    is_new integer
);