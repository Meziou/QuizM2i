USE quizM2i;

DROP Table if EXISTS quizs;
DROP Table if EXISTS questions;
DROP Table if EXISTS quizs_questions;

CREATE table quizs(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);
CREATE table questions(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    response VARCHAR (255) NOT NULL,
    correctAnswer INT NOT NULL
)ENGINE=InnoDB;

CREATE TABLE quizs_questions (
    id_quizs INT,
    id_questions INT,
    PRIMARY KEY (id_quizs, id_questions),
    FOREIGN KEY (id_quizs) REFERENCES quizs(id),
    FOREIGN KEY (id_questions) REFERENCES questions(id)
);

INSERT INTO quizs (name) VALUES 
('Pokemon'),
('Jeu videos'),
('Films'),
('Manga');

INSERT INTO questions(name, response, correctAnswer) VALUES
("Quel Pokémon est une souris électrique ?", "Salamèche, Pikachu, Bulbizarre, Carapuce", 2),
("Quel type est le Pokémon Rondoudou ?", "Eau, Feu, Fée, Électrique", 3),
("Quel Pokémon évolue en Dracaufeu ?", "Reptincel, Bulbizarre, Carapuce, Roucoups", 1),
("Quel Pokémon est numéro 1 dans le Pokédex ?", "Bulbizarre, Herbizarre, Florizarre, Salamèche", 1),
("De quelle couleur est Léviator shiny ?", "Bleu, Rouge, Vert, Jaune", 2),
('Quel est le héros principal de la série The Legend of Zelda ?', 'Mario, Link, Zelda, Samus', 2),
('Quel jeu vidéo met en scène des voitures jouant au football ?', 'FIFA, Gran Turismo, Rocket League, Need for Speed', 3),
('Dans quel jeu vidéo trouve-t-on l\'île de Banoi ?', 'Far Cry, Dead Island, The Witcher, Assassin\'s Creed', 2),
('Quel est le nom du personnage principal de la série Halo ?', 'Master Chief, Cortana, Marcus Fenix, Gordon Freeman', 1),
('Quel jeu vidéo a popularisé le genre Battle Royale ?', 'Minecraft, Call of Duty, PUBG, Fortnite', 4),
('Dans quel jeu incarne-t-on un tueur à gages nommé Agent 47 ?', 'Hitman, Splinter Cell, Metal Gear Solid, Max Payne', 1),
('Quel est le studio de développement derrière le jeu The Witcher 3 ?', 'BioWare, Bethesda, CD Projekt Red, Ubisoft', 3),
('Dans quel jeu vidéo peut-on explorer une version fictive de l\'Amérique post-apocalyptique appelée Appalachia ?', 'Fallout 76, Metro Exodus, The Last of Us, Days Gone', 1),
('Quel jeu vidéo met en scène une civilisation futuriste attaquée par des créatures extraterrestres appelées les Zergs ?', 'Warcraft, Halo, Mass Effect, Starcraft', 4),
('Quel jeu vidéo met en scène des robots géants pilotés par des humains dans des combats intenses ?', 'Overwatch, Titanfall, Apex Legends, Destiny', 2),
('Quel film a remporté l\'Oscar du meilleur film en 2020 ?', 'Joker, 1917, Parasite, Once Upon a Time in Hollywood', 3),
('Qui a réalisé le film \'Inception\' sorti en 2010 ?', 'Steven Spielberg, Christopher Nolan, James Cameron, Quentin Tarantino', 2),
('Dans quel film trouve-t-on le personnage de Jack Dawson ?', 'Titanic, Avatar, Gladiator, The Revenant', 1),
('Quel est le premier film de la saga Star Wars sorti en 1977 ?', 'Le Retour du Jedi, L\'Empire contre-attaque, La Menace fantôme, Un nouvel espoir', 4),
('Quel film met en scène un T-Rex et un parc à thème préhistorique ?', 'King Kong, Jurassic Park, Le Monde perdu, Dinotopia', 2),
('Qui joue le rôle principal dans le film \'Forrest Gump\' ?', 'Tom Hanks, Leonardo DiCaprio, Brad Pitt, Johnny Depp', 1),
('Quel film d\'animation de Disney met en scène un lion nommé Simba ?', 'Le Roi Lion, Bambi, Mulan, Tarzan', 1),
('Quel film de Quentin Tarantino raconte l\'histoire de deux gangsters, un boxeur et un couple de braqueurs ?', 'Pulp Fiction, Kill Bill, Reservoir Dogs, Django Unchained', 1),
('Dans quel film trouve-t-on le personnage de Neo, interprété par Keanu Reeves ?', 'John Wick, Constantine, The Matrix, Speed', 3),
('Quel film est basé sur l\'histoire vraie du naufrage du Titanic ?', 'A Night to Remember, Poseidon, Titanic, The Abyss', 3),
('Quel est le nom du héros principal de \'One Piece\' ?', 'Monkey D. Luffy, Naruto Uzumaki, Ichigo Kurosaki, Natsu Dragnir', 1),
('Dans \'Naruto\', quel est le démon renard à neuf queues scellé en Naruto ?', 'Shukaku, Gyuki, Kurama, Matatabi', 3),
('Quel manga met en scène des chasseurs de titans ?', 'Bleach, Attack on Titan, Tokyo Ghoul, Hunter x Hunter', 2),
('Qui est le créateur du manga \'Dragon Ball\' ?', 'Eiichiro Oda, Masashi Kishimoto, Tite Kubo, Akira Toriyama', 4),
('Dans \'Death Note\', quel est le nom du dieu de la mort qui accompagne Light Yagami ?', 'Rem, Ryuk, Sidoh, Zellogi', 2),
('Quel manga suit les aventures d\'un groupe de lycéens piégés dans un jeu mortel appelé \'Gantz\' ?', 'Gantz, Berserk, Parasyte, Tokyo Ghoul', 1),
('Dans \'My Hero Academia\', quel est le véritable nom de l\'héroïne Uravity ?', 'Ochaco Uraraka, Momo Yaoyorozu, Tsuyu Asui, Mina Ashido', 1),
('Quel manga se déroule dans le monde des alchimistes et suit les frères Elric ?', 'Fullmetal Alchemist, One Piece, Fairy Tail, Bleach', 1),
('Dans \'Hunter x Hunter\', quel est le nom du meilleur ami de Gon ?', 'Kurapika, Leorio, Hisoka, Killua', 4),
('Quel manga met en scène un jeune homme nommé Eren Jaeger qui veut éliminer tous les titans ?', 'Attack on Titan, Naruto, Dragon Ball, One Punch Man', 1);

INSERT INTO quizs_questions (id_quizs, id_questions) VALUES
(1, 1), 
(1, 2), 
(1, 3), 
(1, 4), 
(1, 5), 
(2, 6), 
(2, 7), 
(2, 8), 
(2, 9), 
(2, 10), 
(2, 11), 
(2, 12), 
(2, 13), 
(2, 14), 
(2, 15), 
(3, 16), 
(3, 17), 
(3, 18), 
(3, 19), 
(3, 20), 
(3, 21), 
(3, 22), 
(3, 23), 
(3, 24), 
(3, 25), 
(4, 26), 
(4, 27), 
(4, 28), 
(4, 29), 
(4, 30), 
(4, 31), 
(4, 32), 
(4, 33), 
(4, 34), 
(4, 35);