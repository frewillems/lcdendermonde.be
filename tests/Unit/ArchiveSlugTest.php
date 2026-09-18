<?php

namespace Tests\Unit;

use App\Support\ArchiveSlug;
use PHPUnit\Framework\TestCase;

class ArchiveSlugTest extends TestCase
{
    public function test_reserved_slugs_include_public_pages(): void
    {
        $this->assertTrue(ArchiveSlug::isReserved('contact'));
        $this->assertTrue(ArchiveSlug::isReserved('admin'));
        $this->assertTrue(ArchiveSlug::isReserved('leden'));
        $this->assertFalse(ArchiveSlug::isReserved('album-dagenraad'));
    }
}
