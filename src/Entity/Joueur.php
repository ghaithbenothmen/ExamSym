<?php

namespace App\Entity;

use App\Repository\JoueurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JoueurRepository::class)]
class Joueur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $equipe = null;

    #[ORM\OneToMany(mappedBy: 'joueur', targetEntity: Vote::class)]
    private Collection $votes;

    #[ORM\Column]
    private ?float $moyenneVote = null;

    public function __construct()
    {
        $this->votes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEquipe(): ?string
    {
        return $this->equipe;
    }

    public function setEquipe(string $equipe): static
    {
        $this->equipe = $equipe;

        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getvotes(): Collection
    {
        return $this->votes;
    }

    public function addvotes(Vote $votes): static
    {
        if (!$this->votes->contains($votes)) {
            $this->votes->add($votes);
            $votes->setJoueur($this);
        }

        return $this;
    }

    public function removevotes(Vote $votes): static
    {
        if ($this->votes->removeElement($votes)) {
            // set the owning side to null (unless already changed)
            if ($votes->getJoueur() === $this) {
                $votes->setJoueur(null);
            }
        }

        return $this;
    }

    public function getMoyenneVote(): ?float
    {
        return $this->moyenneVote;
    }

    public function setMoyenneVote(float $moyenneVote): static
    {
        $this->moyenneVote = $moyenneVote;

        return $this;
    }
}
