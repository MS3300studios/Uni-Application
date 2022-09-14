<?php
/**
 * PostCategoryFixtures.
 */

namespace App\DataFixtures;

use App\Entity\PostCategory;
use DateTimeImmutable;

/**
 * Class PostCategoryFixtures.
 */
class PostCategoryFixtures extends AbstractBaseFixtures
{
    /**
     * Load Data.
     */
    public function loadData(): void
    {
        $this->createMany(20, 'postCategories', function (int $i) {
            $postCategory = new PostCategory();
            $postCategory->setName($this->faker->unique()->word);
            $postCategory->setCreatedAt(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );

            return $postCategory;
        });

        $this->manager->flush();
    }
}
