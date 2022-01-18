<?php

declare(strict_types=1);

namespace VisualCraft\EmailTypesBundle\Tests\TestApplication\EmailType;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VisualCraft\EmailTypesBundle\EmailTypeInterface;

class MessageEmailType implements EmailTypeInterface
{
    public function configureOptions(OptionsResolver $optionsResolver): void
    {
    }

    public function configureEmail(TemplatedEmail $email, array $options): void
    {
        $email
            ->to('to-email@example.com')
            ->from('from-email@example.com')
            ->subject('test subject')
            ->text('test text')
            ->html('<p>test html</p>')
        ;
    }
}
