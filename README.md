# Protoype of the Databus Raw Web-Interface

## How to run the thing

``` 
git clone https://github.com/dbpedia/databus-raw.git
cd databus-raw
docker build -t databus-raw .
docker run -it --name databus-raw-instance -p 8080:80 databus-raw
```

Access at `localhost:8080`

Test the downloading without pulling the entire bus:
```
wget --mirror --no-parent localhost:8080/marvin/wikidata/instance-types/
```
