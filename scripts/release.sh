#!/usr/bin/env bash

echo Version n°?
read VERSION
echo "Publish 'v$VERSION' (y/n) ?"
read confirm
if [ "$confirm" != "y" ] && [ "$confirm" != "Y" ]; then
    exit 0;
fi

sed -i '' -E "s/(VERSION[ ]*=[ ]*).+;/\1'$VERSION';/g" src/SharpServiceProvider.php

git tag "v$VERSION"
git push origin --tags

(
cd resources/assets/sass
npm version "$VERSION"
npm publish
)