###### <sub>PHP 7.1.3</sub>
# <sub>Data Base</sub>

## <sub>SELECT</sub>

```php
->get();                  // SELECT *
->get('name', 'login');   // SELECT name, login
```

```php
$user = DB('user')
->where('id', 1)
->get();

echo $user->name;
```

## <sub>EACH</sub>

```php
DB('user')->each(function ($user) {
	echo $user->name;
});
```  
```php
->limit(0, 10)
->limit(10)
->order('id', true)   // ORDER BY id DESC
```

## <sub>UPDATE</sub>

```php
DB('user')
->where('id', 1)
->update('login', 'admin')
->update('name', 'Admin');
```  
> <sup>UPDATE user SET login = 'admin' WHERE id = 1  
UPDATE user SET name = 'Admin' WHERE id = 1</sup>  

```php
DB('user')
->where('id', 1)
->update([
	'login' => 'admin',
	'name' => 'Admin'
]);
```  
> <sup>UPDATE user SET login = 'admin', name = 'Admin' WHERE id = 1</sup>