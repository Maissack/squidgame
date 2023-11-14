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

// Boucle principale du jeu
foreach ($opponents as $opponent) {
    $remainingMarbles = $selectedPlayer->marbles;

    // Affiche le nombre de billes restantes du joueur sélectionné
    echo "Billes restantes de {$selectedPlayer->name} : $remainingMarbles<br>";

    // Affiche les caractéristiques de l'adversaire
    echo "Affrontement avec {$opponent->name} qui a {$opponent->marbles} billes dans ses mains.<br>";

    // Vérifie si le joueur peut tricher
    if ($opponent->isCheatable() && rand(0, 1)) {
        // Le joueur décide de tricher
        $selectedPlayer->marbles += $opponent->marbles;
        echo "{$selectedPlayer->name} a triché et a remporté {$opponent->marbles} billes contre {$opponent->name}!<br><br>";
    } else {
        // Affrontement normal
        $isPlayerAlive = $selectedPlayer->playRound($opponent->marbles);

        if (!$isPlayerAlive) {
            echo "{$selectedPlayer->name} a perdu toutes ses billes et le jeu est terminé!<br><br>";
            break;
        }

        // Vérifie si le joueur a deviné correctement la parité des billes de l'adversaire
        $guessedEven = $selectedPlayer->makeGuess();
        $opponentIsEven = $opponent->marbles % 2 == 0;

        if ($guessedEven == $opponentIsEven) {
            // Le joueur a deviné correctement
            $selectedPlayer->marbles += $opponent->marbles + $selectedPlayer->gain;
            echo "{$selectedPlayer->name} a remporté {$opponent->marbles} billes contre {$opponent->name}!<br><br>";
        } else {
            // Le joueur n'a pas deviné correctement
            $selectedPlayer->marbles -= $opponent->marbles - $selectedPlayer->loss;
            echo "{$selectedPlayer->name} a perdu {$opponent->marbles} billes contre {$opponent->name}!<br><br>";
        }
    }

    // Vérifie si le joueur est toujours en vie après la partie
    if ($selectedPlayer->marbles <= 0) {
        echo "{$selectedPlayer->name} a perdu toutes ses billes et le jeu est terminé!<br><br>";
        break;
    }
}

?>
