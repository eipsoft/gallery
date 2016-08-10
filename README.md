Создание таблиц
------------

Выполнить миграцию в консоли

```
php yii migrate/up --migrationPath=@app/modules/gallery/migrations
```

Добавление Rbac
------------
На основе [статьи](http://www.yiiframework.com/wiki/820/yii2-create-console-commands-inside-a-module-or-extension/)

```
php yii gallery/rbac/init
```