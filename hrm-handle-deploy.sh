#!/bin/bash
dir_placeholder="/root/HRM"
compose_file_placeholder="docker-compose-hrm.yml"
docker_repo_placeholder="troontech/troon-hrm"
image_detail=$(docker images | awk '/HRM-Main/')
image_name=$(echo "$image_detail" | awk '/HRM-Main/ {print $2}')
echo "$image_name"
if [ "$image_name" = "HRM-Main" ];
then echo "---image found---";
cd $dir_placeholder
docker-compose -f $compose_file_placeholder down
sleep 1
docker rmi -f $docker_repo_placeholder:$image_name
else echo "-----image not found----";
docker-compose -f $compose_file_placeholder down
fi;
cd $dir_placeholder
sleep 10
#docker load -i livedotnet.tar
docker-compose -f $compose_file_placeholder up -d
