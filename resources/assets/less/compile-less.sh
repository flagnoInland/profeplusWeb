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
echo -e "${YELLOW}APP MODE${NC}"
lessc app_mode.less $target/app_mode.css
lessc --clean-css app_mode.less $target/app_mode.min.css
echo -e "${YELLOW}LOGIN${NC}"
lessc login.less $target/login.css
lessc --clean-css login.less $target/login.min.css
echo -e "${YELLOW}REGISTER${NC}"
lessc register.less $target/register.css
lessc --clean-css register.less $target/register.min.css
echo -e "${YELLOW}BOARD${NC}"
lessc board.less $target/board.css
lessc --clean-css board.less $target/board.min.css
echo -e "${YELLOW}RESULT${NC}"
lessc result.less $target/result.css
lessc --clean-css result.less $target/result.min.css
echo -e "${YELLOW}ANSWER${NC}"
lessc answerboard.less $target/answerboard.css
lessc --clean-css answerboard.less $target/answerboard.min.css
echo -e "${YELLOW}REPORT${NC}"
lessc report.less $target/report.css
lessc --clean-css report.less $target/report.min.css
echo -e "${YELLOW}EXAM${NC}"
lessc exam.less $target/exam.css
lessc --clean-css exam.less $target/exam.min.css
echo -e "${YELLOW}TOAST${NC}"
lessc toastr.less $target/toastr.css
lessc --clean-css toastr.less $target/toastr.min.css
