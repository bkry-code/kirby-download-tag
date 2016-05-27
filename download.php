<?php

kirbytext::$tags['download'] = array( // give keyword "first" or "last" or the filename(with extension)
    'attr' => array(
        'text',
        'type',
        'ext'
    ),
    'html' => function ($tag) {

        $types = array('document',
            'code',
            'images',
            'videos');

        $files = $tag->page()->files();

        if ($tag->attr('type') != "") {
            if (in_array($tag->attr('type'), $types)) {
                $files = $files->filterBy('type', $tag->attr('type'));
            } else {
                return ('<b>ERROR: download - no valid type defined</b>');
            }
        }

        if ($tag->attr('ext') != "") {
            $files = $files->filterBy('extension', $tag->attr('ext'));
        }

        if ($files->count() == 0) {
            return '<b>WARNING</b>: no files selected';
        }

        if ($tag->attr('download') == 'first') {
            $file = $files->first();
        } else if ($tag->attr('download') == 'last') {
            $file = $files->last();
        } else {
            $file = $files->find($tag->attr('download'));
        }

        // switch link text: filename or custom text
        (empty($tag->attr('text'))) ? $text = $file->filename() : $text = $tag->attr('text');

        return '<a class="dl" href="' . $file->url() . '" target="_blank">' . $text . '</a> <small>(' . $file->niceSize() . ')</small>';
    }
);