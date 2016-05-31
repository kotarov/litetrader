<?php
function arr2ini(array $a, array $parent = array())
{
    $out = '';
    foreach ($a as $k => $v)
    {
        if (is_array($v))
        {
            $sec = array_merge((array) $parent, (array) $k);
            $out .= '[' . join('.', $sec) . ']' . PHP_EOL;
            $out .= arr2ini($v, $sec);
        }
        else
        {
            $out .= $k.' = "'.$v.'"' . PHP_EOL;
            //$out .= $k.' = '.(is_bool($v) ? ($v?"true":"false") : '"'.$v.'"') . PHP_EOL;
        }
    }
    return $out;
}