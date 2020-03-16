#!/bin/bash
YELLOW=$'\e[1;33m'
NC=$'\e[0m'

cwd=$PWD
cd ../../../public/css
target=$PWD
cd $cwd
echo -e "${YELLOW}STYLES${NC}"
lessc styles.less $target/styles.css
lessc --clean-css styles.less $target/styles.min.css
echo -e "${YELLOW}EXAM${NC}"
lessc exam.less $target/exam.css
lessc --clean-css exam.less $target/exam.min.css

