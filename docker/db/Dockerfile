# Building this image: docker build -t mysqlimage .
# Run detached: docker run -d -v ~/test/Datadir:/var/lib/mysql --name sqlinstance mysqlimage
# Run from datacontainer: docker run -d --volumes-from mysqlvol --name sqlinstance mysqlimage
# Bash into: docker exec -it sqlinstance bash 
# Remove expired container: docker rm sqlinstance

FROM mysql:5.7.21

