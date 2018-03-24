<?php namespace Extend\Translation;

class FileLoader extends \Illuminate\Translation\FileLoader {

    /**
     * Load the messages for the given locale.
     *
     * @param  string  $locale
     * @param  string  $group
     * @param  string  $namespace
     * @return array
     */
    public function load($locale, $group, $namespace = null)
    {
        // Load language from the database.
        if ($group == 'db')
        {
            return \Event::until('language.db', array($locale));
        }

        return parent::load($locale, $group, $namespace);
    }

}