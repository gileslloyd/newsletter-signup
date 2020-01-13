#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" <<-EOSQL
    ALTER USER postgres PASSWORD 'password';
    GRANT ALL PRIVILEGES ON DATABASE ns-signups TO ns-signups;

EOSQL

psql ns-signups -c 'create extension hstore;'