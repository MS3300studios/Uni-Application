<?php
/**
 * Post entity
 */
namespace App\Entity;

use App\Repository\PostRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class Post
 */
#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    /**
     * Primary Key.
     *
     * @var int|null Id
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * Title.
     *
     * @var string|null title
     */
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $title = null;

    /**
     * Content.
     *
     * @var string|null content
     */
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $content = null;

    /**
     * CreatedAt.
     *
     * @var DateTimeImmutable|null CreatedAt
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    /**
     * PostCategory.
     *
     * @var PostCategory|null post category
     */
    #[ORM\ManyToOne(targetEntity: PostCategory::class, fetch: 'EXTRA_LAZY')]
    #[Assert\NotBlank]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?PostCategory $postCategory = null;

    /**
     * Getter for id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for title.
     *
     * @return string|null title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for title.
     *
     * @param string|null $title title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * Getter for content.
     *
     * @return string|null content
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Setter for content.
     *
     * @param string|null $content content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * Getter for createdAt.
     *
     * @return DateTimeImmutable|null createdAt
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Setter for createdAt.
     *
     * @param DateTimeImmutable|null $createdAt createAt
     */
    public function setCreatedAt(DateTimeImmutable $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for post category.
     *
     * @return PostCategory|null post category
     */
    public function getPostCategory(): ?PostCategory
    {
        return $this->postCategory;
    }

    /**
     * Setter for post category.
     *
     * @param PostCategory|null $postCategory post category
     */
    public function setPostCategory(?PostCategory $postCategory): void
    {
        $this->postCategory = $postCategory;
    }
}
