<?php
$n = $argv[1];

if (is_numeric($n)) {
    if ($n % 2 == 0) {
        exit ("Try again!");
    } elseif ($n >= 3) {
        $computer=rand(1, $n);
    } else {
        exit ("Try again!");
    }
} else {
    exit ("Try 3, 5, 7, 9...");
}

$n_minus = ($n-1)/2;
$n_plus = ($n+1)/2;
$random_key = random_bytes(256);
$hmac_key = hash('sha3-256', $random_key, false);
$hmac = hash_hmac('sha3-256', $computer, $hmac_key, false);

echo ("HMAC: $hmac\n");
m:
echo ("Available moves:\n 1 - rock \n 2 - paper \n 3 - scissors \n 4 - lizard \n 5 - spock \n 0 - exit \n ? - help\n");

p:
$player = readline("Enter your move:");
if (in_array($player, range(1, $n))) {
    echo "Computer move: $computer\n";
} elseif ($player == 0) {
    exit ("Exit");
} elseif ($player === "?") {
    for ($i = 0; $i <= ($n); $i++) {
        if ($i == 0) {
            echo "N     ";
        } else {
            echo $i, '     ';
        }
        for ($j = 0; $j <= ($n-1); $j++) {
            if ($i===0) {
                    echo $j+1, '     ';
            } elseif ($j+1 <= $n_plus) {
                if (in_array($i, range($j+2,$j+$n_minus+1))) {
                    echo "Lose  ";
                } elseif ($j+1 === $i) {
                    echo "Draw  ";
                } else {
                    echo "Win   ";
                }
            } else {
                if (in_array($i, range($j,$j-$n_minus+1))) {
                    echo "Win   ";
                } elseif ($j+1 === $i) {
                    echo "Draw  ";
                } else {
                    echo "Lose  ";
                }
            }
        }   
        echo "\n";
    }
    goto p;
} else {
    goto m;
}

if ($player <= $n_plus) {
    if (in_array($computer, range($player+1,$player+$n_minus))) {
        echo "Computer wins!\n";
    } elseif ($player == $computer) {
        echo "Draw\n";
    } else {
        echo "You win!\n";
    }
} else {
    if (in_array($computer, range($player-1,$player-$n_minus))) {
        echo "You win!\n";
    } elseif ($player == $computer) {
        echo "Draw\n";
    } else {
        echo "Computer wins!\n";
    }
}

echo ("HMAC-key: $hmac_key\n");
?>