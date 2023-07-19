Бот сервис для отслеживания статуса песочек на основе карточек задач в Кайтоне.

После запуска контейнеров необходимо в контейнере php_sbs создать БД и накатить миграции

````
php bin/console doctrine:database:create --if-not-exists
````

````
php bin/console doctrine:migrations:migrate
````

Урлы для проверки получаемых данных от кайтона 
(слаги: optimize, improvement, content, interest, expansion, engineer)

````
{host:port}/free/{team_slug}
{host:port}/taken/{team_slug}
````

Урл для проверки работы

````
{host:port}/health
````