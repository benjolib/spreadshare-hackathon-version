#!/bin/bash

git pull
git -c diff.mnemonicprefix=false -c core.quotepath=false push -v --tags origin refs/heads/master:refs/heads/master
git checkout master-staging
git -c diff.mnemonicprefix=false -c core.quotepath=false merge --no-ff --log master
git commit -m "DEPLOY-SCRIPT: Auto merged from master"
git push
git checkout master
