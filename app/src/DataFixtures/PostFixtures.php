<?php
/**
 * PostFixtures.
 */

namespace App\DataFixtures;

use App\Entity\Post;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class PostFixtures.
 */
class PostFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load Data.
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }

        $this->createMany(100, 'posts', function (int $i) {
            $post = new Post();
            $post->setTitle($this->faker->sentence);
            $post->setCreatedAt(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );

            $post->setContent($this->faker->text(150));

            $postCategory = $this->getRandomReference('postCategories');
            $post->setPostCategory($postCategory);

            return $post;
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
        return [PostCategoryFixtures::class];
    }
}
