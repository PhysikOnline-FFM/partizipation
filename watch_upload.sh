#!/bin/bash

#
# This script watches the local folder for files with the ending in 'file_endings'
# and uploads them to a server specified in 'server'.
# Using fswatch it only uploads files which were created inside the directory
# while the script was running.
#


server_name="riedbergtv@riedberg.tv"   # include login name if necessary
target_directory="/home/riedbergtv/www.riedberg.tv/partizipation"
file_endings="jpg|png"                 # | separated

is_in_array ()
{
    for v in ${@:2}
    do
        if [[ $v == $1 ]]
        then
            return 1
        fi
    done
    return 0
}

upload_file ()
{
    echo "Uploading "$1
    scp $1 "${server_name}:${target_directory}"
}

clean_up ()
{
    # Maybe add some cleaning up?
    printf "\nBye"
}

files_uploaded=()

trap clean_up EXIT

# Colors
NC='\033[0m'        # no color
RED='\033[0;31m'
GREEN='\033[0;32m'
Yellow='\033[1;33m'

printf "Press CTRL-C to stop.\n"
printf "Checking if ssh connection to $server_name is available..."

status=$(ssh -o BatchMode=yes -o ConnectTimeout=5 $server_name echo ok 2>&1)

if [[ $status == "ok" ]]
then
    printf "Ok\n"
else
    printf "\nConnection is not available! Check your internet connection.\n"
    printf "Did you set up a ssh key for this machine?\n"
    echo $status
    exit 1
fi

printf "${GREEN}Watching files...${NC}\n"

# using fswatch to watch current directory
# only watch for created files which match the include regex
fswatch -0 -r --event Created -E --exclude ".*" --include ".*\.(${file_endings})$" .\
| while read -d "" file
do
    file_name=$( basename $file )

    is_in_array $file "${files_uploaded[@]}"
    is_file_old=$?

    if [[ $is_file_old == 0 ]]
    then
        upload_file $file

        if [[ $? != 0 ]]
        then
            printf "${RED}There was an error uploading ${file}!${NC}\n" >&2
        else
            files_uploaded=( ${files_uploaded[@]} $file )
            printf "${GREEN}Watching files...${NC}\n"
        fi
    fi
done

exit 0
