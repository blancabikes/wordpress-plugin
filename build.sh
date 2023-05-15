#!/bin/sh
VERSION=$(awk '{if (match($0,/^define.+ORDERABLE_ORG_VERSION/) && match($0,/[0-9]+\.[0-9]+\.[0-9]+/,m)) print m[0] }' orderable-org/orderable-org.php)
rm -f orderable-org*.zip
zip -rq orderable-org-${VERSION}.zip orderable-org/
