CREATE TABLE User (
                      id INT PRIMARY KEY,
                      prenom VARCHAR(255),
                      nom VARCHAR(255)
);

CREATE TABLE Serie (
                       id INT PRIMARY KEY,
                       nom VARCHAR(255)
);

CREATE TABLE Localisation (
                              id INT PRIMARY KEY,
                              localisation_id INT,
                              serie_id INT,
                              FOREIGN KEY (serie_id) REFERENCES Serie(id)
);

CREATE TABLE Partie (
                        id INT PRIMARY KEY,
                        user_id INT,
                        score INT,
                        difficulte INT,
                        serie_id INT,
                        FOREIGN KEY (user_id) REFERENCES User(id),
                        FOREIGN KEY (serie_id) REFERENCES Serie(id)
);

INSERT INTO User (id, prenom, nom) VALUES
                                       (1, 'John', 'Doe'),
                                       (2, 'Jane', 'Smith'),
                                       (3, 'Alice', 'Johnson');

INSERT INTO Serie (id, nom) VALUES
                                (1, 'Serie A'),
                                (2, 'Serie B'),
                                (3, 'Serie C');

INSERT INTO Localisation (id, localisation_id, serie_id) VALUES
                                                             (1, 100, 1),
                                                             (2, 200, 2),
                                                             (3, 300, 3);

INSERT INTO Partie (id, user_id, score, difficulte, serie_id) VALUES
                                                                  (1, 1, 100, 3, 1),
                                                                  (2, 2, 150, 4, 2),
                                                                  (3, 3, 120, 2, 3);
