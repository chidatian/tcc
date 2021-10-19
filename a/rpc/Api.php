<?php


class Api {

    public static function test() {
        return func_get_args();
    }

    public static function mysql() {
        return Members::findArray([]);
    }
}