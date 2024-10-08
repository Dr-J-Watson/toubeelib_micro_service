-- Connect to praticien database
\c praticien;

-- Create tables for praticien database
CREATE TABLE praticien (
    id UUID PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    tel VARCHAR(20) NOT NULL,
    specialite_id VARCHAR(10) NOT NULL
);