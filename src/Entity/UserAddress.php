<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class UserAddress
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *
     */
    private $userId;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $homeId;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $porch;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $floor;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $intercom;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $apartment;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="addresses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Home::class, inversedBy="addresses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $home;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getHomeId(): ?int
    {
        return $this->homeId;
    }

    public function setHomeId(int $homeId): self
    {
        $this->homeId = $homeId;

        return $this;
    }

    public function getPorch(): ?int
    {
        return $this->porch;
    }

    public function setPorch(?int $porch): self
    {
        $this->porch = $porch;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(?int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getIntercom(): ?int
    {
        return $this->intercom;
    }

    public function setIntercom(?int $intercom): self
    {
        $this->intercom = $intercom;

        return $this;
    }

    public function getApartment(): ?int
    {
        return $this->apartment;
    }

    public function setApartment(?int $apartment): self
    {
        $this->apartment = $apartment;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getHome(): ?Home
    {
        return $this->home;
    }

    public function setHome(?Home $home): self
    {
        $this->home = $home;

        return $this;
    }
}
