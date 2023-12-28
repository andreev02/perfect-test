<p align="center"><a href="https://i.imgur.com/YLqPT0A.png" target="_blank"><img src="https://i.imgur.com/YLqPT0A.png" width="800" alt="Laravel Logo"></a></p>

## Description
Это тестовое задание для <b>Perfect Panel, Севастополь</b>

Вы можете отправить запросы сюда: <a href="http://app.itandreev.ru/api/v1">http://app.itandreev.ru/api/v1</a> (Bearer token: default)

## SQL Task
Необходимо написать запрос выборки данных из представленных таблиц,
который найдет и выведет всех посетителей библиотеки, возраст которых
попадает в диапазон от 7 и до 17 лет, которые взяли две книги одного автора
(взяли всего 2 книги и они одного автора), книги были у них в руках не более
двух календарных недель (не просрочили 2-х недельный срок пользования).

<b>Формат вывода:</b><br>
ID, Name (first_name last_name), Author, Books (Book 1, Book 2, ...)<br>
1; Ivan Ivanov; Leo Tolstoy; Book 1, Book 2

```
SELECT
	CONCAT(users.id, '; ', users.first_name, ' ', users.last_name, '; ', GROUP_CONCAT(books.name SEPARATOR ', ')) result
FROM users
JOIN user_books ON users.id = user_books.user_id
JOIN books ON books.id = user_books.book_id
WHERE TIMESTAMPDIFF(YEAR, users.birthday, CURRENT_DATE) BETWEEN 7 AND 17
AND TIMESTAMPDIFF(DAY, user_books.get_date, user_books.return_date) < 14
GROUP BY users.id
HAVING COUNT(books.id) = 2 AND COUNT(DISTINCT books.author) = 1;
```

## RESTful API Task
Необходимо реализовать JSON API сервис на языке php 8 (можно использовать
любой php framework) для работы с курсами обмена валют для биткоина (BTC).
Реализовать необходимо с помощью Docker.

Все методы API будут доступны только после авторизации, т.е. все методы должны
быть по умолчанию не доступны и отдавать ошибку авторизации.
Для авторизации будет использоваться фиксированный токен (64 символа
включающих в себя a-z A-Z 0-9 а так-же символы - и _ ), передавать его будем в
заголовках запросов. Тип Authorization: Bearer.

<b>Формат запросов:</b><br>
<your_domain>/api/v1?method=<method_name>&<parameter>=<value><br>
Формат ответа API: JSON (все ответы при любых сценариях должны иметь JSON
формат)

Все значения курса обмена должны считаться учитывая нашу комиссию = 2%

### * Installation
```
git clone https://github.com/andreev02/perfect-test.git
cd perfect-test

composer install
php artisan key:generate
```
Добавим api токен в <b>.env</b> (по умолчанию: <b>default<b>)
```
API_TOKEN=<your token>
```
Docker:
```
docker compose up -d
```
Или внешне:
```
php artisan serve
```
### * Tests
```
php artisan test Tests\Feature\ApiTest.php
```
