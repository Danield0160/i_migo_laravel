-- Active: 1684178721942@@127.0.0.1@3306
create DATABASE imigo;

CREATE USER 'lv_imigo'@'localhost' IDENTIFIED BY 'Csas1234';
GRANT ALL PRIVILEGES ON *.* TO 'lv_imigo'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;

