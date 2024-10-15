\list
-- Connect to RDV database
\c rdv;

-- Create tables for RDV database
CREATE TABLE rdv (
    id uuid DEFAULT gen_random_uuid() PRIMARY KEY,
    praticien_id VARCHAR(255) NOT NULL,
    patient_id VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    date_heure TIMESTAMP NOT NULL,
    statut VARCHAR(255) NOT NULL
);



-- insert some data
INSERT INTO rdv ( praticien_id, patient_id, type, date_heure, statut) VALUES ('p1', 'pa1', 'A', '2024-09-02 09:00', 'OK');
INSERT INTO rdv ( praticien_id, patient_id, type, date_heure, statut) VALUES ('p1', 'pa1', 'A', '2024-09-02 10:00', 'OK');
INSERT INTO rdv ( praticien_id, patient_id, type, date_heure, statut) VALUES ('p3', 'pa1', 'A', '2024-09-02 09:30', 'OK');