<?php

declare(strict_types=1);

/*
 * This file is part of Contao RSZ Theme Regionalzentrum Sportklettern Zentralschweiz.
 *
 * (c) Marko Cupic 2022 <m.cupic@gmx.ch>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/contao-rsz-theme
 */

namespace Markocupic\ContaoRszTheme;

use Markocupic\ContaoRszTheme\DependencyInjection\Compiler\AddSessionBagsPass;
use Markocupic\ContaoRszTheme\DependencyInjection\MarkocupicContaoRszThemeExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MarkocupicContaoRszTheme extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getContainerExtension(): MarkocupicContaoRszThemeExtension
    {
        return new MarkocupicContaoRszThemeExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new AddSessionBagsPass());
    }
}
