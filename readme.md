- redis, potgres, nginx на хост машине или в облаке
- php-fpm в контейнере
Must have 
- firewall: разрешить только 80/443

redis bind 127.0.0.1 + password

postgres listen 127.0.0.1

docker без --privileged

secrets через env / file

старутем с помозью rund
```shell
docker run -d \
  --name php-fpm \
  --restart=always \
  -p 127.0.0.1:9000:9000 \
  -e DATABASE_URL=postgresql://user:pass@127.0.0.1:5432/app \
  -e REDIS_URL=redis://:SUPER_STRONG_PASSWORD@127.0.0.1:6379 \
  app:latest

```