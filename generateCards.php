<?php
function getValidFirstDigits($cardType){
    $values = array(
        'visa' => array('4'),
        'master' => array('51', '52', '53', '54', '55'),
        'diners' => array('36', '36'),
        'discover' => array('6011', '65'),
        'jcb' => array('35'),
        'american' => array('34', '37')
    );

    if($cardType == 'random'){
        $firstDigits = $values[array_rand($values)];
    }else{ 
        $firstDigits = $values[$cardType];
    }

    $randomArrayIndex = rand((int) $firstDigits,count($firstDigits)) -1;
    $firstDigits = $firstDigits[$randomArrayIndex];
    return $firstDigits;
}

function convertToSumOfMultiplication($value){
    if($value > 4){
        $value = ($value * 2) - 10 + 1;
    }else{
        $value *= 2;
    }

    return $value;
}

function fillTheLastCheckDigit($string){
    $oddPositions = 0;
    $evenPositions = 0;

    for($x =0; $x < strlen($string); $x++){
        if($x % 2 == 0){
            $oddPositions += convertToSumOfMultiplication($string[$x]);
        }else{
            $evenPositions += $string[$x];
        }
    }

    $lastDigit = (10 - (($oddPositions + $evenPositions) % 10)) % 10;
    $string[strlen($string)] = $lastDigit;

    return $string;
}

function RandomNumberString($length)
{
    $characters = '0123456789';
    $randstring = '';

    for ($i = 0; $i < $length; $i++) {
        $randstring .= $characters[rand(0, strlen($characters) -1)];
    }

    return $randstring;
}

function generateValidCard($cardType, $results = 1){
    $arrayOfCards = array();

    for($x = 0; $x < $results; $x++){
        $random15Numbers = RandomNumberString(15);
        $firstDigits = getValidFirstDigits($cardType);
        $random15Numbers = substr_replace($random15Numbers, $firstDigits, 0, strlen($firstDigits));
        $arrayOfCards[] = fillTheLastCheckDigit($random15Numbers);
    }
    
    return json_encode($arrayOfCards);
}

echo generateValidCard('random', 10);




















