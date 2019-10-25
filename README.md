# Функции и классы помощники для проекта RestAPI

#### Внимание начиная с версии 2.x "глобальная" функция коллекции "collect" была перемеинована в "pcollect"

## Требуется
    - Phalcon > 3.0.0
    - RestAPI

## Коллекции

Коллекции принимают как параметр массив.

###### Cоздание


Есть два способа создания коллекции
1. Через helper pсollect, пример:
```php
$collection = pcollect([1, 2 , 3, 4]);
return $collection->first(); //1
```
2. Через класс
```php
use Chocofamily\Collection\Collection;
$collection = new Collection([1,2,3,4]);
return $collection->last();//4
```

###### Методы

На данный момент у коллекции доступны следующий список методов:
- `first()` - Возвращает первый атрибут коллекции
- `last()` - Возвращает последний атрибут коллекции
- `key()` - возвращает индекс текущего атрибута коллекции.
- `next()` - Возвращает следующий после текущего атрибута коллекции
- `current()`  - Возвращает текущий атрибут коллекции
- `all()` - Возвращает все атрибуты коллекции в виде массива
- `map()` - Обертка над функцией [array_map](http://php.net/manual/ru/function.array-map.php "array_map") 
- `mapWithKeys()` - Аналог метода [mapwithkeys](https://laravel.com/docs/5.7/collections#method-mapwithkeys "mapwithkeys") c Laravel
- `filter()` - Обертка над функцией [array-filter](http://php.net/manual/ru/function.array-filter.php "array-filter")
- `reduce()`  - Обертка над функцией [array_reduce](http://php.net/manual/ru/function.array-reduce.php "array_reduce")
- `diff()` - Обертка над функцией [array_diff](http://php.net/manual/ru/function.array-diff.php "array_diff")
- `diffUsing()` - Обертка над функцией [array_udiff](http://php.net/manual/ru/function.array-udiff.php "array_udiff")
- `diffAssoc()` - Обертка над функцией [array_diff_assoc](http://php.net/manual/ru/function.array-diff-assoc.php "array_diff_assoc")
- `diffAssocUsing()` - Обертка над функцией [array_diff_assoc](http://php.net/manual/ru/function.array-diff-assoc.php "array_diff_assoc")
-`diffKeys()` - Обертка над функцией [array_diff_key](http://php.net/manual/ru/function.array-diff-key.php "array_diff_key")
- `diffKeysUsing()` - Обертка над функцией [array_diff_ukey](http://php.net/manual/ru/function.array-diff-ukey.php "array_diff_ukey")
- `each()` - Аналог метода [each](https://laravel.com/docs/5.7/collections#method-each "each") с Laravel
- `when()` - Аналог метода [when](https://laravel.com/docs/5.7/collections#method-when "when") с Laravel
- `flip()` - Обертка над функцией [array_flip](http://php.net/manual/ru/function.array-flip.php "array_flip")
- `splice()` - Аналог метода [splice](https://laravel.com/docs/5.7/collections#method-splice "splice") с Laravel
- `merge()` - Обертка над функцией [array_merge](http://php.net/manual/ru/function.array-merge.php "array_merge")
- `combine()` - Обертка над функцией [array_combine](http://php.net/manual/ru/function.array-combine.php "array_combine")
- `partition()` - Аналог метода [partition](https://laravel.com/docs/5.7/collections#method-partition "partition") с Laravel
- `reverse()` - Обертка над функцией [array_reverse](http://php.net/manual/ru/function.array-reverse.php "array_reverse")
- `intersect()` - Обертка над функцией [array_intersect](http://php.net/manual/ru/function.array-intersect.php "array_intersect")
- `intersectByKeys()` - Обертка над функцией [array_intersect_key](http://php.net/manual/ru/function.array-intersect-key.php "array_intersect_key")
- `pad()` - Обертка над функцией [array_pad](http://php.net/manual/ru/function.array-pad.php "array_pad")
- `slice()` - Обертка над функцией [array_slice](http://php.net/manual/ru/function.array-slice.php "array_slice")
- `chunk()` - Аналог метода [chunk](https://laravel.com/docs/5.7/collections#method-chunk "chunk") с Laravel
- `exists()` - Принимает как параметр callback, и возвращает true false в зависимости от условии
- `values()` - Обертка над функцией [array_values](http://php.net/manual/ru/function.array-values.php "array_values")
- `keys()` - Обертка над функцией [array_keys](http://php.net/manual/ru/function.array-keys.php "array_keys")
- `add()` - Добавляет новый атрибут к коллекции
- `remove()` - Удаляет атрибут по ключу
- `push()` - Аналог метода [push](https://laravel.com/docs/5.7/collections#method-push "push") с Laravel
- `sort()` - Аналог метода [sort](https://laravel.com/docs/5.7/collections#method-sort "sort") с Laravel

## Модели



В модели доступны все методы коллекции.

На данный момент в моделях можно указать:
- свойство `fillable` - список элементов для массового заполнения
- cвойство `required` - список обязательных элементов для заполненения (в случае отсутствии элементов из списка required выкидывается exception `MissingRequiredException`)

###### Пример

```php
<?php

use Chocofamily\Collection\Model;

class ModelStub extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'age', 'sex', 'active'
    ];

    protected $required = [
        'first_name'
    ];
}
```




