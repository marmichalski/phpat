<?php

namespace PhpAT\Parser\Ast\Type;

use PhpParser\Node;

class PhpParserTypeNodeResolver
{
    /**
     * @param Node|null $node
     * @return string[]
     */
    public function getTypeClassNames(?Node $node): array
    {
        if ($node === null) {
            return [];
        }

        switch (true) {
            case $node instanceof Node\NullableType:
                return $this->getTypeClassNames($node->type);
            case $node instanceof Node\Identifier:
            case $node instanceof Node\Name:
                return [$node->toString()];
            case $node instanceof Node\UnionType:
                foreach ($node->types as $type) {
                    $types = array_merge($types ?? [], $this->getTypeClassNames($type));
                }
                return $types ?? [];
        }

        return [];
    }
}
