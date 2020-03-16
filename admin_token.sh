#!/bin/bash

RED=$'\e[1;31m'
YELLOW=$'\e[1;33m'
NC=$'\e[0m'

URL='http://10.100.52.30'
URL='http://local.android'

echo -e "${RED}LOGIN${NC}"
echo -e "${YELLOW}curl --get http://local.android/usertoken?email=herbertacg@gmail.com&password=1234${NC}"
#curl -s -X POST -d "email=herbertacg@gmail.com&password=1234" "$URL/usertoken" > test.html
curl -s -X POST -d "email=herbertacg@gmail.com&password=1234" "$URL/usertoken"