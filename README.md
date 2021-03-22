# EmailTypesBundle
Symfony Bundle for structured email composing.

## Installation and configuration

### Install using composer
```shell
composer require visual-craft/email-types-bundle
```

### Configure bundle
```yaml
# config/packages/email_types.yaml
visual_craft_email_types:
    # used in case of email 'from' is not explicitly set (default null) 
    default_email_from: 'Name <contact@example.com>'
```


## Usage

### Create email type class
```php
<?php

namespace App\EmailType;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VisualCraft\EmailTypesBundle\EmailTypeInterface;

class UserActivationType implements EmailTypeInterface
{
    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        $optionsResolver
            ->setRequired(['user'])
            ->setAllowedTypes('user', User::class)
        ;
    }

    public function configureEmail(TemplatedEmail $email, array $options): void
    {
        $user = $options['user'];
        $email
            ->to($user->getEmail())
            ->from('admin@example.com')
            // subject is automatically translated
            // translation parameters are populated from context (scalar values only)
            ->subject('Hello %fullName%')
            ->htmlTemplate('email/activation.html.twig')
            ->context([
                'user' => $user,
                // used as subject translation parameter %fullName%
                'fullName' => $user->getFullName(),
            ])
        ;
    }
}

```

### Register your email type class as a service
```yaml
# config/services.yaml
services:
    Email\Type\UserActivationType: ~
```

### Send the email
```php
<?php

namespace App\Controller;

use App\Entity\User;
use App\EmailType\UserActivationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use VisualCraft\EmailTypesBundle\Mailer;

class ActivationController extends AbstractController
{
    private Mailer $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(Request $request): Response
    {
        // ...code
        $this->mailer->send(UserActivationType::class, [
            'user' => $this->getUser(),
        ]);
        // ...code
    }
}
```

## License
This bundle is under the MIT license. See the complete license in LICENSE.txt file.
