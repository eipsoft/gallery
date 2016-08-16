#Документация по модулю gallery

##Пример установки модуля на basic yii приложение

###[Установка](https://github.com/yiisoft/yii2/blob/master/docs/guide-ru/start-installation.md) basic yii приложения

Выполняем в консоли

```
composer global require "fxp/composer-asset-plugin:^1.2.0"
composer create-project --prefer-dist yiisoft/yii2-app-basic basic
```

###Скачивание модуля

###1 вариант

Переходим в basic папку и вызываем

```
git clone --depth=1 --branch=master git@github.com:eipsoft/blog.git modules/blog
rm -rf !$/.git
```
###2 вариант

Скачиваем архив с гитхаба и вручную заливаем в папку modules/blog

------------

##Создание таблиц

Выполнить миграцию в консоли

```
php yii migrate/up --migrationPath=@app/modules/gallery/migrations
```

##Добавление Rbac

На основе [статьи](http://www.yiiframework.com/wiki/820/yii2-create-console-commands-inside-a-module-or-extension/)

```
php yii gallery/rbac/init
```