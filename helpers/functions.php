<?php


function getInitials($firstname, $middlename) {
    $initials = '';
    if (!empty($firstname)) {
        $initials .= mb_substr($firstname, 0, 1, 'UTF-8') . '.';
    }
    if (!empty($middlename)) {
        $initials .= mb_substr($middlename, 0, 1, 'UTF-8') . '.';
    }
    return $initials;
}


function calculateAge($birthdate) {
    if (empty($birthdate) || $birthdate === '0000-00-00') {
        return '—';
    }
    
    $birthDate = new DateTime($birthdate);
    $today = new DateTime('today');
    $age = $birthDate->diff($today)->y;
    

    $lastDigit = $age % 10;
    $lastTwoDigits = $age % 100;
    
    if ($lastTwoDigits >= 11 && $lastTwoDigits <= 14) {
        return $age . ' лет';
    }
    
    if ($lastDigit == 1) {
        return $age . ' год';
    }
    
    if ($lastDigit >= 2 && $lastDigit <= 4) {
        return $age . ' года';
    }
    
    return $age . ' лет';
}


function getZodiacSign($birthdate) {
    if (empty($birthdate) || $birthdate === '0000-00-00') {
        return '—';
    }
    
    $month = (int)date('m', strtotime($birthdate));
    $day = (int)date('d', strtotime($birthdate));
    
    if (($month == 1 && $day >= 20) || ($month == 2 && $day <= 18)) return '♒ Водолей';
    if (($month == 2 && $day >= 19) || ($month == 3 && $day <= 20)) return '♓ Рыбы';
    if (($month == 3 && $day >= 21) || ($month == 4 && $day <= 19)) return '♈ Овен';
    if (($month == 4 && $day >= 20) || ($month == 5 && $day <= 20)) return '♉ Телец';
    if (($month == 5 && $day >= 21) || ($month == 6 && $day <= 20)) return '♊ Близнецы';
    if (($month == 6 && $day >= 21) || ($month == 7 && $day <= 22)) return '♋ Рак';
    if (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)) return '♌ Лев';
    if (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)) return '♍ Дева';
    if (($month == 9 && $day >= 23) || ($month == 10 && $day <= 22)) return '♎ Весы';
    if (($month == 10 && $day >= 23) || ($month == 11 && $day <= 21)) return '♏ Скорпион';
    if (($month == 11 && $day >= 22) || ($month == 12 && $day <= 21)) return '♐ Стрелец';
    if (($month == 12 && $day >= 22) || ($month == 1 && $day <= 19)) return '♑ Козерог';
    
    return '—';
}

function dd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

function redirect($url) {
    header("Location: $url");
    exit();
}
?>