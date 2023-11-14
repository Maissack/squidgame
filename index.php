<?php

class Player {
    public $name; // Nom du joueur
    public $marbles; // Nombre de billes
    public $loss; // Nombre de billes perdues en cas de défaite
    public $gain; // Nombre de billes gagnées en cas de victoire
    public $scream_war; // Cri de guerre du joueur
    public $difficulty; // Niveau de difficulté du joueur

    public function __construct($name, $marbles, $loss, $gain, $scream_war, $difficulty) {
        $this->name = $name;
        $this->marbles = $marbles;
        $this->loss = $loss;
        $this->gain = $gain;
        $this->scream_war = $scream_war;
        $this->difficulty = $difficulty;
    }

    public function playRound($opponentMarbles) {
        // Détermine si le nombre de billes de l'adversaire est pair ou impair
        $opponentIsEven = $opponentMarbles % 2 == 0;

        // Détermine si le joueur a deviné correctement
        $guessIsCorrect = $this->makeGuess();

        // Met à jour le nombre de billes du joueur en fonction du résultat
        if ($guessIsCorrect) {
            $this->marbles += $opponentMarbles + $this->gain;
            echo "{$this->name} remporte la victoire avec {$this->scream_war}!<br><br>";
        } else {
            $this->marbles -= $opponentMarbles - $this->loss;
            echo "{$this->name} subit une défaite! L'adversaire avait $opponentMarbles billes.<br><br>";
        }

        // Retourne si le joueur a au moins une bille restante
        return $this->marbles > 0;
    }

    public function makeGuess() {
        // Implémente la logique pour que le joueur fasse une supposition (pair ou impair)
        // Cela pourrait être fait de manière aléatoire ou à travers une certaine stratégie
        return (bool)rand(0, 1);
    }
}

class Opponent {
    public $name; // Nom de l'adversaire
    public $marbles; // Nombre de billes de l'adversaire
    public $age; // Âge de l'adversaire

    public function __construct($name, $marbles, $age) {
        $this->name = $name;
        $this->marbles = $marbles;
        $this->age = $age;
    }

    public function isCheatable() {
        // Détermine si l'adversaire peut être trompé en fonction de l'âge
        return $this->age > 70;
    }
}

// Tableau des niveaux de difficulté
$difficulties = ["Facile" => 5, "Difficile" => 10, "Impossible" => 20];

// Choix aléatoire d'un niveau de difficulté
$selectedDifficulty = array_rand($difficulties);
$numberOfRounds = $difficulties[$selectedDifficulty];

// Choix aléatoire d'un personnage
$characters = [
    new Player("Seong Gi-hun", 15, 2, 1, "Squid Game!", "Difficile"),
    new Player("Kang Sae-byeok", 25, 1, 2, "Red light, green light!", "Moyen"),
    new Player("Cho Sang-woo", 35, 0, 3, "I'm the mastermind.", "Facile"),
];

$selectedPlayer = $characters[array_rand($characters)];

// Tableau des adversaires
$opponents = [];
for ($i = 1; $i <= 20; $i++) {
    $opponents[] = new Opponent("Adversaire $i", rand(1, 20), rand(18, 80));
}

// Affiche le niveau de difficulté, le joueur sélectionné, et le nombre de parties
echo "Niveau de difficulté : $selectedDifficulty<br>";
echo "Personnage sélectionné aléatoirement : {$selectedPlayer->name}<br>";
echo "Nombre de niveaux : $numberOfRounds<br><br>";

?>
