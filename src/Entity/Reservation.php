<?php


namespace App\Entity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Client;
/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="pk", columns={"idclient"}), @ORM\Index(name="terr", columns={"idterrain"})})
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="numresv", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numresv;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateresv", type="date", nullable=false)
     */
    private $dateresv;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heuerdeb", type="time", nullable=false)
     */
    private $heuerdeb;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heuerfin", type="time", nullable=false)
     */
    private $heuerfin;

    /**
     * @var string
     *
     * @ORM\Column(name="statue", type="string", length=25, nullable=false)
     */
    private $statue;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idclient", referencedColumnName="cin")
     * })
     */
    private $idclient;

    /**
     * @var \Terrain
     *
     * @ORM\ManyToOne(targetEntity="Terrain")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idterrain", referencedColumnName="idterrain")
     * })
     */
    private $idterrain;

    public function getNumresv(): ?int
    {
        return $this->numresv;
    }

    public function getDateresv(): ?\DateTimeInterface
    {
        return $this->dateresv;
    }

    public function setDateresv(\DateTimeInterface $dateresv): self
    {
        $this->dateresv = $dateresv;

        return $this;
    }

    public function getHeuerdeb(): ?\DateTimeInterface
    {
        return $this->heuerdeb;
    }

    public function setHeuerdeb(\DateTimeInterface $heuerdeb): self
    {
        $this->heuerdeb = $heuerdeb;

        return $this;
    }

    public function getHeuerfin(): ?\DateTimeInterface
    {
        return $this->heuerfin;
    }

    public function setHeuerfin(\DateTimeInterface $heuerfin): self
    {
        $this->heuerfin = $heuerfin;

        return $this;
    }

    public function getStatue(): ?string
    {
        return $this->statue;
    }

    public function setStatue(string $statue): self
    {
        $this->statue = $statue;

        return $this;
    }

    public function getIdclient(): ?Client
    {
        return $this->idclient;
    }

    public function setIdclient(?Client $idclient): self
    {
        $this->idclient = $idclient;

        return $this;
    }

    public function getIdterrain(): ?Terrain
    {
        return $this->idterrain;
    }

    public function setIdterrain(?Terrain $idterrain): self
    {
        $this->idterrain = $idterrain;

        return $this;
    }


}
