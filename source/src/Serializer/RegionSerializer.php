<?php


namespace App\Serializer;

use App\Entity\Region;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class RegionSerializer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    public function supportsNormalization($object, string $format = null)
    {
        return $object instanceof Region;
    }

    /**
     * @param Region $region
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($region, string $format = null, array $context = []): array
    {
        return [
            'id' => $region->getId(),
            'name' => $region->getName(),
        ];
    }
}