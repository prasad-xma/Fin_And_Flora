<?php

declare(strict_types=1);

namespace MongoDB\BSON;

use RuntimeException;

if (!class_exists(UTCDateTime::class, false)) {
    final class UTCDateTime
    {
        public function __construct($milliseconds = null)
        {
            throw new RuntimeException('MongoDB extension (mongodb) must be installed to use MongoDB\\BSON\\UTCDateTime.');
        }

        public static function fromDateTime(\DateTimeInterface $datetime): self
        {
            throw new RuntimeException('MongoDB extension (mongodb) must be installed to use MongoDB\\BSON\\UTCDateTime.');
        }

        public function toDateTime(): \DateTimeImmutable
        {
            throw new RuntimeException('MongoDB extension (mongodb) must be installed to use MongoDB\\BSON\\UTCDateTime.');
        }
    }
}
