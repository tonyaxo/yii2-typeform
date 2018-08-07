<?php

namespace yiiunit\extensions\yii2typeform;

use tonyaxo\yii2typeform\AuthClient;

class AuthClientTest extends TestCase
{
    const EXPECTED_SCOPES = [
        'SCOPE_FORMS_WRITE' => 'forms:write',
        'SCOPE_FORMS_READ' => 'forms:read',

        'SCOPE_IMAGES_READ' => 'images:read',
        'SCOPE_IMAGES_WRITE' => 'images:write',

        'SCOPE_THEMES_WRITE' => 'themes:write',
        'SCOPE_THEMES_READ' => 'themes:read',

        'SCOPE_WEBHOOKS_READ' => 'webhooks:read',
        'SCOPE_WEBHOOKS_WRITE' => 'webhooks:write',

        'SCOPE_WORKSPACES_READ' => 'workspaces:read',
        'SCOPE_WORKSPACES_WRITE' => 'workspaces:write',

        'SCOPE_RESPONSES_READ' => 'responses:read',
    ];

    public function testScope()
    {
        $client = new AuthClient();
        $this->assertEquals(self::EXPECTED_SCOPES, $client->getScopes());

        $prefix = $suffix = '';
        if (count(self::EXPECTED_SCOPES) > 0) {
            $prefix = '{';
            $suffix = '}';
        }
        $expectedScope = $prefix . implode('}+{', self::EXPECTED_SCOPES) . $suffix;
        $this->assertEquals($expectedScope, $client->scope);
    }
}
