#!/usr/bin/env bash

set -Eeuo pipefail
trap cleanup SIGINT SIGTERM ERR EXIT

script_dir=$(cd "$(dirname "${BASH_SOURCE[0]}")" &>/dev/null && pwd -P)

cleanup() {
  trap - SIGINT SIGTERM ERR EXIT
}

cd ${script_dir}
VERSION=$(awk '{if (match($0,/^define.+ORDERABLE_ORG_VERSION/) && match($0,/[0-9]+\.[0-9]+\.[0-9]+/,m)) print m[0] }' orderable-org/orderable-org.php)
rm -f orderable-org*.zip
zip -r orderable-org-${VERSION}.zip orderable-org/
