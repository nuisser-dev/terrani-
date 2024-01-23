<?php


namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Terrain
 *
 * @ORM\Table(name="terrain", indexes={@ORM\Index(name="resp", columns={"idresp"})})
 * @ORM\Entity
 */
class Terrain
{
    /**
     * @var int
     *
     * @ORM\Column(name="idterrain", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idterrain;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=25, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=25, nullable=false)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="statue", type="string", length=25, nullable=false)
     */
    private $statue;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=25, nullable=false)
     */
    private $adresse;

    /**
     * @var \Responsable
     *
     * @ORM\ManyToOne(targetEntity="Responsable")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idresp", referencedColumnName="cin")
     * })
     */
    private $idresp;

    public function getIdterrain(): ?int
    {
        return $this->idterrain;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getIdresp(): ?Responsable
    {
        return $this->idresp;
    }

    public function setIdresp(?Responsable $idresp): self
    {
        $this->idresp = $idresp;

        return $this;
    }


}
