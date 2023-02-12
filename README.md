## Event dispatcher

![Package version](https://img.shields.io/github/v/release/motokraft/event)
![Total Downloads](https://img.shields.io/packagist/dt/motokraft/event)
![PHP Version](https://img.shields.io/packagist/php-v/motokraft/event)
![Repository Size](https://img.shields.io/github/repo-size/motokraft/event)
![License](https://img.shields.io/packagist/l/motokraft/event)

## Установка

Библиотека устанавливается с помощью пакетного менеджера [**Composer**](https://getcomposer.org/)

Добавьте библиотеку в файл `composer.json` вашего проекта:

```json
{
    "require": {
        "motokraft/event": "^1.0"
    }
}
```

или выполните команду в терминале

```
$ php composer require motokraft/event
```

Включите автозагрузчик Composer в код проекта:

```php
require __DIR__ . '/vendor/autoload.php';
```

## Пример использования

```php
use \Motokraft\Event\EventHelper;
use \Motokraft\Event\EventMethod;
use \Motokraft\Event\ObjectEvent;
use \Motokraft\Event\EventInterface;
use \Motokraft\Event\EventTypeInterface;
use \Motokraft\Event\Traits\EventTrait;
use \Motokraft\Object\BaseObject;

class UserObject extends BaseObject implements EventTypeInterface
{
    use EventTrait;

    private int $id = 0;
    private string $name = 'admin';
}

EventHelper::addTypeClass('user', UserObject::class);

class DemoEvent implements EventInterface
{
    function onPrepareUserObject(ObjectEvent $event) : void
    {
        $target = $event->getTarget();
        $target->set('login', 'SuperUser');
    }
}

UserObject::addEventMethod('prepare', new EventMethod(
	DemoEvent::class, 'onPrepareUserObject', 1
));

$user = new UserObject;

$event = $user->getObjectEvent('prepare');
$user->dispatchEvent($event);

print_R($user);
```

## Лицензия

Эта библиотека находится под лицензией MIT License.