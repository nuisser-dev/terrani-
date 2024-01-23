<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230430151524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE cin cin INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY pk');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY terr');
        $this->addSql('ALTER TABLE reservation DROP heuerdeb, DROP heuerfin, DROP statue, CHANGE idterrain idterrain INT DEFAULT NULL, CHANGE idclient idclient INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955177201DF FOREIGN KEY (idterrain) REFERENCES terrain (idterrain)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A3F9A9F9 FOREIGN KEY (idclient) REFERENCES client (cin)');
        $this->addSql('ALTER TABLE responsable CHANGE cin cin INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE terrain DROP FOREIGN KEY resp');
        $this->addSql('ALTER TABLE terrain ADD dateouvert DATE NOT NULL, ADD dataferm DATE NOT NULL, DROP statue, CHANGE idterrain idterrain INT AUTO_INCREMENT NOT NULL, CHANGE idresp idresp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE terrain ADD CONSTRAINT FK_C87653B129B61469 FOREIGN KEY (idresp) REFERENCES responsable (cin)');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE cin cin INT NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955177201DF');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A3F9A9F9');
        $this->addSql('ALTER TABLE reservation ADD heuerdeb TIME NOT NULL, ADD heuerfin TIME NOT NULL, ADD statue VARCHAR(25) NOT NULL, CHANGE idterrain idterrain INT NOT NULL, CHANGE idclient idclient INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT pk FOREIGN KEY (idclient) REFERENCES client (cin) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT terr FOREIGN KEY (idterrain) REFERENCES terrain (idterrain) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE responsable CHANGE cin cin INT NOT NULL');
        $this->addSql('ALTER TABLE terrain DROP FOREIGN KEY FK_C87653B129B61469');
        $this->addSql('ALTER TABLE terrain ADD statue VARCHAR(25) NOT NULL, DROP dateouvert, DROP dataferm, CHANGE idterrain idterrain INT NOT NULL, CHANGE idresp idresp INT NOT NULL');
        $this->addSql('ALTER TABLE terrain ADD CONSTRAINT resp FOREIGN KEY (idresp) REFERENCES responsable (cin) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
