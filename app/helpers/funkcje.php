<?php
    require_once '../app/models/User.php';
    function walidacja() {
    // Tablica filtrów dla poszczególnych pól formularza
    $args = [

        'username' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => '/^[A-Za-z0-9_]{3,20}$/'
            ]
        ],

        'age' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range' => 1, 'max_range' => 99]
        ],

        'password' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/'
            ]
        ],

        'first_name' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => '/^[A-ZĄĆĘŁŃÓŚŹŻ][a-ząćęłńóśźż-]{1,25}$/'
            ]
        ],

        'last_name' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => '/^[A-ZĄĆĘŁŃÓŚŹŻ][a-ząćęłńóśźż-]{1,25}$/'
            ]
        ],

        'phone' => [
            'filter' => FILTER_VALIDATE_REGEXP,
                'options' => [
                    'regexp' => '/^\+?[0-9\s\-]{7,20}$/'
                ]
        ],

        'email' => FILTER_VALIDATE_EMAIL
    ];


    // Przefiltruj dane z formularza metodą POST zgodnie z regułami powyżej
    $dane = filter_input_array(INPUT_POST, $args);

    // Wyświetl tablicę przefiltrowanych danych (pomoc diagnostyczna)
    //var_dump($dane);

    // Sprawdź, czy któreś pole jest niepoprawne (false lub NULL)
    $errors = "";
    foreach ($dane as $key => $val) {
        if ($val === false or $val === NULL) {
            $errors .= $key . " ";
        }
    }
    $user = null;
    // Jeśli nie ma błędów — dane są poprawne
    if ($errors === "") {
        // Zapisz dane do pliku dane.txt
        $user = new User(
            $dane['username'],
            $dane['first_name'],
            $dane['last_name'],
            $dane['age'],
            $dane['phone'],
            $dane['email'],
            $dane['password'],
            false
        );
    } else {
        // W przeciwnym wypadku — pokaż błędy użytkownikowi
        echo "<br>Niepoprawne dane w polach: " . $errors;
        $user = null;
        
    }
    return $user;
}
?>