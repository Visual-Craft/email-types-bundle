<?php

declare(strict_types=1);

namespace VisualCraft\EmailTypesBundle;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use VisualCraft\EmailTypesBundle\Exception\InvalidEmailTypeOptionsException;
use VisualCraft\EmailTypesBundle\Exception\MissingEmailTypeException;

class Mailer
{
    private MailerInterface $mailer;

    private TranslatorInterface $translator;

    private ServiceLocator $emailTypesLocator;

    private ?string $defaultFrom = null;

    public function __construct(
        MailerInterface $mailer,
        TranslatorInterface $translator,
        ServiceLocator $emailTypesLocator
    ) {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->emailTypesLocator = $emailTypesLocator;
    }

    public function setDefaultFrom(?string $value): void
    {
        $this->defaultFrom = $value;
    }

    public function send(string $typeName, array $options): void
    {
        if (!$this->emailTypesLocator->has($typeName)) {
            throw new MissingEmailTypeException(sprintf("Unsupported mail type '%s'.", $typeName));
        }

        /** @var EmailTypeInterface $type */
        $type = $this->emailTypesLocator->get($typeName);
        $optionsResolver = $this->createOptionsResolverInstance();
        $type->configureOptions($optionsResolver);

        try {
            $options = $optionsResolver->resolve($options);
        } catch (\Exception $e) {
            throw new InvalidEmailTypeOptionsException(sprintf("Invalid options are provided for mail type '%s'.", $typeName), 0, $e);
        }

        $email = $this->createEmailInstance();
        $type->configureEmail($email, $options);
        $this->preProcessEmail($email);
        $this->mailer->send($email);
    }

    protected function createOptionsResolverInstance(): OptionsResolver
    {
        return new OptionsResolver();
    }

    protected function createEmailInstance(): TemplatedEmail
    {
        $email = new TemplatedEmail();

        if ($this->defaultFrom !== null) {
            $address = Address::create($this->defaultFrom);
            $email->from($address);
        }

        return $email;
    }

    private function preProcessEmail(TemplatedEmail $email): void
    {
        if (($subject = $email->getSubject()) !== null) {
            $translationContext = [];

            foreach ($email->getContext() as $key => $value) {
                if (is_scalar($value) || (\is_object($value) && method_exists($value, '__toString'))) {
                    $translationContext["%{$key}%"] = (string) $value;
                }
            }

            $email->subject($this->translator->trans($subject, $translationContext));
        }
    }
}
