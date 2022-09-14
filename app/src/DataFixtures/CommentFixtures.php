<?php
/**
 * CommentFixtures.
 */

namespace App\DataFixtures;

use App\Entity\Comment;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class CommentFixtures.
 */
class CommentFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load Data.
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }

        $this->createMany(200, 'comments', function (int $i) {
            $comment = new Comment();
            $comment->setNick($this->faker->name());
            $comment->setCreatedAt(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $comment->setContent($this->faker->text(150));
            $post = $this->getRandomReference('posts');
            $comment->setPost($post);
            $comment->setEmail($this->faker->email());

            return $comment;
        });

        $this->manager->flush();
    }

    /**
     * Get Dependencies.
     *
     * @return string[] returns dependencies array
     */
    public function getDependencies(): array
    {
        return [PostFixtures::class];
    }
}
