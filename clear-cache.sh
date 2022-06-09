#!/bin/bash

with_chown=${1-"false"}
apache_user=${2-"www-data"}

for path in app/cache var/cache
do
    if [ -d "$path" ];
    then # Check if path exist
        for envs in /dev /prod /test /cli /st
        do
            if [ -d "$path$envs" ];
            then # Check if folder exist
                rm -R "$path$envs"
            fi
        done
        if [ "$with_chown" != false ] && [ "$with_chown" != "False" ] && [ "$with_chown" != "FALSE" ] ;
        then
            chown -R ${apache_user} "$path"
        fi
    fi
done
