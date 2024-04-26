<?php

if (!defined('DATABASE_PATH')) {
    define('DATABASE_PATH', __DIR__ . '/BD.sqlite3');
}



date_default_timezone_set('Europe/Paris');
try {
    $file_db = new PDO('sqlite:' . DATABASE_PATH);
    $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $file_db->exec("CREATE TABLE IF NOT EXISTS utilisateur( 
        ID_Utilisateur INTEGER PRIMARY KEY AUTOINCREMENT,
        Nom_Utilisateur TEXT,
        Mot_de_Passe TEXT,
        Email TEXT,
        Id_role INTEGER)");

    $file_db->exec("CREATE TABLE IF NOT EXISTS Playlist( 
        ID_Playlist INTEGER PRIMARY KEY AUTOINCREMENT,
        Titre_Playlist TEXT,
        ID_Utilisateur INTEGER,
        FOREIGN KEY (ID_Utilisateur) REFERENCES utilisateur(ID_Utilisateur))");

    $file_db->exec("CREATE TABLE IF NOT EXISTS Artiste( 
        ID_Artiste INTEGER PRIMARY KEY AUTOINCREMENT,
        Nom_Artiste TEXT,
        Biographie TEXT,
        Photo TEXT)");

    $file_db->exec("CREATE TABLE IF NOT EXISTS Titre( 
        ID_Titre INTEGER PRIMARY KEY AUTOINCREMENT,
        Nom_Titre TEXT,
        Photo TEXT,
        Duree INTEGER,
        Lien TEXT,
        ID_Album INTEGER,
        ID_Artiste INTEGER,
        FOREIGN KEY (ID_Album) REFERENCES Album(ID_Album),
        FOREIGN KEY (ID_Artiste) REFERENCES Artiste(ID_Artiste))");

    
    $file_db->exec("CREATE TABLE IF NOT EXISTS Album(
        ID_Album INTEGER PRIMARY KEY AUTOINCREMENT,
        Titre_Album TEXT,
        Année_de_sortie INTEGER,
        Genre TEXT,
        ID_Artiste INTEGER,
        Pochette TEXT,
        FOREIGN KEY (ID_Artiste) REFERENCES Artiste(ID_Artiste))");
    
    $file_db->exec("CREATE TABLE IF NOT EXISTS NoteAlbum( 
        ID_Album INTEGER,
        ID_Utilisateur INTEGER,
        Note INTEGER,
        PRIMARY KEY (ID_Album, ID_Utilisateur),
        FOREIGN KEY (ID_Album) REFERENCES Album(ID_Album),
        FOREIGN KEY (ID_Utilisateur) REFERENCES utilisateur(ID_Utilisateur))");
    
    $file_db->exec("CREATE TABLE IF NOT EXISTS TitrePlaylist( 
        ID_Titre INTEGER,
        ID_Playlist INTEGER,
        PRIMARY KEY (ID_Titre, ID_Playlist),
        FOREIGN KEY (ID_Titre) REFERENCES Titre(ID_Titre),
        FOREIGN KEY (ID_Playlist) REFERENCES Playlist(ID_Playlist))");



} catch (PDOException $ex) {
    echo "Erreur de connexion à la base de données : " . $ex->getMessage();
}
?>