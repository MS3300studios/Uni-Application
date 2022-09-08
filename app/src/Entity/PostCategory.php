<?php
/**
 *
 * PostCategory
 *
 */
namespace App\Entity;

use App\Repository\PostCategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * Class PostCategory.
 *
 */
#[ORM\Entity(repositoryClass: PostCategoryRepository::class)]
#[ORM\Table(name: 'postCategories')]
#[ORM\UniqueConstraint(name: 'uq_postCategories_name', columns: ['name'])]
#[UniqueEntity(fields: ['name'])]
class PostCategory
{
    /**
     * Primary Key.
     *
     * @var int|null
     *
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Created At.
     *
     * @var DateTimeImmutable|null
     *
     */
    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\Type(DateTimeImmutable::class)]
    #[Gedmo\Timestampable(on: 'create')]
    private ?DateTimeImmutable $createdAt;

    /**
     * Name.
     *
     * @var string|null
     *
     */
    #[ORM\Column(type: 'string', length: 64)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 64)]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]+$/',
    )]
    private ?string $name;

    /**
     * Getter for Id.
     *
     * @return int|null
     *
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Created At.
     *
     * @return DateTimeImmutable|null
     *
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Setter for Created At.
     *
     * @param DateTimeImmutable $createdAt
     *
     * @return void
     *
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for Name.
     *
     * @return string|null
     *
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter For Name.
     *
     * @param string $name
     *
     * @return void
     *
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
