<?php

/**
 * Декодирует строку в объект.
 *
 * Этот метод сначала попытается проанализировать данные
 * как строку JSON (поскольку большинство провайдеров используют этот формат), а затем XML и parse_str.
 *
 * @param string|null $raw
 *
 * @return mixed
 */
function parse(string $raw = null): mixed
{
    $parsers = ['parseJson', 'parseXml', 'parseQueryString'];

    foreach ($parsers as $parser) {
        $data = $parser($raw);
        if ($data) {
            return $data;
        }
    }

    return null;
}

/**
 * Декодирует строку JSON
 *
 * @param string|null $raw
 * @return mixed
 */
function parseJson(string $raw = null): mixed
{
    $data = json_decode($raw, true);
    return json_last_error() === JSON_ERROR_NONE ? $data : null;
}

/**
 * Декодирует строку XML
 *
 * @param string|null $raw
 * @return array|null
 */
function parseXml(string $raw = null): ?array
{
    libxml_use_internal_errors(true);

    $raw = preg_replace('/([<\/])([a-z0-9-]+):/i', '$1', $raw);
    $xml = simplexml_load_string($raw);

    libxml_use_internal_errors(false);

    if (!$xml) {
        return null;
    }

    $arr = json_decode(json_encode((array)$xml), true);
    return [$xml->getName() => $arr];
}

/**
 * Разбирает строку на переменные
 *
 * @param string|null $raw
 * @return StdClass|null
 */
function parseQueryString(string $raw = null): ?StdClass
{
    parse_str($raw, $output);

    if (!is_array($output)) {
        return null;
    }

    return (object)$output;
}