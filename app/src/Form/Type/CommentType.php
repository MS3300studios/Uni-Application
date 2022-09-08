<?php
/**
 *
 * CommentType
 *
 */
namespace App\Form\Type;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *
 * Class CommentType.
 *
 */
class CommentType extends AbstractType
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
          'nick',
          TextType::class,
            [
                'label'=>'label.nick',
                'required'=>true,
                'attr'=>['max_length'=> 10]
            ]);
        $builder->add(
          'email',
          EmailType::class,
            [
                'label'=>'label.email',
                'required'=>true,
                'attr'=>['max_length'=> 32]
            ]);
        $builder->add(
          'content',
          TextareaType::class,
            [
                'label'=>'label.content',
                'required'=>true,
                'attr'=>['max_length'=> 100]
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
        $resolver->setDefaults(['data_class'=>Comment::class]);
    }

    /**
     * Get block prefix.
     *
     * @return string
     *
     */
    public function getBlockPrefix(): string
    {
        return 'Comment';
    }

}