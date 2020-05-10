<?php


namespace App\Serializer;


use App\Exception\FormException;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FormExceptionNormalizer implements NormalizerInterface
{
//    /**
//     * @param FormException $exception
//     * @param string $format
//     * @param array $context
//     *
//     * @return array|bool|float|int|string|void
//     */
//    public function normalize($exception, string $format, array $context = [])
//    {
//        $data   = [];
//        $errors = $exception->getErrors();
//
//        foreach ($errors as $error) {
//            $data[$error->getOrigin()->getName()][] = $error->getMessage();
//        }
//
//        return $data;
//    }
//
//    /**
//     * @param mixed $data
//     * @param null  $format
//     *
//     * @return bool|void
//     */
//    public function supportsNormalization($data, $format = null)
//    {
//        return $data instanceof FormException;
//    }
    /**
     * @param mixed $exception
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|null
     */
    public function normalize($exception, string $format = null, array $context = [])
    {
        $data = [];
        $errors = $exception->getErrors();

        foreach ($errors as $error) {
            $data[$error->getOrigin()->getName()][] = $error->getMessage();
        }

        return $data;
    }

    /**
     * @param mixed $data
     * @param string|null $format
     * @return bool
     */
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof FormException;
    }
}