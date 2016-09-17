<?php
namespace  AppBundle\Form;

use AppBundle\Entity\Employee;
use AppBundle\Entity\EmployeeLunchReport;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

/**
 * Form for Employee entity
 */
class EmployeeLunchReportType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateTimeType::class, ['widget' => 'single_text'])
            ->add('endDate', DateTimeType::class, ['widget' => 'single_text'])
            ->add('employees', EntityType::class, [
                'class' => Employee::class,
                'multiple' => true,
            ])
            ->add('expand', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'employee_lunch_report_flat',
                    'employee_lunch_report_grouped',
                    'lunch_receipt_src',
                ],
                'multiple' => true,
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
            'data_class' => EmployeeLunchReport::class,
            'allow_extra_fields' => true,
        ));
    }
}
