USE yeticave;

-- Существующий список категорий
INSERT INTO
	`category` (name)
VALUES
	('Доски и лыжи'),
	('Крепления'),
	('Ботинки'),
	('Одежда'),
	('Инструменты'),
	('Разное');

-- Существующий список пользователей
INSERT INTO
	`user` (email, name, password_hash, avatar, contacts)
VALUES
	('ignat.v@gmail.com', 'Игнат Владимиров', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', 'img/avatar.jpg', 'тел. 111111'),
	('kitty_93@li.ru', 'Китти Петрова', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', 'img/avatar.jpg', 'тел. 222222'),
	('warrior07@mail.ru', 'Ворриор Сидоров', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', 'img/avatar.jpg', 'тел. 333333');

-- Список объявлений
INSERT INTO
	`lot` (title, category, cost, image, description, step, end_date, favorite, author)
VALUES
	('2014 Rossignol District Snowboard',
	'1',
	'10999',
	'img/lot-1.jpg',
	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean gravida tempor augue, sed laoreet velit gravida nec. Fusce nibh lorem, tempor nec diam non, sollicitudin tincidunt neque. Mauris et purus viverra, accumsan dolor vel, cursus dolor. Quisque sollicitudin, leo non ullamcorper blandit, magna magna mollis eros, nec sollicitudin lacus dui.',
	'10000',
	'2017.09.30',
	2,
	1),
	('DC Ply Mens 2016/2017 Snowboard',
	'1',
	'159999',
	'img/lot-2.jpg',
	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean gravida tempor augue, sed laoreet velit gravida nec. Fusce nibh lorem, tempor nec diam non, sollicitudin tincidunt neque. Mauris et purus viverra, accumsan dolor vel, cursus dolor. Quisque sollicitudin, leo non ullamcorper blandit, magna magna mollis eros, nec sollicitudin lacus dui.',
	'14000',
	'2017.09.30',
	2,
	1),
	('Крепления Union Contact Pro 2015 года размер L/XL',
	 '2',
	 '8000',
	 'img/lot-3.jpg',
	 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean gravida tempor augue, sed laoreet velit gravida nec. Fusce nibh lorem, tempor nec diam non, sollicitudin tincidunt neque. Mauris et purus viverra, accumsan dolor vel, cursus dolor. Quisque sollicitudin, leo non ullamcorper blandit, magna magna mollis eros, nec sollicitudin lacus dui.',
	 '600',
	 '2017.09.30',
	 3,
	 2),
	('Ботинки для сноуборда DC Mutiny Charocal',
	 '3',
	 '10999',
	 'img/lot-4.jpg',
	 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean gravida tempor augue, sed laoreet velit gravida nec. Fusce nibh lorem, tempor nec diam non, sollicitudin tincidunt neque. Mauris et purus viverra, accumsan dolor vel, cursus dolor. Quisque sollicitudin, leo non ullamcorper blandit, magna magna mollis eros, nec sollicitudin lacus dui.',
	 '900',
	 '2017.09.30',
	 1,
	 2),
	('Куртка для сноуборда DC Mutiny Charocal',
	 '4',
	 '7500',
	 'img/lot-5.jpg',
	 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean gravida tempor augue, sed laoreet velit gravida nec. Fusce nibh lorem, tempor nec diam non, sollicitudin tincidunt neque. Mauris et purus viverra, accumsan dolor vel, cursus dolor. Quisque sollicitudin, leo non ullamcorper blandit, magna magna mollis eros, nec sollicitudin lacus dui.',
	 '600',
	 '2017.09.30',
	 4,
	 6),
	('Маска Oakley Canopy',
	 '6',
	 '5400',
	 'img/lot-6.jpg',
	 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean gravida tempor augue, sed laoreet velit gravida nec. Fusce nibh lorem, tempor nec diam non, sollicitudin tincidunt neque. Mauris et purus viverra, accumsan dolor vel, cursus dolor. Quisque sollicitudin, leo non ullamcorper blandit, magna magna mollis eros, nec sollicitudin lacus dui.',
	 '500',
	 '2017.09.30',
	 2,
	 1);

INSERT INTO
	`bet` (price, lot, author)
VALUES
	('11500', '6', '1'),
	('11000', '6', '2');

-- получить список из всех категорий;
SELECT *
FROM `category`;

-- получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, количество ставок, название категории;
SELECT lot.id, lot.title, lot.cost, lot.image, bets.max_bet, bets.bet_count, lot.category
FROM `lot`
LEFT JOIN (
		SELECT
			`lot`, MAX(`price`) as `max_bet`, COUNT(`id`) as `bet_count`
		FROM
			`bet`
		GROUP BY `lot`
		) as `bets`
	ON
		bets.lot = lot.id
WHERE
	`end_date` >  NOW()
LIMIT
	6;


-- найти лот по его названию или описанию;
SELECT
	*
FROM
	`lot`
WHERE
	`title` LIKE '%сноуборд%'
OR
	`description` LIKE '%сноуборд%';

-- обновить название лота по его идентификатору;
UPDATE
	`lot`
SET
	`title` = '2017 Rossignol District Snowboard'
WHERE
	`id` = 1;

-- получить список самых свежих ставок для лота по его идентификатору;
SELECT
	*
FROM
	`bet`
WHERE
	`lot` = 6
ORDER BY
	`created_time` DESC
LIMIT 2;
