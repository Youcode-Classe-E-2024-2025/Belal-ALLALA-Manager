CREATE DATABASE IF NOT EXISTS packages_web;
USE packages_web;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    statut VARCHAR(50)
);

CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT
);

CREATE TABLE permissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT
);

CREATE TABLE role_permissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_role INT NOT NULL,
    id_permission INT NOT NULL,
    FOREIGN KEY (id_role) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (id_permission) REFERENCES permissions(id) ON DELETE CASCADE
);

CREATE TABLE user_roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_role INT NOT NULL,
    id_user INT NOT NULL,
    FOREIGN KEY (id_role) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE packages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE versions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_package INT NOT NULL,
    version_number VARCHAR(255) UNIQUE NOT NULL,
    release_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_package) REFERENCES packages(id) ON DELETE CASCADE
);

CREATE TABLE collaborations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    id_package INT NOT NULL,
    FOREIGN KEY (id_package) REFERENCES packages(id) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (username, email, password_hash, statut) VALUES
    ('john_doe', 'john.doe@example.com', 'hashedpassword123', 'active'),
    ('jane_smith', 'jane.smith@example.com', 'hashedpassword456', 'active'),
    ('admin', 'admin@example.com', 'adminhashedpassword', 'active'),
    ('visitor', 'visitor@example.com', 'hashedpassword789', 'inactive');

INSERT INTO roles (name, description) VALUES
    ('visitor', 'Utilisateur non enregistré, accès limité en lecture seule'),
    ('author', 'Utilisateur autorisé à créer et gérer ses propres packages'),
    ('admin', 'Administrateur avec tous les privilèges'),
    ('moderator', 'Modérateur du site, peut approuver/rejeter les utilisateurs et les packages');

INSERT INTO permissions (name, description) VALUES
    ('package:create', 'Créer un nouveau package'),
    ('package:read', 'Lire les informations d''un package'),
    ('package:update', 'Mettre à jour un package'),
    ('package:delete', 'Supprimer un package'),
    ('package:publish', 'Publier un package');

INSERT INTO role_permissions (id_role, id_permission) VALUES
    (1, 2), 
    (2, 1), 
    (2, 2), 
    (2, 3), 
    (3, 1), 
    (3, 2), 
    (3, 3), 
    (3, 4); 

INSERT INTO user_roles (id_role, id_user) VALUES
    (1, 4), 
    (2, 1), 
    (2, 2), 
    (3, 3); 

INSERT INTO packages (name, description) VALUES
    ('react', 'Bibliothèque JavaScript pour créer des interfaces utilisateur'),
    ('express', 'Framework Node.js pour créer des applications web'),
    ('axios', 'Client HTTP basé sur les promesses pour le navigateur et Node.js'),
    ('lodash', 'Bibliothèque utilitaire JavaScript moderne offrant modularité, performances et extras.'),
    ('moment', 'Bibliothèque JavaScript pour analyser, valider, manipuler et afficher des dates.');

INSERT INTO versions (id_package, version_number, release_notes) VALUES
    (1, '18.2.0', 'Corrections de bugs et améliorations de performances'),
    (1, '17.0.2', 'Version majeure avec de nouvelles fonctionnalités'),
    (2, '4.18.2', 'Mises à jour de sécurité et améliorations mineures'),
    (3, '1.2.0', 'Support amélioré pour les requêtes HTTP'),
    (4, '4.17.21', 'Nouvelles fonctions utilitaires et optimisations');

INSERT INTO collaborations (id_user, id_package) VALUES
    (1, 1), 
    (2, 2), 
    (1, 3), 
    (2, 4); 
