<?php

namespace ThenbspCartBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $supportedCurrencyMode = array(
            PHP_ROUND_HALF_UP,
            PHP_ROUND_HALF_DOWN,
            PHP_ROUND_HALF_EVEN,
            PHP_ROUND_HALF_ODD);

        $builder = new TreeBuilder();
        $builder->root('thenbsp_cart')
            ->children()
                ->arrayNode('currency')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('precision')
                            ->min(0)
                            ->defaultValue(2)
                        ->end()
                        ->enumNode('mode')
                            ->values($supportedCurrencyMode)
                            ->defaultValue(current($supportedCurrencyMode))
                        ->end()
                        ->integerNode('decimals')
                            ->min(0)
                            ->defaultValue(2)
                        ->end()
                        ->scalarNode('dec_point')
                            ->defaultValue('.')
                        ->end()
                        ->scalarNode('thousands_sep')
                            ->defaultValue(',')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $builder;
    }
}
