<?php

namespace App\Repository\Models;

class UserRegistrationModel
{

    private string $name;
    private string $email;
    private string $phoneNumber;
    private string $password;

    /**
     * @param String $name
     * @param String $email
     * @param String $phoneNumber
     * @param String $password
     */
    public function __construct(string $name, string $email, string $phoneNumber, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->password = $password;
    }

    /**
     * @return String
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return String
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return String
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @return String
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
