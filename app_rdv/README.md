# [LIEN DU DEPOT GIT](https://github.com/Dr-J-Watson/toubeelib/)

# GROUPE :
- [Dr-J-Watson](https://github.com/Dr-J-Watson) : Paul Bruson
- [TyrYoxan](https://github.com/TyrYoxan) : Clément Brito
- [Maison-hub](https://github.com/Maison-hub) : Antoine Rubeo-lisa

# Fonctionnalités

## Les fonctionnalités minimales attendues (notées sur 6 points) :
- Lister/rechercher des praticiens
 -> Antoine Rubeo-lisa
- Lister les disponibilités d’un praticien sur une période donnée (date de début, date de fin)
 -> Antoine Rubeo-lisa
- Réserver un rendez-vous pour un praticien à une date/heure donnée
 -> Paul Bruson
- Annuler un rendez-vous, à la demande d’un patient ou d’un praticien
 -> Paul Bruson
- Gérer le cycle de vie des rendez-vous (honoré, non honoré, payé)
 -> Paul Bruson
- Afficher le planning d’un praticien sur une période donnée (date de début, date de fin) en précisant la spécialité concernée et le type de consultation (présentiel, téléconsultation)
 -> Antoine Rubeo-lisa
- Afficher les rendez-vous d’un patient
 -> Clément Brito
- S’authentifier en tant que patient ou praticien
 -> Clément Brito
## Les fonctionnalités additionnelles attendues (notées sur 4 points)
- Créer un praticien
 -> Antoine Rubeo-lisa
- S’inscrire en tant que patient
 -> TODO
- Gérer les indisponibilités d’un praticien : périodes ponctuelles sur lesquelles il ne peut accepter de RDV
 -> TODO
- Gérer les disponibilités d’un praticien : jours, horaires et durée des RDV pour chaque praticien
 -> TODO

# Installation

Vous devez tout simplement cloner le projet et faire un `docker compose up -d --build` pour lancer le projet.
Toutes les donées de test présentes dans le dossier `sql\init-postgres\` seront automatiquement injectées dans la base de données.
