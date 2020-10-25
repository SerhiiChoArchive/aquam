<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Helper;
use Tests\TestCase;

class HelperTest extends TestCase
{
    /** @test */
    public function activeIfRouteIs_helper_returns_active_string(): void
    {
        $this->get('/');
        $this->assertEquals('active', Helper::activeIfRouteIs(['/', 'settings']));

        $this->get('/contact');
        $this->assertEquals('active', Helper::activeIfRouteIs(['/recipes', 'contact']));

        $this->get('/search');
        $this->assertEquals('active', Helper::activeIfRouteIs(['/search']));
    }
}