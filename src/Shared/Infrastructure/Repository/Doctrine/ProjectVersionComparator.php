<?php

namespace Project\Shared\Infrastructure\Repository\Doctrine;

use Doctrine\Migrations\Version\AlphabeticalComparator;
use Doctrine\Migrations\Version\Comparator;
use Doctrine\Migrations\Version\Version;
use MJS\TopSort\Implementations\ArraySort;
use Exception;

class ProjectVersionComparator implements Comparator
{
    private array $dependencies;
    private AlphabeticalComparator $defaultSorter;

    function __construct()
    {
        $this->defaultSorter = new AlphabeticalComparator();
        $this->dependencies = $this->buildDependencies();
    }

    private function buildDependencies(): array
    {
        $sorter = new ArraySort();

        $sorter->add('App\Core');
        $sorter->add('App\ModuleA', ['App\Core']);
        $sorter->add('App\ModuleB', ['App\Core']);
        $sorter->add('App\ModuleC', ['App\ModuleB']);

        return array_flip($sorter->sort());
    }

    private function getNamespacePrefix(Version $version): string
    {
        if (preg_match('~^Project\[^\]+~', (string)$version, $mch)) {
            return $mch[0];
        }

        throw new Exception('Can not find the namespace prefix for the provide migration version.');
    }

    public function compare(Version $a, Version $b): int
    {
//        dd($a, $b);
        $prefixA = $this->getNamespacePrefix($a);
        $prefixB = $this->getNamespacePrefix($b);

//        dd($prefixA, $prefixB, $a, $b);

        return $this->dependencies[$prefixA] <=> $this->dependencies[$prefixB]
            ?: $this->defaultSorter->compare($a, $b);
    }
}
