docker stop databus-raw-instance
docker rm databus-raw-instance
docker build -t databus-raw .
docker run -it -d --name databus-raw-instance -p 3001:80 databus-raw
