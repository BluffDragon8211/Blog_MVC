<?php
    namespace BlogMvc\Models;

    class Article{
        private int $Id;
        private string $Titre;
        private string $Description;
        private string $Image;
        private string $Date;
        private string $Auteur;
        private string $AuteurName;

        //Accesseurs

        public function getId(): int {
            return $this->Id;
        }

        public function setId(int $id): void {
            $this->Id = $id;
        }

        public function getTitre(): string {
            return $this->Titre;
        }

        public function setTitre(string $titre): void {
            $this->Titre = $titre;
        }

        public function getDescription(): string {
            return $this->Description;
        }

        public function setDescription(string $description): void {
            $this->Description = $description;
        }

        public function getImage(): string {
            return $this->Image;
        }

        public function setImage(string $image): void {
            $this->Image = $image;
        }

        public function getDate(): string {
            return $this->Date;
        }

        public function setDate(string $date): void {
            $this->Date = $date;
        }

        public function getAuteur(): string {
            return $this->Auteur;
        }

        public function setAuteur(string $auteur): void {
            $this->Auteur = $auteur;
        }

        public function getAuteurName(): string {
            return $this->AuteurName;
        }

        public function setAuteurName(string $name): void {
            $this->AuteurName = $name;
        }
    }
?>