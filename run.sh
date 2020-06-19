docker rm databus-raw-instance 
docker build -t databus-raw .
docker run -it --name databus-raw-instance -p 8080:80 databus-raw
