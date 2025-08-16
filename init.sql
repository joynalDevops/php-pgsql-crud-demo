CREATE DATABASE cruddb;
CREATE USER cruduser WITH ENCRYPTED PASSWORD 'crudpass';
GRANT ALL PRIVILEGES ON DATABASE cruddb TO cruduser;

\c cruddb;

CREATE TABLE contacts (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(150)
);

ALTER TABLE contacts OWNER TO cruduser;
