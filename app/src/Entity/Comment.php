<?php
/**
 * Comment Entity
 */
namespace App\Entity;

use App\Repository\CommentRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Comment.
 */
#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    /**
     * Primary Key.
     *
     * @var int|null id
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * Email.
     *
     * @var string|null email
     */
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private $email;

    /**
     * nick.
     *
     * @var string|null nick
     */
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $nick;

    /**
     * content.
     *
     * @var string|null content
     */
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $content;

    /**
     * createdAt.
     *
     * @var DateTimeImmutable|null createdAt
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    /**
     * Post.
     *
     * @var Post|null post
     */
    #[ORM\ManyToOne(targetEntity: Post::class, fetch: 'EXTRA_LAZY')]
    #[Assert\NotBlank]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    private ?Post $post = null;

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
     * Getter for email.
     *
     * @return string|null email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter for email.
     *
     * @param string $email email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Getter for Nick.
     *
     * @return string|null nick
     */
    public function getNick(): ?string
    {
        return $this->nick;
    }

    /**
     * Setter for nick.
     *
     * @param string $nick nick
     */
    public function setNick(string $nick)
    {
        $this->nick = $nick;
    }

    /**
     * Getter for Content.
     *
     * @return string|null Content
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Setter for content.
     *
     * @param string $content content
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
     * @param DateTimeImmutable $createdAt createdAt
     */
    public function setCreatedAt(DateTimeImmutable $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for getPost.
     *
     * @return Post|null getPost
     */
    public function getPost(): ?Post
    {
        return $this->post;
    }

    /**
     * Setter for Post.
     *
     * @param Post $post Post
     */
    public function setPost(?Post $post): void
    {
        $this->post = $post;
    }
}
