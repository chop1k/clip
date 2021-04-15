# Argument
Argument is a helper class used by Distributor and Formatter.

You have to use this class if you want to override Distributor or Formatter instead of implementing the appropriate interfaces, because both use the constants and the methods of this class everywhere.

Argument defines argument-types:
- TYPE_OPTION - Option type. The option looks like "--option".
- TYPE_ABBREVIATION - Abbreviated option type. The abbreviation looks like "-a".
- TYPE_ABBREVIATIONS - List of abbreviated options. The options look like "-abs".
- TYPE_VALUE - Value type. The value looks like "value".
- TYPE_PURE_VALUE - Pure value type. It looks like value type but without quotes.
- TYPE_EQUAL_SEPARATED_OPTION - Equal-separated option type. It looks like "--option=value".
- TYPE_EQUAL_SEPARATED_ABBREVIATION - Equal-separated abbreviation type. It looks like "-a=value".
- TYPE_EQUAL_SEPARATED_ABBREVIATIONS - Equal-separated abbreviations type. It looks like "-abs=value".

Argument defines functions for defining types:
- isOption - Returns true if argument is option.
- isAbbreviation - Returns true if the argument is an abbreviated option.
- isAbbreviations - Returns true if the argument is an array of abbreviated options.
- isValue - Returns true if the argument is a value.
- isPureValue - Returns true if the argument is a pure value.
- isEqualSeparated - Returns true if option is an equal separated option.
- isCommand - Returns true if the argument is a command.
- isUtility - Returns true if the argument is a utility.

Argument defines functions for type conversion:
- toOption - Adds prefix to the argument and returns it.
- toAbbreviation - Adds prefix to the argument and returns it.
- toValue - Adds quotes to the argument and returns it.
- toPureValue - Clears the argument and returns it.
- toEqualSeparated - Adds equal-separation between option and value.

Other methods:
- clear - Trims special symbols.
- explodeEqualSeparated - Shortcut for exploding a given argument if the argument is equal separated option.