<?php


namespace App\Serializer;

use App\Entity\City;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CitySerializer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    public function supportsNormalization($object, string $format = null)
    {
        return $object instanceof City;
    }

    /**
     * @param City $city
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($city, string $format = null, array $context = []): array
    {
        return [
            'id' => $city->getId(),
            'name' => $city->getName()
        ];
    }
}