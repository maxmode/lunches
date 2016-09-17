<?php
namespace  AppBundle\Form;

use AppBundle\Entity\Employee;
use AppBundle\Entity\Lunch;
use AppBundle\Form\Lunch\ReceiptType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * Form for Lunch entity
 */
class LunchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('occasionDate', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('placeName', TextType::class)
            ->add('placeAddress', TextType::class)
            ->add('ammount', MoneyType::class)
            ->add('description', TextareaType::class)
            ->add('receipt', ReceiptType::class, [
                'constraints' => array(new Valid()),
            ])
            ->add('employee', EntityType::class, [
                'class' => Employee::class
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => Lunch::class,
            'allow_extra_fields' => true,
        ));
    }
}
