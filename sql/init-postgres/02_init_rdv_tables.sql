\list
-- Connect to RDV database
\c rdv;

-- Create tables for RDV database
CREATE TABLE rdv (
    id UUID PRIMARY KEY,
    practicienID VARCHAR(255) NOT NULL,
    patientID VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    dateHeure TIMESTAMP NOT NULL,
    statut VARCHAR(255) NOT NULL
);