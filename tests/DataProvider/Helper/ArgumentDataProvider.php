<?php

namespace Consolly\Tests\DataProvider\Helper;

class ArgumentDataProvider
{
    public function getClearArguments(): array
    {
        return [
            [
                '"value"', 'value'
            ],
            [
                "'value'", 'value'
            ],
            [
                '--option', 'option'
            ],
            [
                '---option', 'option'
            ],
            [
                '-a', 'a'
            ],
            [
                '-abs', 'abs'
            ],
            [
                '  value  ', 'value'
            ],
            [
                '--value--', 'value'
            ],
            [
                '- "\' value "\'-- ', 'value'
            ]
        ];
    }

    public function getExplodeEqualSeparatedOptionArguments(): array
    {
        return [
            [
                '--option=value', ['--option', 'value']
            ],
            [
                '-a=value', ['-a', 'value']
            ],
            [
                '-abs=value', ['-abs', 'value']
            ],
            [
                'value=value', ['value', 'value']
            ],
            [
                'value=value=value', ['value', 'value=value']
            ],
            [
                'value= value', ['value', ' value']
            ]
        ];
    }

    public function getIsOptionArguments(): array
    {
        return [
            [
                '--option', true
            ],
            [
                '--option=value', false
            ],
            [
                '-a', false
            ],
            [
                '-a=value', false
            ],
            [
                '-abs', false
            ],
            [
                '-abs=value', false
            ],
            [
                'value', false
            ],
            [
                '"value"', false
            ],
            [
                "'value'", false
            ]
        ];
    }

    public function getIsAbbreviationArguments(): array
    {
        return [
            [
                '--option', false
            ],
            [
                '--option=value', false
            ],
            [
                '-a', true
            ],
            [
                '-a=value', false
            ],
            [
                '-abs', false
            ],
            [
                '-abs=value', false
            ],
            [
                'value', false
            ],
            [
                '"value"', false
            ],
            [
                "'value'", false
            ]
        ];
    }

    public function getIsAbbreviationsArguments(): array
    {
        return [
            [
                '--option', false
            ],
            [
                '--option=value', false
            ],
            [
                '-a', false
            ],
            [
                '-a=value', false
            ],
            [
                '-abs', true
            ],
            [
                '-abs=value', false
            ],
            [
                'value', false
            ],
            [
                '"value"', false
            ],
            [
                "'value'", false
            ]
        ];
    }

    public function getIsValueArguments(): array
    {
        return [
            [
                '--option', false
            ],
            [
                '--option=value', false
            ],
            [
                '-a', false
            ],
            [
                '-a=value', false
            ],
            [
                '-abs', false
            ],
            [
                '-abs=value', false
            ],
            [
                'value', false
            ],
            [
                '"value"', true
            ],
            [
                "'value'", true
            ]
        ];
    }

    public function getIsPureValueArguments(): array
    {
        return [
            [
                '--option', false
            ],
            [
                '--option=value', false
            ],
            [
                '-a', false
            ],
            [
                '-a=value', false
            ],
            [
                '-abs', false
            ],
            [
                '-abs=value', false
            ],
            [
                'value', true
            ],
            [
                '"value"', false
            ],
            [
                "'value'", false
            ]
        ];
    }

    public function getToOptionArguments(): array
    {
        return [
            [
                'option', '--option'
            ]
        ];
    }

    public function getToAbbreviationArguments(): array
    {
        return [
            [
                'a', '-a'
            ],
            [
                'abs', '-abs'
            ]
        ];
    }

    public function getToEqualSeparatedArguments(): array
    {
        return [
            [
                'value', 'value', 'value=value'
            ],
            [
                '--option', 'value', '--option=value'
            ],
            [
                '-a', 'value', '-a=value'
            ],
            [
                '-abs', 'value', '-abs=value'
            ]
        ];
    }

    public function getToValueArguments(): array
    {
        return [
            [
                'value', '"value"'
            ],
            [
                '"value"', '"value"'
            ],
            [
                "'value'", '"value"'
            ]
        ];
    }

    public function getToPureValueArguments(): array
    {
        return [
            [
                'value', 'value'
            ],
            [
                '"value"', 'value'
            ],
            [
                "'value'", 'value'
            ]
        ];
    }
}
