CREATE TABLE IF NOT EXISTS webshop.UserRole (
	ur_id INT UNSIGNED AUTO_INCREMENT,
	ur_name VARCHAR(64) NOT NULL,
	CONSTRAINT userrole_pk PRIMARY KEY(ur_id)
);

CREATE TABLE IF NOT EXISTS webshop.User (
	user_id INT UNSIGNED AUTO_INCREMENT,
	ur_id INT UNSIGNED DEFAULT 1,
	user_displayname VARCHAR(64) NOT NULL,
	user_firstname VARCHAR(64) NOT NULL,
	user_lastname VARCHAR(64) NOT NULL,
	user_email VARCHAR(255) NOT NULL,
	user_lastlogin DATETIME,
	user_dateofbirth DATETIME NOT NULL,
	user_passwordhash VARCHAR(255) NOT NULL,
	user_active BOOLEAN DEFAULT 1,
	CONSTRAINT user_pk PRIMARY KEY(user_id),
	FOREIGN KEY (ur_id) REFERENCES UserRole(ur_id)
);

CREATE TABLE IF NOT EXISTS webshop.Category (
	category_id INT UNSIGNED AUTO_INCREMENT,
	category_name varchar(255) NOT NULL,
	category_description TEXT,
	CONSTRAINT category_pk PRIMARY KEY(category_id)
);

CREATE TABLE IF NOT EXISTS webshop.Product (
	product_id INT UNSIGNED AUTO_INCREMENT,
	category_id INT UNSIGNED NOT NULL,
	product_name VARCHAR(64) NOT NULL,
	product_description text,
	product_available DATETIME,
	product_stock INT NOT NULL,
	product_unitprice DOUBLE(8,2) NOT NULL,
	CONSTRAINT product_pk PRIMARY KEY(product_id),
	FOREIGN KEY (category_id) REFERENCES Category(category_id)
);

CREATE TABLE IF NOT EXISTS webshop.ProductPicture (
	pp_id INT UNSIGNED AUTO_INCREMENT,
	product_id INT UNSIGNED NOT NULL,
	pp_path varchar(255) NOT NULL,
	CONSTRAINT productpicture_pk PRIMARY KEY(pp_id),
	FOREIGN KEY (product_id) REFERENCES Product(product_id)
);

CREATE TABLE IF NOT EXISTS webshop.UserOrder (
	uo_id INT UNSIGNED AUTO_INCREMENT,
	user_id INT UNSIGNED NOT NULL,
	uo_basket BOOLEAN DEFAULT 1,
	uo_date DATETIME,
	uo_payedat DATETIME,
	CONSTRAINT userorder_pk PRIMARY KEY(uo_id),
	FOREIGN KEY (user_id) REFERENCES User(user_id)
);

CREATE TABLE IF NOT EXISTS webshop.Orders (
	order_id INT UNSIGNED AUTO_INCREMENT,
	uo_id INT UNSIGNED NOT NULL,
	product_id INT UNSIGNED NOT NULL,
	amount INT NOT NULL,
	CONSTRAINT order_pk PRIMARY KEY(order_id),
	FOREIGN KEY (uo_id) REFERENCES UserOrder(uo_id),
	FOREIGN KEY (product_id) REFERENCES Product(product_id)
);
