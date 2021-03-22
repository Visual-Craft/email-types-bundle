<?php

declare(strict_types=1);

namespace VisualCraft\EmailTypesBundle;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface EmailTypeInterface
{
    public function configureOptions(OptionsResolver $optionsResolver): void;

    public function configureEmail(TemplatedEmail $email, array $options): void;
}
