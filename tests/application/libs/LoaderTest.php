<?php
/**
 * Unit Tests for Loader
 */

include_once __DIR__ . '/../../config.php';
include_once TDIR_APPLICATION . '/libs/Loader.php';

class LoaderTest extends PHPUnit_Framework_TestCase {

    protected $loader;

    public function setUp() {
        $this->loader = new Fuzz\Loader();
    }

    public function testBasicLoaderFunctionality() {
        $this->loader->addNamespacePath('Fuzz', TDIR_APPLICATION . '/libs');
        $this->loader->addNamespacePath('', TDIR_APPLICATION . '/modules/{class}');

        $path = $this->loader->path('Fuzz\Loader');
        $this->assertSame(TDIR_APPLICATION . '/libs/Loader.php', $path, 'Shall be same');

        $path = $this->loader->path('Forum');
        $this->assertSame(TDIR_APPLICATION . '/modules/forum/Forum.php', $path, 'Shall be same');
    }

}
