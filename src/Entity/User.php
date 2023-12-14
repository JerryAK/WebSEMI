<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $User_Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Password = null;

    #[ORM\Column(length: 255)]
    private ?string $Email = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Review::class)]
    private Collection $ProductReviews;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Review::class)]
    private Collection $Reviews;

    public function __construct()
    {
        $this->ProductReviews = new ArrayCollection();
        $this->Reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->User_Name;
    }

    public function setUserName(string $User_Name): static
    {
        $this->User_Name = $User_Name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): static
    {
        $this->Password = $Password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * @return Collection<int, tReview>
     */
    public function getProductReviews(): Collection
    {
        return $this->ProductReviews;
    }

    public function addProductReview(Review $productReview): static
    {
        if (!$this->ProductReviews->contains($productReview)) {
            $this->ProductReviews->add($productReview);
            $productReview->setUser($this);
        }

        return $this;
    }

    public function removeProductReview(Review $productReview): static
    {
        if ($this->ProductReviews->removeElement($productReview)) {
            // set the owning side to null (unless already changed)
            if ($productReview->getUser() === $this) {
                $productReview->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->Reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->Reviews->contains($review)) {
            $this->Reviews->add($review);
            $review->setUser($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->Reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUser() === $this) {
                $review->setUser(null);
            }
        }

        return $this;
    }
}
