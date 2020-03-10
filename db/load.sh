#!/bin/sh

BASE_DIR=$(dirname "$(readlink -f "$0")")
if [ "$1" != "test" ]; then
    psql -h localhost -U ecofriendly -d ecofriendly < $BASE_DIR/ecofriendly.sql
fi
psql -h localhost -U ecofriendly -d ecofriendly_test < $BASE_DIR/ecofriendly.sql
