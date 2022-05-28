<?php

namespace App\Serializer;

use App\Entity\Book;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class BookNormalizer implements ContextAwareNormalizerInterface
{
    private $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function normalize($book, string $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($book, $format, $context);

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Book;
    }
}