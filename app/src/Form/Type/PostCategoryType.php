<?php
/**
 *
 * PostCategoryType
 *
 */
namespace App\Form\Type;

use App\Entity\PostCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *
 * Class PostCategoryType.
 *
 */
class PostCategoryType extends AbstractType
{
    /**
     * Build Form.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
          'name',
          TextType::class,
            [
                'label'=>'label.name',
                'required'=>true,
                'attr'=>['max_length'=> 64],
            ]);
    }

    /**
     * Configure options.
     *
     * @param OptionsResolver $resolver
     * @return void
     *
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class'=>PostCategory::class]);
    }

    /**
     * Get block prefix.
     *
     * @return string
     *
     */
    public function getBlockPrefix(): string
    {
        return 'postCategory';
    }

}