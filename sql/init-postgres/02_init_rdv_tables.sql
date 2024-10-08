\list
-- Connect to RDV database
\c rdv;

-- Create tables for RDV database
CREATE TABLE rdv (
    id uuid DEFAULT gen_random_uuid() PRIMARY KEY,
    practicienID VARCHAR(255) NOT NULL,
    patientID VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    dateHeure TIMESTAMP NOT NULL,
    statut VARCHAR(255) NOT NULL
);

-- insert some data
INSERT INTO rdv ( practicienID, patientID, type, dateHeure, statut) VALUES ('p1', 'pa1', 'A', '2024-09-02 09:00', 'OK');
INSERT INTO rdv ( practicienID, patientID, type, dateHeure, statut) VALUES ('p1', 'pa1', 'A', '2024-09-02 10:00', 'OK');
INSERT INTO rdv ( practicienID, patientID, type, dateHeure, statut) VALUES ('p3', 'pa1', 'A', '2024-09-02 09:30', 'OK');