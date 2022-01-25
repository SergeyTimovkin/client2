<?php


namespace App\Serializer;

use App\Entity\Home;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class HomeSerializer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    public function supportsNormalization($object, string $format = null)
    {
        return $object instanceof Home;
    }

    /**
     * @param Home $home
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($home, string $format = null, array $context = []): array
    {
        return [
            'id' => $home->getId(),
            'number' => $home->getNumber(),
            'lat' => $home->getLat(),
            'lon' => $home->getLon(),
        ];
    }
}