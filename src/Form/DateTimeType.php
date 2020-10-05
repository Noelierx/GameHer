<?php
/**
 * @author    Nickolay Mikhaylov <sonny@milton.pro>
 * @copyright Copyright (c) 2020, GameHer
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form;

use App\Form\Transformer\DateTimeModelTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Date time type
 */
class DateTimeType extends AbstractType
{
	/**
	 * @inheritDoc
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('date', DateType::class, [
				'widget'   => 'single_text',
				'format'   => 'yyyy-MM-dd',
				'required' => true,
				'input'    => 'datetime',
				'attr'     => ['class' => 'datepicker'],
				'label'    => 'Date de publication',
			])
			->add('time', TimeType::class, [
				'widget'     => 'single_text',
				'required'   => true,
				'html5'      => false,
				'attr'       => ['class' => 'timepicker'],
				'input'      => 'array',
				'label'      => 'Heure de publication',
				'empty_data' => '08:00',
			]);

		$builder->addModelTransformer(new DateTimeModelTransformer());
	}
}
