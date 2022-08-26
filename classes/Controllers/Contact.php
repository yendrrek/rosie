<?php

namespace Rosie\Controllers;

use Rosie\DependenciesContainers\ContactDepCont;

class Contact
{
    public function __construct(private ContactDepCont $contactDepCont)
    {
    }

    public function runPage(): void
    {
        include 'views/contact-form-and-details.php';
    }
}
