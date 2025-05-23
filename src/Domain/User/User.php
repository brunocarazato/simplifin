<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\Exception\InsufficientFundsException;

abstract class User
{

    protected ?int $id;
    protected string $name;
    protected string $cpfCnpj;
    protected string $email;
    protected string $password;
    protected float $balance;

    public function __construct(?int $id, string $name, string $cpfCnpj, string $email, float $balance = 0.0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cpfCnpj = $cpfCnpj;
        $this->email = $email;
        $this->balance = $balance;
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getcpfCpnj(): string
    {
        return $this->cpfCnpj;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function credit(float $amount): void {
        $this->balance += $amount;
    }

    public function debit(float $amount): void {
        if ($this->balance < $amount) {
            throw new InsufficientFundsException();
        }
        $this->balance -= $amount;
    }

    abstract public function canTransfer(): bool;


}
