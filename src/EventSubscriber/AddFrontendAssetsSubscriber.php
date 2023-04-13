<?php

declare(strict_types=1);

/*
 * This file is part of Contao RSZ Theme Regionalzentrum Sportklettern Zentralschweiz.
 *
 * (c) Marko Cupic 2023 <m.cupic@gmx.ch>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/contao-rsz-theme
 */

namespace Markocupic\ContaoRszTheme\EventSubscriber;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\CoreBundle\Util\SymlinkUtil;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AddFrontendAssetsSubscriber implements EventSubscriberInterface
{
    private ContaoFramework $framework;
    private ScopeMatcher $scopeMatcher;
    private string $projectDir;

    public function __construct(ContaoFramework $framework, ScopeMatcher $scopeMatcher, string $projectDir)
    {
        $this->framework = $framework;
        $this->scopeMatcher = $scopeMatcher;
        $this->projectDir = $projectDir;
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::REQUEST => 'addFrontendAssets'];
    }

    public function addFrontendAssets(RequestEvent $e): void
    {
        $this->framework->initialize();

        $request = $e->getRequest();

        /*
         * Symlink theme assets and template folder
         */
        SymlinkUtil::symlink('vendor/markocupic/contao-rsz-theme/files/themes/rsz-theme', 'files/themes/rsz-theme', $this->projectDir);

        if ($this->scopeMatcher->isFrontendRequest($request)) {
            /*
             * Add viewport tags
             */
            $this->addAsset(DocumentLocation::TL_HEAD, '<meta name="viewport" content="width=device-width, initial-scale=1">');

            /*
             * Macy masonry layout
             */
            $this->addAsset(DocumentLocation::TL_JAVASCRIPT, 'https://cdn.jsdelivr.net/npm/macy@2');
            $this->addAsset(DocumentLocation::TL_JAVASCRIPT, 'bundles/markocupiccontaorsztheme/js/macy-grid.js');

            /*
             * Favicon
             */
            $this->addAsset(
                DocumentLocation::TL_HEAD,
                '
                <link rel="apple-touch-icon" sizes="57x57" href="files/themes/rsz-theme/favicon/apple-icon-57x57.png">
                <link rel="apple-touch-icon" sizes="60x60" href="files/themes/rsz-theme/favicon/apple-icon-60x60.png">
                <link rel="apple-touch-icon" sizes="72x72" href="files/themes/rsz-theme/favicon/apple-icon-72x72.png">
                <link rel="apple-touch-icon" sizes="76x76" href="files/themes/rsz-theme/favicon/apple-icon-76x76.png">
                <link rel="apple-touch-icon" sizes="114x114" href="files/themes/rsz-theme/favicon/apple-icon-114x114.png">
                <link rel="apple-touch-icon" sizes="120x120" href="files/themes/rsz-theme/favicon/apple-icon-120x120.png">
                <link rel="apple-touch-icon" sizes="144x144" href="files/themes/rsz-theme/favicon/apple-icon-144x144.png">
                <link rel="apple-touch-icon" sizes="152x152" href="files/themes/rsz-theme/favicon/apple-icon-152x152.png">
                <link rel="apple-touch-icon" sizes="180x180" href="files/themes/rsz-theme/favicon/apple-icon-180x180.png">
                <link rel="icon" type="image/png" sizes="192x192" href="files/themes/rsz-theme/favicon/android-icon-192x192.png">
                <link rel="icon" type="image/png" sizes="32x32" href="files/themes/rsz-theme/favicon/favicon-32x32.png">
                <link rel="icon" type="image/png" sizes="96x96" href="files/themes/rsz-theme/favicon/favicon-96x96.png">
                <link rel="icon" type="image/png" sizes="16x16" href="files/themes/rsz-theme/favicon/favicon-16x16.png">
                <link rel="icon" type="image/x-icon" sizes="16x16" href="files/themes/rsz-theme/favicon/favicon.ico">
                <link rel="manifest" href="files/themes/rsz-theme/favicon/manifest.json">
                <meta name="msapplication-TileColor" content="#ffffff">
                <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
                <meta name="theme-color" content="#ffffff">
            '
            );

            /*
             * Font Awesome Pro
             */
            $this->addAsset(DocumentLocation::TL_HEAD, '<script src="https://kit.fontawesome.com/79e7d51d43.js" crossorigin="anonymous"></script>');

            /*
             * Google Web Fonts
             */
            $this->addAsset(
                DocumentLocation::TL_HEAD,
                '
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;0,900;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
            '
            );

            /*
             * Bootstrap Javascript Bundle
             */
            $this->addAsset(DocumentLocation::TL_BODY, '<script src="assets/contao-component-bootstrap/bootstrap/dist/js/bootstrap.bundle.min.js"></script>');
        }
    }

    private function addAsset(DocumentLocation $location, string $value): void
    {
        if ($location->value === DocumentLocation::TL_HEAD->value) {
            $GLOBALS[$location->value][] = $value;
        }

        if ($location->value === DocumentLocation::TL_CSS->value) {
            $GLOBALS[$location->value][] = $value;
        }

        if ($location->value === DocumentLocation::TL_JAVASCRIPT->value) {
            $GLOBALS[$location->value][] = $value;
        }

        if ($location->value === DocumentLocation::TL_MOOTOOLS->value) {
            $GLOBALS[$location->value][] = $value;
        }

        if ($location->value === DocumentLocation::TL_BODY->value) {
            $GLOBALS[$location->value][] = $value;
        }
    }
}
