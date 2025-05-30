<?php

//unsatisfy, average, good, great
if ( ! function_exists('getSatisfactionLevelByCf')) {
    function getSatisfactionLevelByCf($cf = 0) {
        if ($cf < 1000000) {
            $res = 'unsatisfy';
        } elseif ($cf < 2000000) {
            $res = 'average';
        } elseif ($cf < 2500000) {
            $res = 'good';
        } else {
            $res = 'great';
        }

        return $res;
    }
}

if ( ! function_exists('getSatisfactionMarkByCf')) {
    function getSatisfactionMarkByCf($cf = 0) {
        if ($cf < 1000000) {
            $res = '×';
        } elseif ($cf < 2000000) {
            $res = '△';
        } elseif ($cf < 2500000) {
            $res = '○';
        } else {
            $res = '◎';
        }

        return $res;
    }
}

//unsatisfy, average, good, great
if ( ! function_exists('getSatisfactionLevelByDscr')) {
    function getSatisfactionLevelByDscr($dscr = 0) {
        if ($dscr < 1) {
            $res = 'unsatisfy';
        } elseif ($dscr < 1.2) {
            $res = 'average';
        } elseif ($dscr < 1.5) {
            $res = 'good';
        } else {
            $res = 'great';
        }

        return $res;
    }
}

if ( ! function_exists('getSatisfactionMarkByDscr')) {
    function getSatisfactionMarkByDscr($dscr = 0) {
        if ($dscr < 1) {
            $res = '×';
        } elseif ($dscr < 1.2) {
            $res = '△';
        } elseif ($dscr < 1.5) {
            $res = '○';
        } else {
            $res = '◎';
        }

        return $res;
    }
}

if ( ! function_exists('isMinus')) {
    function isMinus($val = null) {
        if ($val < 0) {
            return True;
        } else {
            return False;
        }
    }
}
