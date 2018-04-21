# **linuxhub.ru**
`linuxhub.ru` - linux-форум, который был создан для людей не употребляющих тюремный сленг.

## **Описание**
В данном репозитории содержится всё для сборки docker-контейнеров, которые позволят запустить локальную копию форума. Стоит отметить, что из базы данных были удалены все пользовательские хеши паролей, емейлы, подписи, даты рождения и т.д. Что бы залогиниться **любым** пользователем в системе, следует использовать пароль *admin*.

## **Сборка и запуск**
```
$ sudo apt install docker-ce python-dev python-pip python-virtualenv virtualenv
$ git clone https://github.com/LinuxHubRu/dockerized-linuxhub_ru
$ cd dockerized-linuxhub_ru
~/dockerized-linuxhub_ru/$ virtualenv venv
~/dockerized-linuxhub_ru/$ source venv/bin/activate
~/dockerized-linuxhub_ru/(venv)$ pip install docker-compose
~/dockerized-linuxhub_ru/(venv)$ docker-compose up
```
