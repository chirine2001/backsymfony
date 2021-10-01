<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210930110500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD image_id INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC3DA5256D FOREIGN KEY (image_id) REFERENCES scan (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC3DA5256D ON commentaire (image_id)');
        $this->addSql('ALTER TABLE scan ADD manga_id INT NOT NULL');
        $this->addSql('ALTER TABLE scan ADD CONSTRAINT FK_C4B3B3AE7B6461 FOREIGN KEY (manga_id) REFERENCES manga (id)');
        $this->addSql('CREATE INDEX IDX_C4B3B3AE7B6461 ON scan (manga_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC3DA5256D');
        $this->addSql('DROP INDEX IDX_67F068BC3DA5256D ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP image_id');
        $this->addSql('ALTER TABLE scan DROP FOREIGN KEY FK_C4B3B3AE7B6461');
        $this->addSql('DROP INDEX IDX_C4B3B3AE7B6461 ON scan');
        $this->addSql('ALTER TABLE scan DROP manga_id');
    }
}
