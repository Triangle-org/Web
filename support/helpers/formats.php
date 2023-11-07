<?php

use support\Response;
use Symfony\Component\Yaml\Yaml;

/**
 * @param $value
 * @param int $flags
 * @return string|false
 */
function json($value, int $flags = JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR): false|string
{
    return json_encode($value, $flags);
}

/**
 * @param $xml
 * @return Response
 */
function xml($xml): Response
{
    if ($xml instanceof SimpleXMLElement) {
        $xml = $xml->asXML();
    }
    return new Response(200, ['Content-Type' => 'text/xml'], $xml);
}

/**
 * @param $data
 * @param string $callbackName
 * @return Response
 */
function jsonp($data, string $callbackName = 'callback'): Response
{
    if (!is_scalar($data) && null !== $data) {
        $data = json_encode($data);
    }
    return new Response(200, [], "$callbackName($data)");
}

/**
 * @param $yaml
 * @return Response
 */
function yaml($yaml): Response
{
    if (!class_exists(Yaml::class)) {
        throw new RuntimeException("Запусти composer require symfony/yaml для поддержки YAML");
    }
    if (is_array($yaml)) {
        $yaml = Yaml::dump($yaml);
    }
    return new Response(200, ['Content-Type' => 'text/yaml'], $yaml);
}