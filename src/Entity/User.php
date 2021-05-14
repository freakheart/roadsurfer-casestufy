<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, \Serializable
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    private ?int $id = null;

    private ?string $username = null;

    private ?string $password = null;

    private array $roles = [self::ROLE_USER];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function eraseCredentials(): void
    {
    }

    public function serialize()
    {
        return \serialize([
            $this->id,
            $this->username,
            $this->password,
        ]);
    }

    public function unserialize($serialized)
    {
        [
            $this->id,
            $this->username,
            $this->password,
        ] = \unserialize($serialized, ['allowed_classes' => false]);
    }

    /**
     * @var string[]
     */
    public function setRoles(array $roles): void
    {
        if (!\in_array(self::ROLE_USER, $roles)) {
            \array_push($roles, self::ROLE_USER);
        }

        $this->roles = $roles;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}
