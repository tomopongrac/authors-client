<?php

namespace App\Form;

use App\Entity\Book;
use App\Service\AuthorProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookFormType extends AbstractType
{

    private AuthorProvider $authorProvider;

    public function __construct(AuthorProvider $authorProvider)
    {
        $this->authorProvider = $authorProvider;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $authors = $this->authorProvider->getAuthors();

        $authorsDecoded = [];
        foreach ($authors->getItems() as $author) {
            $authorsDecoded[$author->getFirstName() . ' ' . $author->getLastName()] = $author;
        }

        $builder
            ->add('title', TextType::class)
            ->add('releaseDate', DateType::class, [
            ])
            ->add('description', TextareaType::class)
            ->add('isbn', TextType::class)
            ->add('format', TextType::class)
            ->add('numberOfPages', IntegerType::class)
            ->add('author', ChoiceType::class, [
                'placeholder' => 'Choose a author',
                'choices' => $authorsDecoded,
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
