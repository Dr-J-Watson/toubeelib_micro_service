-- Connect to praticien database
\c praticien;

CREATE TABLE specialite (
    id uuid PRIMARY KEY,
    label VARCHAR(255) NOT NULL,
    description TEXT
);

-- Create tables for praticien database
CREATE TABLE praticien (
    id uuid DEFAULT gen_random_uuid() PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    tel VARCHAR(20) NOT NULL,
    specialite_id uuid REFERENCES specialite(id)
);



-- insert some data
INSERT INTO specialite (id, label, description) VALUES ('a516d03d-2d1d-439d-8f80-0dc29b6b5eb9', 'Dentiste', 'Spécialiste des dents');
INSERT INTO specialite (id, label, description) VALUES ('615af072-60c3-4faa-9871-f8f961e9b614', 'Ophtalmologue', 'Spécialiste des yeux');
INSERT INTO specialite (id, label, description) VALUES ('8fab6d4d-f62b-4815-8a90-a2426dcec6e7', 'Généraliste', 'Médecin généraliste');
INSERT INTO specialite (id, label, description) VALUES ('d2018131-7b60-4676-a56f-b2287ebc4354', 'Pédiatre', 'Médecin pour enfants');
INSERT INTO specialite (id, label, description) VALUES ('0f35c61f-f107-4d81-bc2d-f8de618245df', 'Médecin du sport', 'Maladies et trausmatismes liés à la pratique sportive');

-- Insertion des praticien
INSERT INTO praticien (id, nom, prenom, adresse, tel, specialite_id)
VALUES
('c401c65c-8d47-3fab-bab3-c3713a09ce06', 'Vaillant', 'Thomas', '10 Rue du Soleil, Lyon', '0620212223', '8fab6d4d-f62b-4815-8a90-a2426dcec6e7'), -- Généraliste
('40708f53-a81b-3f1f-aeed-886ce1e3be60', 'Gonzalez', 'Patricia', '45 Avenue des Champs, Paris', '0623242526', '615af072-60c3-4faa-9871-f8f961e9b614'), -- Ophtalmologue
('d7b34ecf-f3c0-3f2d-84c9-be32f27f1a78', 'Rey', 'Alexandre', '8 Rue des Alpes, Grenoble', '0627282930', '0f35c61f-f107-4d81-bc2d-f8de618245df'), -- Médecin du sport
('28b72906-3cbf-3662-8806-b471d873343e', 'Dumas', 'Madeleine', '56 Boulevard Voltaire, Paris', '0630313233', 'd2018131-7b60-4676-a56f-b2287ebc4354'), -- Pédiatre
('cf11bb88-f700-3b8e-8c17-745902612058', 'Alexandre', 'Frédérique', '2 Rue des Fleurs, Nice', '0634353637', 'a516d03d-2d1d-439d-8f80-0dc29b6b5eb9'); -- Dentiste
