<?php namespace Extend\Translation;

use Illuminate\Translation\Translator as LaravelTranslator;

class Translator extends LaravelTranslator {

    public function translate($line, $attributes = array())
    {
        $key = 'db.'.$line;

        if ($this->has($key))
        {
            $line = $this->get($key);
        }
        // Insert line language to the database, if not exists.
        else
        {
            // [WARNING] This is decrease a lot of performance, so should't use on production.
            if (\App::environment() != 'production')
            {
               // DB::insert('insert ignore into locales (line) values (?)', array($line));
            }
        }

        return preg_replace_callback('/:([a-z]+)/', function($bind) use ($attributes)
        {
            return isset($attributes[$bind[1]]) ? $attributes[$bind[1]] : $bind[0];
        }
        , $line);
    }

}