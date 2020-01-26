<?php
declare(strict_types = 1);

namespace myframe\core\components\user;

/**
 * Интерфейс содержащий методы обязательные к реализации
 * в классе работающим с регистрацией/авторизацией.
 */
interface UserIdentityInterface
{
    public function getId(): int;

    public function isGuest(): bool;

    public function setPassword(string $password): void;

    public function validatePassword(string $password): bool;

    public static function getByEmail(string $email): object;

    public static function getByLogin(string $login): object;

    public function generateAuthKey(): string;

    public function login(): bool;

    public function logout(): bool;

    public function signUp(): bool;
}
