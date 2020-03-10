#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE ecofriendly_test;"
    psql -U postgres -c "CREATE USER ecofriendly PASSWORD 'ecofriendly' SUPERUSER;"
else
    sudo -u postgres dropdb --if-exists ecofriendly
    sudo -u postgres dropdb --if-exists ecofriendly_test
    sudo -u postgres dropuser --if-exists ecofriendly
    sudo -u postgres psql -c "CREATE USER ecofriendly PASSWORD 'ecofriendly' SUPERUSER;"
    sudo -u postgres createdb -O ecofriendly ecofriendly
    sudo -u postgres psql -d ecofriendly -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O ecofriendly ecofriendly_test
    sudo -u postgres psql -d ecofriendly_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    LINE="localhost:5432:*:ecofriendly:ecofriendly"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi
