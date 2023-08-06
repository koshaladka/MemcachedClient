<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## Проект MemcachedClient

Библиотека должна на низком уровне реализовывает команды get/set/delete.

### Laravel Sail

Проект развернут с использование Laravel Sail. 
Memcached  установлен в отдельном контейнере.

###  Для запуска из директории проекта необходимо выполнить следующие команды

- *composer install*
- *./vendor/bin/sail up*

###  Для проверки тестов

- *alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'*
- *sail artisan test*
