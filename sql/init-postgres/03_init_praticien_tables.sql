-- Connect to praticien database
\c praticien;

-- Create tables for praticien database
CREATE TABLE praticien (
    id uuid DEFAULT gen_random_uuid() PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    tel VARCHAR(20) NOT NULL,
    specialite_id VARCHAR(10) NOT NULL
);

CREATE TABLE specialite (
    id VARCHAR(10) PRIMARY KEY,
    label VARCHAR(255) NOT NULL,
    description TEXT
);

-- insert some data
INSERT INTO specialite (id, label, description) VALUES ('A', 'Dentiste', 'Spécialiste des dents');
INSERT INTO specialite (id, label, description) VALUES ('B', 'Ophtalmologue', 'Spécialiste des yeux');
INSERT INTO specialite (id, label, description) VALUES ('C', 'Généraliste', 'Médecin généraliste');
INSERT INTO specialite (id, label, description) VALUES ('D', 'Pédiatre', 'Médecin pour enfants');
INSERT INTO specialite (id, label, description) VALUES ('E', 'Médecin du sport', 'Maladies et trausmatismes liés à la pratique sportive');

INSERT INTO praticien (nom, prenom, adresse, tel, specialite_id) VALUES ( 'Dupont', 'Jean', 'nancy', '0123456789', 'A');
INSERT INTO praticien (nom, prenom, adresse, tel, specialite_id) VALUES ( 'Durand', 'Pierre', 'vandeuve', '0123456789', 'B');
INSERT INTO praticien (nom, prenom, adresse, tel, specialite_id) VALUES ( 'Martin', 'Marie', '3lassou', '0123456789', 'C');
