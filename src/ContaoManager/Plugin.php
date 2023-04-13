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

namespace Markocupic\ContaoRszTheme\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Markocupic\ContaoArticleClassSelectBundle\MarkocupicContaoArticleClassSelectBundle;
use Markocupic\ContaoRszTheme\MarkocupicContaoRszTheme;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(MarkocupicContaoRszTheme::class)
                ->setLoadAfter([
                    ContaoCoreBundle::class,
                    MarkocupicContaoArticleClassSelectBundle::class,
                ]),
        ];
    }
}
