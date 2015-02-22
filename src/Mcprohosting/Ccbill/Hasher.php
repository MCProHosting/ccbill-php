<?php

namespace Mcprohosting\Ccbill;


class Hasher
{
    /**
     * Digests a set of keys from the data.
     *
     * @param $data array
     * @param $keys array
     * @return string
     */
    public static function digest($data, $keys)
    {
        $toHash = '';
        foreach ($keys as $key) {
            if (!array_key_exists($key, $data)) {
                return '';
            } else {
                $toHash .= $data[$key];
            }
        }

        return md5($toHash);
    }
}