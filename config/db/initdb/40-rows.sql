COMMIT;

USE webshop;

INSERT INTO UserRole (`ur_id`, `ur_name`) VALUES
(1, 'client'),
(2, 'admin');

/* admin@localhost.local:toor123 */
INSERT INTO `User` (`user_id`, `ur_id`, `user_displayname`, `user_firstname`, `user_lastname`, `user_email`, `user_lastlogin`, `user_dateofbirth`, `user_passwordhash`, `user_active`) VALUES (1, 2, 'admin', 'super', 'admin', 'admin@localhost.local', '2021-12-26 15:11:46', '1970-01-01 00:00:00', '$2y$10$IhiaLBIisoiJmVgun8oa5OK3YD2Z95GULpRMs9hEUild1xnU1ZYTu', 1);

INSERT INTO `Category` (`category_id`, `category_name`, `category_description`) VALUES
(1, 'Not bricks', 'No idea what this is doing here'),
(2, 'Special bricks', 'Not so ordinary bricks'),
(3, 'Child bricks', 'For children, DO NOT EAT'),
(4, 'Normal bricks', 'Just plain old normal bricks');


INSERT INTO `Product` (`product_id`, `category_id`, `product_name`, `product_description`, `product_available`, `product_stock`, `product_unitprice`) VALUES
(1, 4, 'Burnt Clay Bricks', 'Burned in the furnaces of hell!', '1970-01-01 00:00:00', 1000, 5.00),
(2, 4, 'Engineering Bricks', 'Playdough bricks I guess', '1970-01-01 00:00:00', 999, 2.00),
(3, 4, 'Fly Ash Bricks', 'Fly ash brick (FAB) is a building material, specifically masonry units, containing class C or class F fly ash ... - Wikipedia', '1970-01-01 00:00:00', 3987, 3.00),
(4, 2, 'Fish Ash Bricks', 'Same as Fly Ash Bricks except these swim', '1970-01-01 00:00:00', 398, 4.00),
(5, 4, 'Firebricks', 'A fire brick, firebrick, or refractory is a block of ceramic material used in lining furnaces, kilns, fireboxes, and fireplaces. ... -Wikipedia', '1970-01-01 00:00:00', 5784, 5.00),
(6, 2, 'Water Bricks', 'Wikipedia does not have an article with this exact name. Please search for Water brick in Wikipedia to check for alternative titles or spellings. - Wikipedia', '1970-01-01 00:00:00', 575, 6.00),
(7, 2, 'Nokia Bricks', 'Strong phone', '1970-01-01 00:00:00', 1, 1.00),
(8, 4, 'Extruded bricks', 'A versatile modern brick look that excels in highly varied applications.', '1970-01-01 00:00:00', 2384, 1.20),
(9, 2, 'Intruded Bricks ', 'Opposite of an extruded brick', '1970-01-01 00:00:00', 2384, 1.30),
(10, 2, 'Extroverted Bricks', 'They talk way to much', '1970-01-01 00:00:00', 5643, 4.70),
(11, 2, 'Introverted Bricks', '', '2999-01-01 00:00:00', 42, 4.20),
(12, 2, 'Holy Bricks', 'zeven maal zeventig maal', '2999-01-01 00:00:00', 7, 70.00),
(13, 2, 'Christmas Bricks', 'They have way to many songs about them', '1970-01-01 00:00:00', 25, 12.00),
(14, 1, 'A shoe', 'Someone must have lost it', '1970-01-01 00:00:00', 1, 1.00),
(15, 3, 'Lego Bricks', 'For children (and adults)', '1970-01-01 00:00:00', 9999, 0.40),
(16, 3, 'Unholy Bricks', 'idk something funny', '1970-01-01 00:00:00', 777, 777.00),
(17, 3, 'Large lego bricks', 'duplo', '1970-01-01 00:00:00', 120, 2.00);

COMMIT;
