<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * DoctrineMigrationVersions
 *
 * @ORM\Table(name="doctrine_migration_versions")
 * @ORM\Entity
 */
class DoctrineMigrationVersions
{
    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=191, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $version;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="executed_at", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $executedAt = 'NULL';

    /**
     * @var int|null
     *
     * @ORM\Column(name="execution_time", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $executionTime = NULL;


}
