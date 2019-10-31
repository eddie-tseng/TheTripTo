## 安装

###安裝packages
```shell
cd [專案目錄]
composer install
npm install
```shell

##配置

###產生環境設定檔
```shell
cp .env.example .env
```shell

###產生key
```shell
php artisan key:generate
```shell

###重建資料庫
```shell
php artisan migrate --seed
```shell

