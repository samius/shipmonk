<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Operator\IncrementStyleFixer;
use PhpCsFixer\FixerFactory;
use PhpCsFixer\RuleSet\RuleSet;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    // Configure Symfony ruleset from PHP CS Fixer
    $fixerFactory = new FixerFactory();
    $fixerFactory->registerBuiltInFixers();
    $ruleSet = new RuleSet([
        '@Symfony' => true,
        // '@Symfony:risky' => true, // Enable if you want risky rules
    ]);
    $fixerFactory->useRuleSet($ruleSet);

    foreach ($fixerFactory->getFixers() as $fixer) {
        $fixerClass = $fixer::class;
        $configuration = $ruleSet->getRuleConfiguration($fixer->getName());

        if ($configuration !== null) {
            $ecsConfig->ruleWithConfiguration($fixerClass, $configuration);
        } else {
            $ecsConfig->rule($fixerClass);
        }
    }

    $ecsConfig->skip([
        IncrementStyleFixer::class,
    ]);
};