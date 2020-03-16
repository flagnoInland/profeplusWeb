#!/bin/bash

red=$'\e[1;31m'
grn=$'\e[1;32m'
yel=$'\e[1;33m'
blu=$'\e[1;34m'
mag=$'\e[1;35m'
cyn=$'\e[1;36m'
end=$'\e[0m'

cwd=$PWD
cd ../../../public/css
target=$PWD
cd $cwd

echo -e "${yel}STYLES${end}"
lessc styles.less $target/styles.css
lessc --clean-css styles.less $target/styles.min.css