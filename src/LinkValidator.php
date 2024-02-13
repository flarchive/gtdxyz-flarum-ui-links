<?php

namespace Gtdxyz\Links;

use Flarum\Foundation\AbstractValidator;

class LinkValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'title' => ['required', 'string', 'max:50'],
        'url'   => ['string', 'max:255'],
        'icon'  => ['string', 'max:255'],
    ];
}
