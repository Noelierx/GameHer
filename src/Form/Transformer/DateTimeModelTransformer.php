<?php

namespace App\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;

class DateTimeModelTransformer implements DataTransformerInterface
{
	/**
	 * @param ?\DateTime $value
	 *
	 * @return array|null
	 */
	public function transform($value)
	{
		if ($value === null) {
			return null;
		}

		return [
			'date' => (clone $value)->setTime(0, 0),
			'time' => [
				'hour'   => $value->format('h'),
				'minute' => $value->format('i'),
			],
		];
	}

	/**
	 * @param array $value
	 *
	 * @return \DateTime|null
	 *
	 * @throws \Exception
	 */
	public function reverseTransform($value)
	{
		if (empty($value)) {
			return null;
		}

		/**
		 * @var \DateTime $date
		 * @var array     $time
		 */
		list('date' => $date, 'time' => $time) = $value;

		if (!$date instanceof \DateTimeInterface) {
			return null;
		}

		return $date->add(new \DateInterval(sprintf('PT%sH%sM', ...array_values($time))));
	}
}
