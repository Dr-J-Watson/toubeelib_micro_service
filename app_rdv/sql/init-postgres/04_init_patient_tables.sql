CREATE DATABASE patient;


\list
-- Connect to Patient database
\c patient;

-- Create tables for Patient database
CREATE TABLE patient (
    id uuid DEFAULT gen_random_uuid() PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    tel VARCHAR(20) NOT NULL
);

-- Insertion des patients
INSERT INTO patient (id, nom, prenom, adresse, tel)
VALUES
('118a9bca-b30e-360a-9acb-0f44498fa9cb', 'Munoz', 'Théophile', '25 Rue de la Liberté, Paris', '0601020304'),
('bdbc09de-d523-34a5-bec7-743953a7cd2f', 'Godard', 'Sophie', '12 Avenue des Ternes, Paris', '0605060708'),
('33c59f91-10ff-3e5a-a4dd-ffb5e4d1d513', 'Ledoux', 'Louis', '34 Boulevard de la Villette, Paris', '0608091011'),
('98c2aeae-a2f1-382c-8c94-65a27d52f991', 'Michel', 'Georges', '15 Rue de la Paix, Lyon', '0611121314'),
('f930c1de-5fa2-3832-ba7c-b2d05a9dc2d4', 'Mahé', 'René', '78 Rue des Lilas, Marseille', '0614151617');
