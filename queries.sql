INSERT INTO users
SET email = 'user1@test', password = '123', name = 'user1';

INSERT INTO users
SET email = 'user2@test', password = '123', name = 'user2';

INSERT INTO users
SET email = 'user3@test', password = '123', name = 'user3';

INSERT INTO projects
SET user_id = 1, name = 'Входящие';

INSERT INTO projects
SET user_id = 1, name = 'Учеба';

INSERT INTO projects
SET user_id = 2, name = 'Учеба';

INSERT INTO projects
SET user_id = 1, name = 'Работа';

INSERT INTO projects
SET user_id = 1, name = 'Домашние дела';

INSERT INTO projects
SET user_id = 1, name = 'Авто';

INSERT INTO tasks
SET user_id = 1, project_id = '3', name = 'Собеседование в IT компании', ready = 0, execute_date = date("2018-08-10");

INSERT INTO tasks
SET user_id = 1, project_id = '6', name = 'Выполнить тестовое задание', ready = 0, execute_date = date("2018-09-24");

INSERT INTO tasks
SET user_id = 2, project_id = '6', name = 'Выполнить тестовое задание', ready = 0, execute_date = date("2018-09-25");

INSERT INTO tasks
SET user_id = 1, project_id = '6', name = 'Сделать задание первого раздела', ready = 0;

INSERT INTO tasks
SET user_id = 1, project_id = '1', name = 'Встреча с другом', ready = 0, execute_date = date("2018-09-30");

INSERT INTO tasks
SET user_id = 1, project_id = '4', name = 'Купить корм для кота', ready = 0;

INSERT INTO tasks
SET user_id = 1, project_id = '4', name = 'Заказать пиццу', ready = 0, execute_date = CURDATE();

-- получить список из всех проектов для одного пользователя;
SELECT * FROM projects
WHERE user_id = 1;

-- получить список из всех задач для одного проекта;
SELECT * FROM tasks
WHERE project_id = 6;

-- пометить задачу как выполненную;
UPDATE tasks SET ready = 1
WHERE name = 'Собеседование в IT компании';

-- получить все задачи для завтрашнего дня;
SELECT * FROM tasks
WHERE execute_date = NOW() + INTERVAL 1 DAY;

-- обновить название задачи по её идентификатору.
UPDATE tasks SET name = "Заказатть пиццу с грибами"
WHERE id = 7;
