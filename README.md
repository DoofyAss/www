# <sub>Data Base</sub>
###### <sup>PHP 7.1.3</sup>

## <sub>SELECT</sub>

```php
$user = DB('user')
->where('id', 1)
->get();				// SELECT *
// ->get('name', 'login');		// SELECT name, login

echo $user->name;
```

```php
$user = DB('user', 1);			// SELECT * FROM user WHERE id = 1
```

```php
$user = DB('user', 'name', 'Admin');	// SELECT * FROM user WHERE name = 'Admin'
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
->order('id', true)			// ORDER BY id DESC
```

## <sub>UPDATE</sub>

```php
DB('user')
->where('id', 1)
->update('login', 'admin')		// UPDATE user SET login = 'admin' WHERE id = 1  
->update('name', 'Admin');		// UPDATE user SET name = 'Admin' WHERE id = 1
```

```php
DB('user')
->where('id', 1)
->update([				// UPDATE user SET login = 'admin', name = 'Admin' WHERE id = 1
	'login' => 'admin',
	'name' => 'Admin'
]);
```