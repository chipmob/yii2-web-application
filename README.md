# <p align="center">Yii 2 Web Application</p>

Структура проекта
-----------------

```
app
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains app-specific model classes
    runtime/             contains files generated during runtime
    themes/              contains themes for the Web application
    web/                 contains the entry script and Web resources
common
    components/          contains application components
    config/              contains shared configurations
    mail/                contains view files for e-mails
    messages/            contains translate files
    models/              contains model classes
    modules/             contains application modules
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    fixtures/            contains model fixtures
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
environments/            contains environment-based overrides
vendor/                  contains dependent 3rd-party packages
```

Разворачивание проекта
----------------------

1. Инициализация окружения `php init --env=Development --overwrite=All`
2. Миграции `php yii migrate/up --interactive=0`
3. Фикстуры `php yii fixture/load "*" --interactive=0`
4. Роли и разрешения `php yii rbac/init`
5. Пользователь `php yii user/create root@web.loc root root`
6. Подтвердить пользователя `php yii user/confirm root`
7. Права пользователя `php yii rbac/assign root root`

Страницы проекта
----------------

1. [Web Application](https://localhost)
2. [MailCatcher](http://localhost:1080)
