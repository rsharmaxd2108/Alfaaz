<?php

namespace Tests\Feature;

use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    /**
     * Test that web routes include essential defense-in-depth security headers.
     */
    public function test_web_routes_include_security_headers(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
    }

    /**
     * Test that login and signup routes also include security headers.
     */
    public function test_auth_routes_include_security_headers(): void
    {
        $loginResponse = $this->get('/login');
        $loginResponse->assertStatus(200);
        $loginResponse->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $loginResponse->assertHeader('X-Content-Type-Options', 'nosniff');
        $loginResponse->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');

        $signupResponse = $this->get('/signup');
        $signupResponse->assertStatus(200);
        $signupResponse->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $signupResponse->assertHeader('X-Content-Type-Options', 'nosniff');
        $signupResponse->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    /**
     * Test that secure (HTTPS) requests include HSTS header.
     */
    public function test_secure_requests_include_hsts_header(): void
    {
        $response = $this->get('https://localhost/');

        $response->assertStatus(200);
        $response->assertHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
    }
}
