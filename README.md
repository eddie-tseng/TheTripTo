### laravel side porject "The Trip To [  ]"

## 安装

### 環境需求
Laravel 5.3
Composer
Node.js

### 安裝packages
```shell
cd [專案目錄]
composer install
npm install
```

## 配置

### 產生環境設定檔
```shell
copy .env.example .env
```

### 產生key
```shell
php artisan key:generate
```

### 重建資料庫
```shell
php artisan migrate --seed
```

### 設定google api

打開.env，設定參數 
// ...
GOOGLE_CLIENT_ID
GOOGLE_CLIENT_SECRET
GOOGLE_REDIRECT
GOOGLE_MAP_KEY
// ...


### 修改 Socialite 套件

vendor\laravel\socialite\src\AbstractUser.php

```php
// ...
public $firstName;

public $lastName;

// ...
```

vendor\laravel\socialite\src\Two\GoogleProvider.php

```php
protected function mapUserToObject(array $user)
{
    //...
	
    return (new User)->setRaw($user)->map([
	
        // ...
		
        'firstName' => Arr::get($user, 'given_name'),
        'lastName' => Arr::get($user, 'family_name'),
		
        // ...
		
    ]);
}
```