<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector;
use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodeQuality\Rector\Expression\InlineIfToExplicitIfRector;
use Rector\CodeQuality\Rector\Expression\TernaryFalseExpressionToIfRector;
use Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector;
use Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector;
use Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector;
use Rector\CodingStyle\Rector\ClassConst\SplitGroupedClassConstantsRector;
use Rector\CodingStyle\Rector\ClassMethod\FuncGetArgsToVariadicParamRector;
use Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector;
use Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\FuncCall\CallUserFuncArrayToVariadicRector;
use Rector\CodingStyle\Rector\FuncCall\CallUserFuncToMethodCallRector;
use Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector;
use Rector\CodingStyle\Rector\Plus\UseIncrementAssignRector;
use Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector;
use Rector\CodingStyle\Rector\Property\SplitGroupedPropertiesRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector;
use Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector;
use Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use Rector\EarlyReturn\Rector\Return_\PreparedValueToEarlyReturnRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\EarlyReturn\Rector\StmtsAwareInterface\ReturnEarlyIfVariableRector;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;
use Rector\Php82\Rector\Class_\ReadOnlyClassRector;
use Rector\Php82\Rector\FuncCall\Utf8DecodeEncodeToMbConvertEncodingRector;
use Rector\Php82\Rector\New_\FilesystemIteratorSkipDotsRector;
use Rector\Php83\Rector\ClassConst\AddTypeToConstRector;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\TypeDeclaration\Rector\ArrowFunction\AddArrowFunctionReturnTypeRector;
use Rector\TypeDeclaration\Rector\Class_\ReturnTypeFromStrictTernaryRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\BoolReturnTypeFromStrictScalarReturnsRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnDirectArrayRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnNewRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictBoolReturnExprRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictFluentReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictNativeCallRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictScalarReturnExprRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedCallRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnUnionTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\StrictArrayParamDimFetchRector;
use Rector\ValueObject\PhpVersion;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->parallel(120, 3200, 40);

    $rectorConfig->cacheClass(FileCacheStorage::class);
    $rectorConfig->cacheDirectory('./storage/tests/rector_cache');

    $rectorConfig->paths([
        __DIR__.'/app',
        __DIR__.'/config',
        __DIR__.'/database/factories',
        __DIR__.'/database/seeders',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ]);

    $rectorConfig->rules([
        InlineConstructorDefaultToPropertyRector::class,
        ReadOnlyClassRector::class,
        Utf8DecodeEncodeToMbConvertEncodingRector::class,
        FilesystemIteratorSkipDotsRector::class,
        AddTypeToConstRector::class,

        // Early Return
        ChangeNestedForeachIfsToEarlyContinueRector::class,
        ChangeIfElseValueAssignToEarlyReturnRector::class,
        ChangeNestedIfsToEarlyReturnRector::class,
        RemoveAlwaysElseRector::class,
        PreparedValueToEarlyReturnRector::class,
        ReturnEarlyIfVariableRector::class,

        // Code Style
        SeparateMultiUseImportsRector::class,
        NewlineAfterStatementRector::class,
        ConsistentImplodeRector::class,
        TernaryConditionVariableAssignmentRector::class,
        SymplifyQuoteEscapeRector::class,
        StringClassNameToClassConstantRector::class,
        UseIncrementAssignRector::class,
        SplitDoubleAssignRector::class,
        NewlineBeforeNewAssignSetRector::class,
        MakeInheritedMethodVisibilitySameAsParentRector::class,
        CallUserFuncArrayToVariadicRector::class,
        CallUserFuncToMethodCallRector::class,
        FuncGetArgsToVariadicParamRector::class,
        SplitGroupedPropertiesRector::class,
        SplitGroupedClassConstantsRector::class,
    ]);

    $rectorConfig->phpVersion(PhpVersion::PHP_83);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_83,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::TYPE_DECLARATION,
    ]);

    $rectorConfig->skip([
        RemoveNullPropertyInitializationRector::class,
        StaticClosureRector::class,
        AddOverrideAttributeToOverriddenMethodsRector::class,
        FirstClassCallableRector::class,
        ChangeAndIfToEarlyReturnRector::class,
        ReturnBinaryOrToEarlyReturnRector::class,
        PostIncDecToPreIncDecRector::class,

        // Type Declaration
        AddArrowFunctionReturnTypeRector::class,
        AddVoidReturnTypeWhereNoReturnRector::class,
        ReturnTypeFromReturnDirectArrayRector::class,
        ReturnTypeFromStrictBoolReturnExprRector::class,
        StrictArrayParamDimFetchRector::class,
        ReturnTypeFromStrictTypedCallRector::class,
        ReturnTypeFromReturnNewRector::class,
        ReturnTypeFromStrictNativeCallRector::class,
        ReturnTypeFromStrictScalarReturnExprRector::class,
        ReturnUnionTypeRector::class,
        BoolReturnTypeFromStrictScalarReturnsRector::class,
        ReturnTypeFromStrictTernaryRector::class,
        ReturnTypeFromStrictFluentReturnRector::class,
        StaticArrowFunctionRector::class,

        // Code Quality
        ExplicitBoolCompareRector::class,
        FlipTypeControlToUseExclusiveTypeRector::class,
        CallableThisArrayToAnonymousFunctionRector::class,
        InlineIfToExplicitIfRector::class,
        SimplifyBoolIdenticalTrueRector::class,
        CompactToVariablesRector::class,
        DisallowedEmptyRuleFixerRector::class,
        TernaryFalseExpressionToIfRector::class,
        ClosureToArrowFunctionRector::class,
    ]);
};
