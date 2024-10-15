\list
-- Connect to RDV database
\c rdv;

-- Create tables for RDV database
CREATE TABLE rdv (
    id uuid DEFAULT gen_random_uuid() PRIMARY KEY,
    praticien_id uuid NOT NULL,
    patient_id uuid NOT NULL,
    type_id uuid NOT NULL,
    date_heure TIMESTAMP NOT NULL,
    statut VARCHAR(255) DEFAULT 'RESEVE'
);

--  table type

CREATE TABLE type (
    id uuid DEFAULT gen_random_uuid() PRIMARY KEY,
    label VARCHAR(255) NOT NULL,
    description TEXT
);

CREATE TABLE time_type (
    id uuid DEFAULT gen_random_uuid() PRIMARY KEY,
    praticien_id uuid NOT NULL,
    type_id uuid NOT NULL,
    temps_minutes INT NOT NULL,
    FOREIGN KEY (type_id) REFERENCES type(id)
);

-- insert type
INSERT INTO type (id, label, description) 
VALUES 
('dd133889-6750-45a6-be8a-0cb836e8932b', 'Consultation', 'Consultation chez le médecin'),
('72ad0c2d-b2d9-4f3c-8b4b-083b819ae14f', 'Examen', 'Examen médical'),
('f366b758-2f86-469a-9d22-890730db3e95', 'Opération', 'Opération chirurgicale'),
('f41235c4-842b-4879-a84c-16aab64a48c4', 'Ordonance', 'Renouvelement d ordonance');

-- Insertion des données dans time_type
INSERT INTO time_type (praticien_id, type_id, temps_minutes)
VALUES
('c401c65c-8d47-3fab-bab3-c3713a09ce06', 'dd133889-6750-45a6-be8a-0cb836e8932b', 15),
('cf11bb88-f700-3b8e-8c17-745902612058', '72ad0c2d-b2d9-4f3c-8b4b-083b819ae14f', 30),
('40708f53-a81b-3f1f-aeed-886ce1e3be60', 'dd133889-6750-45a6-be8a-0cb836e8932b', 20),
('40708f53-a81b-3f1f-aeed-886ce1e3be60', 'f366b758-2f86-469a-9d22-890730db3e95', 90),
('d7b34ecf-f3c0-3f2d-84c9-be32f27f1a78', '72ad0c2d-b2d9-4f3c-8b4b-083b819ae14f', 10),
('28b72906-3cbf-3662-8806-b471d873343e', 'f41235c4-842b-4879-a84c-16aab64a48c4', 5);


-- Insertion des rendez-vous
INSERT INTO rdv (praticien_id, patient_id, type_id, date_heure)
VALUES
('c401c65c-8d47-3fab-bab3-c3713a09ce06', '118a9bca-b30e-360a-9acb-0f44498fa9cb', 'dd133889-6750-45a6-be8a-0cb836e8932b', '2024-10-20 14:00:00'), -- Consultation
('40708f53-a81b-3f1f-aeed-886ce1e3be60', 'bdbc09de-d523-34a5-bec7-743953a7cd2f', '72ad0c2d-b2d9-4f3c-8b4b-083b819ae14f', '2024-10-21 09:30:00'), -- Examen
('d7b34ecf-f3c0-3f2d-84c9-be32f27f1a78', '33c59f91-10ff-3e5a-a4dd-ffb5e4d1d513', 'f366b758-2f86-469a-9d22-890730db3e95', '2024-10-22 11:00:00'), -- Opération
('28b72906-3cbf-3662-8806-b471d873343e', '98c2aeae-a2f1-382c-8c94-65a27d52f991', 'dd133889-6750-45a6-be8a-0cb836e8932b', '2024-10-23 16:30:00'), -- Consultation
('cf11bb88-f700-3b8e-8c17-745902612058', 'f930c1de-5fa2-3832-ba7c-b2d05a9dc2d4', 'f41235c4-842b-4879-a84c-16aab64a48c4', '2024-10-24 10:15:00'), -- Renouvellement d'ordonnance
('c401c65c-8d47-3fab-bab3-c3713a09ce06', '5957675b-b7b0-39ba-8b3a-920b2f7a523f', '72ad0c2d-b2d9-4f3c-8b4b-083b819ae14f', '2024-10-25 15:00:00'), -- Examen
('40708f53-a81b-3f1f-aeed-886ce1e3be60', 'fd774f03-935f-39f5-ba95-2f01ffee28dd', 'dd133889-6750-45a6-be8a-0cb836e8932b', '2024-10-26 13:00:00'); -- Consultation