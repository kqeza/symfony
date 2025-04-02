<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Фамилия не должна быть пустой.")]
    #[Assert\Length(min: 2, max: 100, minMessage: "Фамилия должна содержать минимум {{ limit }} символа.")]
    private ?string $last_name = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Имя не должно быть пустым.")]
    #[Assert\Length(min: 2, max: 100, minMessage: "Имя должно содержать минимум {{ limit }} символа.")]
    private ?string $first_name = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Возраст обязателен.")]
    #[Assert\Type(type: 'integer', message: "Возраст должен быть числом.")]
    #[Assert\Range(min: 18, max: 99, notInRangeMessage: "Возраст должен быть от {{ min }} до {{ max }} лет.")]
    private ?int $age = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $status = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: "Email обязателен.")]
    #[Assert\Email(message: "Некорректный email.")]
    private ?string $email = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(max: 50, maxMessage: "Telegram никнейм не должен превышать {{ limit }} символов.")]
    private ?string $telegram = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Адрес обязателен.")]
    private ?string $address = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Department $department = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $icon;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelegram(): ?string
    {
        return $this->telegram;
    }

    public function setTelegram(string $telegram): static
    {
        $this->telegram = $telegram;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): static
    {
        $this->department = $department;

        return $this;
    }
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }
}
