<?php
    namespace BlogMvc\Models;

    class Article{
        private $Id;
        private $Titre;
        private $Description;
        private $Image;
        private $Date;
        private $Auteur;
        private $auteurName;

        public function getId() {
            return $this->Id;
        }

        public function setId($id) {
            $this->Id = $id;
        }

        public function getTitre() {
            return $this->Titre;
        }

        public function setTitre($titre) {
            $this->Titre = $titre;
        }

        public function getDescription() {
            return $this->Description;
        }

        public function setDescription($description) {
            $this->Description = $description;
        }

        public function getImage() {
            return $this->Image;
        }

        public function setImage($image) {
            $this->Image = $image;
        }

        public function getDate() {
            return $this->Date;
        }

        public function setDate($date) {
            $this->Date = $date;
        }

        public function getAuteur() {
            return $this->Auteur;
        }

        public function setAuteur($auteur) {
            $this->Auteur = $auteur;
        }

        public function getAuteurName() {
            return $this->auteurName;
        }

        public function setAuteurName($name) {
            $this->auteurName = $name;
        }
    }
?>