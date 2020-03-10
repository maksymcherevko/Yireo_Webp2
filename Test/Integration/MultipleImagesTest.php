<?php
declare(strict_types=1);

namespace Yireo\Webp2\Test\Integration;

/**
 * Class MultipleImagesTest
 * @package Yireo\Webp2\Test\Integration
 */
class MultipleImagesTest extends Common
{
    /**
     * @magentoAppIsolation enabled
     * @magentoDbIsolation enabled
     * @magentoAdminConfigFixture yireo_webp2/settings/enabled 1
     * @magentoAdminConfigFixture yireo_webp2/settings/debug 1
     */
    public function testIfHtmlContainsWebpImages()
    {
        $this->getResponse()->clearBody();
        $this->getResponse()->clearHeaders();
        $this->fixtureImageFiles();

        $this->getRequest()->clearParams();
        $this->getRequest()->setRequestUri('webp/test/images');
        $this->getRequest()->setParam('case', 'multiple_images');
        $this->dispatch('webp/test/images');
        $this->assertSame('multiple_images', $this->getRequest()->getParam('case'));
        $this->assertSame(200, $this->getResponse()->getHttpResponseCode());

        $body = $this->getResponse()->getBody();
        $this->assertImageTagsExist($body, $this->getImageProvider()->getImages());
    }
}
