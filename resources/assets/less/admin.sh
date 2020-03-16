#!/bin/bash

YELLOW=$'\e[1;33m'
NC=$'\e[0m'

cwd=$PWD
cd ../../../public/css
target=$PWD
cd $cwd
echo -e "${YELLOW}ADMIN${NC}"
#sass admin.scss admin.css
sass --watch admin.scss:$target/admin.min.css --style compressed

