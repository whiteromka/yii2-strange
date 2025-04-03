Команды для Elastic Search.

Запускать в WSL:

sudo systemctl restart elasticsearch - Запуск elastic
sudo systemctl status elasticsearch  - Проверить статус
sudo systemctl stop elasticsearch - остановить
sudo pkill -f elasticsearch - принудительно завершить все процессы

sudo nano /etc/elasticsearch/elasticsearch.yml - Настройки Elastic

Команда на установку:
docker run -d --name elasticsearch -p 9200:9200 -p 9300:9300 -e "discovery.type=single-node" -e "xpack.security.enabled=false" elasticsearch:8.11.4
Команда на проверку:
curl http://localhost:9200

KIBANA Для просмотра в браузере:
http://localhost:5601/app/home#/


Если затираются данные после выключения докера:
docker run -d --name elasticsearch \
  -p 9200:9200 -p 9300:9300 \
  -e "discovery.type=single-node" \
  -v elastic_data:/usr/share/elasticsearch/data \
  elasticsearch:8.11.4


