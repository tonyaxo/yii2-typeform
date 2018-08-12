<?php

namespace yiiunit\extensions\yii2typeform;

use tonyaxo\yii2typeform\AuthClient;

class AuthClientTest extends TestCase
{
    const EXPECTED_SCOPES = [
        'forms:write' => 'forms:write',
        'forms:read' => 'forms:read',
        'images:read' => 'images:read',
        'images:write' => 'images:write',
        'themes:write' => 'themes:write',
        'themes:read' => 'themes:read',
        'webhooks:read' => 'webhooks:read',
        'webhooks:write' => 'webhooks:write',
        'workspaces:read' => 'workspaces:read',
        'workspaces:write' => 'workspaces:write',
        'responses:read' => 'responses:read',
    ];

    public function testScope()
    {
        $client = new AuthClient();
        $this->assertEquals(self::EXPECTED_SCOPES, $client->getScopes());

        $expectedScope = implode(' ', self::EXPECTED_SCOPES);
        $this->assertEquals($expectedScope, $client->scope);
    }
}
