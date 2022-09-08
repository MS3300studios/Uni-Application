<?php
/**
 *
 * PostType
 *
 */
namespace App\Form\Type;

use App\Entity\Post;
use App\Entity\PostCategory;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *
 * Class PostType.
 *
 */
class PostType extends AbstractType
{

    /**
     * Build form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     *
     * @return void
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'label.title',
                'required' => 'true',
                'attr' => ['max_length' => 255],
            ]
        );
        $builder->add(
            'content',
            TextType::class,
            [
                'label' => 'label.content',
                'required' => 'true',
                'attr' => ['max_length' => 255],
            ]
        );
        $builder->add(
            'postCategory',
            EntityType::class,
            [
              'class' => PostCategory::class,
              'choice_label' => function ($postCategory): string {
                return $postCategory->getName();
              },
              'label' => 'label.category',
              'placeholder' => 'label.none',
              'required' => 'true',
            ]
        );
    }

    /**
     * Configure Options.
     *
     * @param OptionsResolver $resolver
     *
     * @return void
     *
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Post::class]);
    }

    /**
     * Get block by prefix.
     *
     * @return string
     *
     */
    public function getBlockPrefix(): string
    {
        return 'post';
    }
}
