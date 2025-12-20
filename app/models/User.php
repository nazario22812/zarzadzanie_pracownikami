<?php
class User {
    const STATUS_USER = 1;
    const STATUS_ADMIN = 2;
    protected $userName;
    protected $passwd;
    protected $email;
    protected $firstName;
    protected $lastName;
    protected $wiek;
    protected $phone;
    protected $date;
    protected $status; 

    function __construct($userName, $firstName, $lastName, $wiek, $phone,$email ,$passwd) {
        $this->userName = $userName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->wiek = $wiek;
        $this->phone = $phone;
        $this->passwd = password_hash( $passwd, PASSWORD_DEFAULT);
        $this->email = $email;

        $this->date = date("Y-m-d");
        $this->status = User::STATUS_USER;
    }   

    public function show() {
        echo "User Name: " . $this->userName . "<br>";
        echo "Full Name: " . $this->firstName . " " . $this->lastName . "<br>";
        echo "Wiek: " . $this->wiek . "<br>";
        echo "Phone: " . $this->phone . "<br>";
        echo "Email: " . $this->email . "<br>";
        echo "Date: " . $this->date . "<br>";
        echo "Status: " . ($this->status == User::STATUS_ADMIN ? "Admin" : "User") . "<br>";
        echo "Password: " . $this->passwd . "<br>";
    }

    public function setUserName($userName) {
        $this->userName = $userName;
    }
    public function getUserName() {
        return $this->userName;
    }
    public function setPasswd($passwd) {
        $this->passwd = password_hash( $passwd, PASSWORD_DEFAULT);
    }
    public function getPasswd() {
        return $this->passwd;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function getEmail() {
        return $this->email;
    }
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }
    public function getFirstName() {
        return $this->firstName;
    }
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }
    public function getLastName() {
        return $this->lastName;
    }
    public function setWiek($wiek) {
        $this->wiek = (int)$wiek;
    }
    public function getWiek() {
        return $this->wiek;
    }
    public function setPhone($phone) {
        $this->phone = $phone;
    }
    public function getPhone() {
        return $this->phone;
    }
    public function setDate($date) {
        $this->date = $date;
    }
    public function getDate() {
        return $this->date;
    }
    public function setStatus($status) {
        $this->status = (int)$status;
    }
    public function getStatus() {
        return $this->status;
    }
}
?>